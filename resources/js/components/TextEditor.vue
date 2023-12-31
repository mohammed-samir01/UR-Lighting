<template>
    <div>

        <ul class="nav nav-tabs" id="myTabs">
            <li class="nav-item">
                <a class="nav-link " :class="{'active': lang === 'sa'}" id="tab1-tab" data-toggle="tab"
                   href="#tab1">{{ $t('arabic') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" :class="{'active': lang === 'en'}" id="tab2-tab" data-toggle="tab"
                   href="#tab2">{{ $t('english') }}</a>
            </li>

        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show " :class="{'active': lang === 'sa'}" id="tab1">
                <quill-editor :modules="modules" theme="snow" ref="quill1" toolbar="full" v-model:content="ar_content"
                              content-type="html"></quill-editor>
            </div>
            <div class="tab-pane fade show" id="tab2" :class="{'active': lang === 'en'}">
                <quill-editor :modules="modules" theme="snow" ref="quill2" toolbar="full" v-model:content="en_content"
                              content-type="html"></quill-editor>
            </div>
            <div class="form-group">
                <button class="btn btn--primary mt-2 px-5" @click="save" :disabled="loading">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                          v-if="loading"></span>
                    {{ $t('save') }}
                </button>
            </div>

        </div>

    </div>
</template>


<script>

import Quill from 'quill';

import {QuillEditor} from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import * as Emoji from "quill-emoji";
import Form from "quill-form"
import "quill-emoji/dist/quill-emoji.css";

import BlotFormatter from 'quill-blot-formatter'


export default {
    name: "TextEditor",
    props: ['url', 'data'],
    components: {
        QuillEditor
    },
    data() {
        return {
            ar_content: '',
            en_content: '',
            loading: false,

            modules:
                [
                    {
                        name: 'blotFormatter',
                        module: BlotFormatter,

                    },
                    {
                        name: 'form',
                        module: Form,

                    },
                    // {
                    //     name: 'emoji',
                    //     module: Emoji,
                    //     options:{
                    //         "emoji-toolbar": true,
                    //         "emoji-textarea": true,
                    //         "emoji-shortname": true,
                    //     }
                    // },
                ]


        }
    },
    mounted() {

        // if (Quill) {
        //     Quill.register(this.$refs.quill1,'modules/emoji', Emoji);
        // } else {
        //     console.error('Quill is not defined. Make sure it is imported correctly.');
        // }


        this.$refs.quill1.setContents(this.data?.ar)
        this.$refs.quill2.setContents(this.data?.en)
    },
    computed: {
        lang() {
            return app_lang
        }
    },
    methods: {
        save() {

            this.loading = true
            axios.post(this.url, {
                '_token': csrf,
                'ar_content': this.ar_content,
                'en_content': this.en_content,
                'status': $('#seller_pos') ? $('#seller_pos').is(':checked') : ''
            }).then((res) => {
                this.loading = false
                toastr.success(this.$t('successfullySave'))
            }).catch(() => {
                this.loading = false
                toastr.error('error')
            })
        }
    }
}
</script>


<style>
.ql-container {
    height: 300px !important;
}
</style>
