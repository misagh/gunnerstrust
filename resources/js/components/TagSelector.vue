<template>
    <div class="tag-selector">
        <div class="input-group mb-3">
            <input type="text" name="tags" class="form-control" :value="inputTags" required>
            <div class="input-group-append" v-show="tags.selector">
                <button type="button" class="btn btn-info" @click="makeTags">لیست تگ ها</button>
            </div>
        </div>
        <h4 class="cursor-pointer">
            <span class="badge badge-dark mr-2" v-for="newTag in newTags" @click="addTag(newTag)">{{ newTag }}</span>
        </h4>
    </div>
</template>

<script>
    export default {

        props: ['tags'],

        data: function ()
        {
            return {
                newTags: [],
                listTags: [],
                inputTags: '',
            }
        },

        created()
        {
            this.inputTags = this.tags.tags;
        },

        methods: {
            makeTags()
            {
                var titleTags = this.tags.title.trim().split(' ');

                this.newTags = [];

                for (const titleTag in titleTags)
                {
                    this.newTags.push(titleTags[titleTag]);
                }

                for (const titleTag in titleTags)
                {
                    const nextTag = titleTags[parseInt(titleTag) + 1];

                    if (typeof nextTag !== 'undefined')
                    {
                        this.newTags.push(titleTags[titleTag] + '_' + nextTag);
                    }
                }
            },

            addTag(tag)
            {
                if (this.inputTags === '')
                {
                    this.listTags = [];
                }
                else
                {
                    this.listTags = this.inputTags.split(',');
                }

                this.listTags.push(tag);

                this.createInputTag();
            },

            createInputTag()
            {
                this.inputTags = this.listTags.join(',');
            }
        }
    }
</script>
