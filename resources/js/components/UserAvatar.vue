<template>
    <div class="avatar-uploader">
        <vue-avatar :width="200" :height="200" :scale="scale" ref="vueavatar" @vue-avatar-editor:image-ready="onImageReady"></vue-avatar>
        <div class="mr-5 pr-3" v-if="showScale">
            <div class="mt-2 d-block">
                <small class="mt-2 d-block mr-4 pr-3">تغییر اندازه</small>
                <input type="range" min="1" max="3" step="0.02" dir="ltr" v-model="scale">
            </div>
            <button class="btn btn-success mr-3 mt-2" @click="saveClicked">ذخیره تغییرات</button>
        </div>
        <small v-else>
            <span class="mr-sm-5">برای تغییر آواتار روی آن کلیک کنید.</span>
        </small>
        <img ref="image">
    </div>
</template>

<script>
    import {VueAvatar} from 'vue-avatar-editor-improved';

    export default {

        props: ['avatar'],

        data: function ()
        {
            return {
                scale: 1,
                rotation: 0,
                showScale: false
            }
        },

        mounted()
        {
            var canvas = document.getElementById("avatarEditorCanvas");
            var ctx = canvas.getContext("2d");
            var background = new Image();

            background.src = this.avatar.src;
            background.onload = function ()
            {
                ctx.drawImage(background, 25, 25, 200, 200);
            }
        },

        components: {
            VueAvatar
        },

        methods: {
            saveClicked()
            {
                let avatar = this.dataURItoBlob(this.$refs.vueavatar.getImageScaled().toDataURL());
                let settings = {headers: {'content-type': 'multipart/form-data'}};
                let data = new FormData();

                data.append('avatar', avatar, avatar.name);

                axios.post('/avatars/add', data, settings)
                    .then(({data}) =>
                    {
                        location.reload();
                    });
            },
            onImageReady()
            {
                this.showScale = true;
            },
            dataURItoBlob(dataURI)
            {
                var byteString = atob(dataURI.split(',')[1]);
                var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0]
                var ab = new ArrayBuffer(byteString.length);
                var ia = new Uint8Array(ab);

                for (var i = 0; i < byteString.length; i ++)
                {
                    ia[i] = byteString.charCodeAt(i);
                }

                var blob = new Blob([ab], {type: mimeString});

                return blob;
            }

        }
    }
</script>
