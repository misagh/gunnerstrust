<template>
    <div class="comment-box">
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
        <div v-else class="alert alert-danger">برای ارسال نظر لطفا وارد سایت شوید.</div>
        <div class="card shadow mb-3" v-for="comment in comments" :key="comment.id">
            <div class="card-header p-0">
                <div class="username position-absolute float-right text-center text-white eng-font" :class="'username-' + comment.user.role">
                    <b><a :href="'/users/profile/' + comment.user.username">{{ comment.user.username }}</a></b>
                </div>
                <div class="float-left small m-2 px-2 py-1">{{ comment.posted_at }}</div>
            </div>
            <div class="card-body pb-2">
                <p v-if="comment.edit">
                    <textarea rows="5" class="form-control mb-3" v-model="commentBodyEdited"></textarea>
                    <button type="button" class="btn btn-success" @click="editComment(comment.id)">ذخیره تغییرات</button>
                    <button type="button" class="btn btn-secondary" @click="comment.edit = false">انصراف</button>
                </p>
                <div v-else class="card-text">
                    <div class="float-right mr-3 mb-3">
                        <a :href="'/users/profile/' + comment.user.username">
                            <img class="rounded-circle shadow" :src="comment.user.avatar" width="100">
                        </a>
                    </div>
                    <p class="comment-body" v-html="comment.body"></p>
                </div>
                <div v-if="user" class="d-block clearfix pt-3 mb-2">
                    <div class="float-left position-relative" v-if="comment.reactions.length > 0 || ! comment.own_comment">
                        <div class="emojies shadow-sm py-1 position-absolute eng-font" v-show="comment.emojies">
                            <div class="d-inline-block m-2 cursor-pointer" v-for="emoji in emojies">
                                <img v-bind:src="'/img/emoji/' + emoji + '.png'" width="28" @click="addReaction(comment.id, emoji)">
                            </div>
                        </div>
                        <span class="cursor-pointer d-inline-block mt-2 ml-2" v-if="! comment.own_comment">
                            <i class="show-emojies text-muted fas fa-lg fa-smile" @click="showReactionEmojies(comment.id)"></i>
                        </span>
                        <div class="reaction-box d-inline-block float-right mx-1 cursor-pointer" v-for="data in comment.reaction_data" :class="{'bg-secondary text-white': data.user}" data-toggle="modal" data-target="#reactionModal" @click="reactionUsers(comment.id)">
                            <span class="font-weight-bold">{{ data.count }}</span>
                            <img v-bind:src="'/img/emoji/' + data.reaction + '.png'" width="20">
                        </div>
                    </div>
                    <div class="float-right" v-if="((user && user.role === 'admin') || comment.own_comment) && ! comment.edit">
                        <button type="button" class="btn btn-outline-secondary btn-sm" @click="comment.edit = true, commentBodyEdited = comment.body">ویرایش</button>
                        <div class="d-inline-block">
                            <vue-confirmation-button :messages="customMessages" :css="customCss" v-on:confirmation-success="deleteComment(comment.id)"></vue-confirmation-button>
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
                    <div class="modal-header py-2 text-white bg-dark" v-if="! loadingReactions">
                        <h6 class="modal-title">
                            <span>مجموع واکنش ها:</span> <span class="font-weight-bold" v-text="reactionsCount"></span>
                        </h6>
                    </div>
                    <div class="modal-body pt-2">
                        <span class="d-block text-center mt-3" v-if="loadingReactions"><i class="fas fa-spin fa-spinner fa-lg"></i></span>
                        <div class="row" v-if="! loadingReactions">
                            <div class="col-6 mt-2 ml-auto text-right" v-for="reactionList in reactionLists">
                                <span class="mr-2 eng-font font-weight-bold"><a :href="'/users/profile/' + reactionList.user.username" target="_blank">{{ reactionList.user.username }}</a></span>
                                <img v-bind:src="'/img/emoji/' + reactionList.reaction + '.png'" width="20">
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
            this.fetchComments();
        },

        created()
        {
            let self = this;

            window.addEventListener('click', function (e)
            {
                if (!e.target.className.includes('show-emojies'))
                {
                    self.comments.filter(comment =>
                    {
                        return comment.emojies = false;
                    });
                }
            });
        },

        data: function ()
        {
            return {
                emojies: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                comments: [],
                reactionLists: [],
                user: '',
                limit: 20,
                offset: 0,
                loadMore: false,
                loading: false,
                loadingComment: false,
                loadingReactions: true,
                reactionsCount: 0,
                showEmojies: false,
                commentBody: '',
                commentBodyEdited: '',
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
                    })
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
            showReactionEmojies(id)
            {
                this.comments.filter(comment =>
                {
                    let show = (comment.id === id);

                    if (show && comment.emojies)
                    {
                        show = false;
                    }

                    return comment.emojies = show;
                });
            },
            addReaction(id, emoji)
            {
                axios.post('/comments/reaction/add/' + id + '/' + emoji)
                    .then(({data}) =>
                    {
                        this.comments.filter(comment =>
                        {
                            if (comment.id === id)
                            {
                                return comment.reaction_data = data.comment.reaction_data;
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
            reactionUsers(id)
            {
                this.reactionLists = [];
                this.loadingReactions = true;

                axios.post('/comments/reaction/list/' + id)
                    .then(({data}) =>
                    {
                        this.loadingReactions = false;
                        this.reactionLists = data.reactions;
                        this.reactionsCount = data.reactions.length;
                    });
            }
        }
    }
</script>
