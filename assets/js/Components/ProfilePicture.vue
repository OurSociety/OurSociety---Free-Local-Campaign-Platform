<template>
    <div>
        <vue-clip :options="options" class="uploader">

            <template slot="clip-uploader-action" scope="props">
                <div class="uploader-action" v-bind:class="{dragging: props.dragging}">
                    <div class="dz-message">
                        Drop image here or click to browse
                    </div>
                </div>
            </template>

            <template slot="clip-uploader-body" scope="props">
                <div v-if="props.files">

                    <div v-if="imageData.pictureUrl">
                        <img :src="imageData.pictureUrl" class="img-responsive">
                    </div>
                    <div v-else>
                        <svg
                            data-jdenticon-value="asda"
                            alt="$alternateText"
                            width="100%"
                        ></svg>
                    </div>

                </div>
                <div v-else>

                    <div class="uploader-files">
                        <div class="uploader-file" v-for="file in props.files">
                            <div class="file-avatar">
                                <img v-bind:src="file.dataUrl" />
                            </div>
                            <div class="file-details">
                                <div class="file-name">
                                    {{ file.name }}
                                </div>

                                <div class="file-progress" v-if="file.status !== 'error' && file.status !== 'success'">
                                    <span class="progress-indicator" v-bind:style="{width: file.progress + '%'}"></span>
                                </div>

                                <div class="file-meta" v-else>
                                    <span class="file-size">{{ file.size }}</span>
                                    <span class="file-status">{{ file.status }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </template>

        </vue-clip>
    </div>
</template>

<script>
    import Vue from 'vue';
    import VueClip from 'vue-clip';

    export default {
        props: ['imageData'],
        data: function () {
            return {
                options: {
                    url: '/politician/profile/picture'
                },
                //files: []
            };
        },
        mounted() {
            console.log('Profile Picture component mounted.');
        }
    };
</script>

<style lang="scss" type="text/scss" scoped>
    @import '../../sass/app/data/variables';

    html, body {
        height: 100%;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        background: #e8e8e8;
        font-family: 'Open Sans', sans-serif;
        font-size: 16px;
        color: #60656a;
    }


    .uploader {
        width: 100%;
        height: 490px;
        display: flex;
        border-radius: 6px;
        box-shadow: 1px 2px 19px rgba(195, 195, 195, 0.43);
        flex-direction: column-reverse;
        background: #fff;
    }

    .uploader * {
        box-sizing: border-box;
    }

    .uploader-action {
        padding: 20px;
        background: #f1f6ff;
        cursor: pointer;
        transition: background 300ms ease;
    }

    .uploader-action .dz-message {
        color: #94a7c2;
        text-align: center;
        padding: 20px 40px;
        border: 3px dashed #dfe8fe;
        border-radius: 3px;
        font-size: 16px;
    }

    .uploader-files {
        flex: 1;
        padding: 40px;
    }

    .file-details {
        flex: 1;
    }

    .file-name {
        color: #bebfc1;
        font-weight: 500;
        margin-bottom: 2px;
    }

    .uploader-file.upload .file-name {
        color: inherit;
    }

    .file-progress {
        background: #e3ebfa;
        border-radius: 8px;
        height: 4px;
        width: 80%;
    }

    .progress-indicator {
        display: block;
        background: #00d28a;
        border-radius: 8px;
        height: 4px;
    }

    .file-size {
        font-weight: 600;
        color: #bebfc1;
    }

    .file-status {
        font-size: 12px;
        text-transform: uppercase;
        margin-left: 5px;
    }

    .uploader-action.dragging {
        background: #ffffff;
    }

    @keyframes slideUpIn {
        0% {
            opacity: 0;
            transform: translateY(10%);
        }

        100% {
            opacity: 1;
            transform: none;
        }
    }
</style>
