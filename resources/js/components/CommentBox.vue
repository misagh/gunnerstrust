<template>
    <div class="comment-box">
        <div v-if="commentable.type">
            <div v-if="commentable.auth" class="accordion mb-4" id="newComment">
                <div class="card bg-gradient-success text-white">
                    <div class="card-header" id="newCommentHead">
                        <h2 class="mb-0">
                            <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#newCommentArea" aria-expanded="true" aria-controls="newCommentArea">
                                <span><i class="fas fa-comment-dots mr-2"></i>ارسال نظر جدید</span>
                            </button>
                        </h2>
                    </div>
                    <div id="newCommentArea" class="collapse" aria-labelledby="newCommentHead" data-parent="#newComment">
                        <div class="card-body text-center">
                            <div v-if="loadingComment">
                                <span class="d-block mt-3"><i class="fas fa-spin fa-spinner fa-lg"></i></span>
                            </div>
                            <div v-else>
                                <textarea name="body" class="form-control border border-dark shadow" v-model="commentBody" rows="4" required></textarea>
                                <button type="submit" class="btn btn-dark mt-3 px-4" @click="addComment">ثبت نظر</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="alert alert-danger overflow-hidden">
                <span class="float-right my-1">برای ارسال نظر لطفا وارد سایت شوید.</span>
                <span class="float-left">
                    <a href="/login/google" class="btn btn-success btn-sm">ورود با گوگل<i class="fab fa-google ml-1"></i></a>
                    <a href="/login" class="btn btn-info btn-sm">ورود با نام کاربری</a>
                </span>
            </div>
        </div>
        <div class="card shadow mb-3" v-for="comment in comments" :key="comment.id">
            <div class="card-header p-0">
                <div class="username username-user position-absolute float-right text-center text-white eng-font">
                    <b><a :href="'/users/profile/' + comment.user.username">{{ comment.user.username }}</a></b>
                    <img class="rounded-circle shadow mr-1" :src="comment.user.avatar" width="35">
                </div>
                <div class="float-left text-muted small m-2 px-2 py-1">
                    <span>{{ comment.posted_at }}</span>
                    <span v-if="webShareApiSupported" @click="shareViaWebShare(comment.short)"><i class="fas fa-share-alt fa-lg ml-2 text-secondary"></i></span>
                    <a v-else :href="comment.short"><i class="fas fa-share-alt fa-lg ml-2 text-secondary"></i></a>
                </div>
            </div>
            <div class="card-body p-2 p-md-3">
                <p v-if="comment.edit">
                    <textarea rows="5" class="form-control mb-3" v-model="commentBodyEdited"></textarea>
                    <button type="button" class="btn btn-success" @click="editComment(comment.id)">ذخیره تغییرات</button>
                    <button type="button" class="btn btn-secondary" @click="comment.edit = false">انصراف</button>
                </p>
                <div v-else class="card-text">
                    <p class="comment-body" v-html="comment.body"></p>
                </div>
                <div v-if="comment.likes.length > 0 || commentable.auth" class="d-block clearfix mt-0 mt-md-3">
                    <div class="float-left position-relative eng-font" v-if="comment.likes.length > 0 || ! comment.own_comment">
                        <div v-if="user && ! comment.own_comment">
                            <span class="cursor-pointer d-inline-block mt-2 ml-2">
                                <i :class="(comment.like_data.user ? 'text-danger fas' : 'far') + ' fa-heart fa-lg'" @click="addLike(comment)"></i>
                            </span>
                            <div v-if="comment.like_data.count > 0" class="d-inline-block">
                                <span class="cursor-pointer mt-2 ml-2" data-toggle="modal" data-target="#reactionModal" @click="likeUsers(comment.id)">
                                    <b>{{ comment.like_data.count }}</b>
                                </span>
                            </div>
                        </div>
                        <div v-if="(! user || comment.own_comment) && comment.like_data.count > 0">
                            <div class="d-inline-block cursor-pointer" data-toggle="modal" data-target="#reactionModal" @click="likeUsers(comment.id)">
                                <span class="d-inline-block mt-2 ml-2">
                                    <i :class="(comment.own_comment ? 'far' : 'text-danger fas') + ' fa-heart fa-lg'"></i>
                                </span>
                                <span class="mt-2 ml-2">
                                    <b>{{ comment.like_data.count }}</b>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="float-right mt-1" v-if="commentable.auth">
                        <div v-if="! comment.edit" class="d-inline-block">
                            <button type="button" class="btn btn-danger btn-sm" @click="comment.reply = true">پاسخ</button>
                        </div>
                        <div v-if="(user.role === 'admin' || comment.own_comment) && ! comment.edit" class="d-inline-block">
                            <button type="button" class="btn btn-outline-secondary btn-sm" @click="comment.edit = true, commentBodyEdited = comment.body">ویرایش</button>
                            <div class="d-inline-block">
                                <vue-confirmation-button :messages="customMessages" :css="customCss" v-on:confirmation-success="deleteComment(comment.id)"></vue-confirmation-button>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="comment.reply">
                    <textarea rows="2" class="form-control my-2" v-model="commentBodyReply" required></textarea>
                    <button type="button" class="btn btn-success" @click="replyComment(comment)">ارسال پاسخ</button>
                    <button type="button" class="btn btn-secondary" @click="comment.reply = false">انصراف</button>
                </div>
            </div>
            <div class="card-footer p-0" v-if="comment.replies_list.length > 0 || comment.force_reply_open">
                <div class="accordion" :id="'accordionReplies' + comment.id">
                    <div class="card border-0">
                        <div class="card-header p-0" :id="'headingReplies' + comment.id">
                            <h2 class="mb-0 text-center">
                                <button class="btn btn-link text-muted btn-sm mx-auto dropdown-toggle" type="button" data-toggle="collapse" :data-target="'#collapseReplies' + comment.id" aria-expanded="true" :aria-controls="'collapseReplies' + comment.id">نمایش پاسخ ها ({{ comment.replies_list.length }})</button>
                            </h2>
                        </div>
                        <div :id="'collapseReplies' + comment.id" :class="'collapse' + (comment.replies_list.length === 1 || comment.force_reply_open ? ' show' : '')" :aria-labelledby="'headingReplies' + comment.id" :data-parent="'#accordionReplies' + comment.id">
                            <div class="card-body p-2">
                                <div v-for="(reply, index) in comment.replies_list">
                                    <div class="media">
                                        <img :src="reply.user.avatar" class="mr-2 shadow-sm" width="24">
                                        <div class="media-body">
                                            <h6 class="m-0 font-weight-bold">
                                                <a :href="'/users/profile/' + reply.user.username">{{ reply.user.username }}</a>
                                            </h6>
                                            <p class="comment-body" v-html="reply.body"></p>
                                        </div>
                                    </div>
                                    <hr class="my-2" v-if="index !== (comment.replies_list.length - 1)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="comment-more text-center mt-4">
            <button type="button" class="btn btn-outline-secondary" @click="moreComments" v-show="loadMore">نمایش نظرات بیشتر</button>
            <span class="d-block mt-3" v-if="loading"><i class="fas fa-spin fa-spinner fa-lg"></i></span>
        </div>
        <div class="modal fade" id="reactionModal" tabindex="-1" role="dialog" aria-labelledby="reactionModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header py-2 text-white bg-dark" v-if="! loadingLikes">
                        <h6 class="modal-title">
                            <span>مجموع لایک ها:</span> <span class="font-weight-bold" v-text="likesCount"></span>
                        </h6>
                    </div>
                    <div class="modal-body pt-2">
                        <span class="d-block text-center mt-3" v-if="loadingLikes"><i class="fas fa-spin fa-spinner fa-lg"></i></span>
                        <div class="row" v-if="! loadingLikes">
                            <div class="col-6 mt-2 ml-auto text-right" v-for="likeList in likeLists">
                                <span class="mr-2 eng-font font-weight-bold"><a :href="'/users/profile/' + likeList.user.username" target="_blank">{{ likeList.user.username }}</a></span>
                                <img src="/img/emoji/10.png" width="20">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import vueConfirmationButton from 'vue-confirmation-button';

    export default {

        props: ['commentable'],

        mounted()
        {
            if (this.commentable.type)
            {
                this.fetchComments();
            }
            else
            {
                this.fetchComment();
            }
        },

        computed: {
            webShareApiSupported()
            {
                return navigator.share;
            }
        },

        data: function ()
        {
            return {
                comments: [],
                likeLists: [],
                like: false,
                user: '',
                limit: 20,
                offset: 0,
                loadMore: false,
                loading: false,
                loadingComment: false,
                loadingLikes: true,
                likesCount: 0,
                commentBody: '',
                commentBodyEdited: '',
                commentBodyReply: '',
                customCss: 'btn btn-sm btn-outline-secondary',
                customMessages: [
                    'حذف',
                    'مطمئن هستید؟',
                    ''
                ]
            }
        },

        components: {
            'vue-confirmation-button': vueConfirmationButton,
        },

        methods: {
            fetchComments()
            {
                axios.get('/comments/fetch/' + this.commentable.type + '/' + this.commentable.id + '?offset=' + this.offset)
                    .then(({data}) =>
                    {
                        this.comments = this.comments.concat(data.comments);
                        this.loadMore = data.comments.length === this.limit;
                        this.offset += this.limit;
                        this.user = data.user;
                        this.loading = false;
                    });
            },
            fetchComment()
            {
                axios.get('/comments/fetch-one/' + this.commentable.comment)
                    .then(({data}) =>
                    {
                        if (data.comments.replies_list.length > 0)
                        {
                            data.comments.force_reply_open = true;
                        }

                        this.comments = this.comments.concat(data.comments);
                        this.user = data.user;
                        this.loading = false;
                    });
            },
            moreComments()
            {
                this.loading = true;

                this.fetchComments();
            },
            addComment()
            {
                if (this.commentBody.length > 0)
                {
                    this.loadingComment = true;

                    axios.post('/comments/add/' + this.commentable.type + '/' + this.commentable.id, {
                            body: this.commentBody
                        })
                        .then(({data}) =>
                        {
                            this.comments = data.comments;
                            this.loadingComment = false;
                            this.commentBody = '';
                        });
                }
            },
            addLike(comment)
            {
                let liked = comment.like_data.user;
                let id = comment.id;

                comment.like_data.user = ! liked;
                comment.like_data.count = comment.like_data.count + (liked ? -1 : 1);

                axios.post('/comments/like/add/' + comment.id)
                    .then(({data}) =>
                    {
                        this.comments.filter(comment =>
                        {
                            if (comment.id === id)
                            {
                                return comment.like_data = data.comment.like_data;
                            }
                        });
                    });
            },
            deleteComment(id)
            {
                axios.post('/comments/delete/' + id)
                    .then(({data}) =>
                    {
                        this.comments = this.comments.filter(comment =>
                        {
                            return comment.id !== id;
                        });
                    });
            },
            editComment(id)
            {
                axios.post('/comments/edit/' + id, {
                        body: this.commentBodyEdited
                    })
                    .then(({data}) =>
                    {
                        this.comments = this.comments.filter(comment =>
                        {
                            if (comment.id === id)
                            {
                                comment.edit = false;
                                comment.body = data.comments.body;
                            }

                            return comment;
                        });
                    });
            },
            replyComment(sourceComment)
            {
                const bodyReply = this.commentBodyReply;

                if (bodyReply.length > 0)
                {
                    this.commentBodyReply = '';

                    axios.post('/comments/reply/' + sourceComment.id, {
                            body: bodyReply
                        })
                        .then(({data}) =>
                        {
                            this.comments = this.comments.filter(comment =>
                            {
                                if (comment.id === sourceComment.id)
                                {
                                    comment.replies_list = data.comments.replies_list;
                                }

                                return comment;
                            });

                            sourceComment.reply = false;
                            sourceComment.force_reply_open = true;
                        });
                }
            },
            likeUsers(id)
            {
                this.likeLists = [];
                this.loadingLikes = true;

                axios.post('/comments/like/list/' + id)
                    .then(({data}) =>
                    {
                        this.loadingLikes = false;
                        this.likeLists = data.likes;
                        this.likesCount = data.likes.length;
                    });
            },
            shareViaWebShare(url)
            {
                navigator.share({
                    url: url
                })
            }
        }
    }
</script>
