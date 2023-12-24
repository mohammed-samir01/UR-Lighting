<template>
    <div>

        <ul class="nav nav-tabs" id="myTabs">
            <li class="nav-item">
                <a class="nav-link " :class="{'active': lang === 'sa'}" id="tab1-tab" data-toggle="tab"
                   href="#tab1">عربى</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" :class="{'active': lang === 'en'}" id="tab2-tab" data-toggle="tab" href="#tab2">انجليزى</a>
            </li>

        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show " :class="{'active': lang === 'sa'}" id="tab1">
                <quill-editor theme="snow" ref="quill1" toolbar="full" v-model:content="ar_content" content-type="html"></quill-editor>
            </div>
            <div class="tab-pane fade show" id="tab2" :class="{'active': lang === 'en'}">
                <quill-editor theme="snow" ref="quill2" toolbar="full" v-model:content="en_content" content-type="html"></quill-editor>
            </div>
            <div class="form-group">
                <button class="btn btn--primary mt-2 px-5" @click="save">{{ $t('save') }}</button>
            </div>

        </div>

    </div>
</template>


<script>


import {QuillEditor, Quill} from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';


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
        }
    },
    mounted() {

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
            console.log(csrf)
            axios.post(this.url, {
                '_token': csrf,
                'ar_content': this.ar_content,
                'en_content': this.en_content,
            }).then((res) => {

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
