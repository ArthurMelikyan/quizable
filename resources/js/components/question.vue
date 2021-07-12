<template>
<form action="" v-if="item.check" v-show="showQuestionAnswer" @submit.prevent="createQuestionAnswer(index, $event)"
        :data-index="index" class="questionItem">
    <!--<div v-if="!showQuestionAnswer" class="d-flex block-1 align-items-center mb-4">
        <p class="m-0">{{questionName}}</p>
        <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md ml-auto"
            title="Edit details" @click.prevent="editQuestionAnswer">
            <i class="flaticon-edit"></i>
        </a>
    </div>-->
    <button type="button" class="questionDelete rounded" @click.prevent="questionDelete(index)">
        <i class="fas fa-window-close"></i>
    </button>
    <div class="modal fade questionCreateModel" :data-id="index" :id="'exampleModalCenter'+index" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Question {{questionNavigation.checkLangType }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group" v-show="questionNavigation.file_type.url">
                        <label :for="'url'+index"><b> Set your file url </b></label>
                        <input type="text" class="form-control" :id="'url'+index"
                                @input="questionNavigationUrlChange"
                                v-model="questionNavigation.url" :placeholder="question_file_type">
                        <div v-if="error.validUrl" class="mt-1" style="color: red">
                                Please enter correct values
                        </div>
                        <div v-if="error.validUrlYoutube" class="mt-1" style="color: red">
                            Please enter correct Youtube video url
                        </div>
                    </div>
                    <div class="form-group  align-items-center" :class="{'d-md-flex' : questionNavigation.class}"
                            v-show="questionNavigation.file_type.file">
                        <div v-if="questionNavigation.class"
                                class="position-relative create-question-img-preview "
                                :class="{'my-style block-5': questionNavigation.class}">
                            <img :src="questionNavigation.file_url" alt="">
                        </div>
                        <div class=" align-items-center ">
                            <div class="custom-file w-auto">
                                <input type="file" class="custom-file-input "   :accept="(questionNavigation.file_type.name == 'image') ? 'image/x-png,image/jpeg' : 'video/mp4,video/x-m4v,video/*'" :id="'c-file'+index"
                                        @change="getFileQuestion($event, index)">
                                <label class="custom-file-label overflow-hidden" :for="'c-file'+index">
                                    Choose file
                                </label>
                            </div>

                        </div>
                        <div class="position-relative create-question-video-preview " style="margin-bottom: -25px;" v-if="questionNavigation.videoBlock_show">
                            <video :src="questionNavigation.file_video_url" width="100%" height="100%" class="mt-3" controls></video>
                        </div>

                    </div>
                    <div v-if="error.validUploadFile" class="mt-1" style="color: red">
                        Please select {{ questionNavigation.checkLangType__}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button v-if="formChanged" type="button" class=" btn btn-secondary"
                            @click="questionNavigationFileClear('quiz.Choose file', index)">  Clear
                    </button>
                    <button type="button" class="btn btn-primary" v-if="modal_button_save" data-dismiss="modal">
                            Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="border pt-3 pb-3">
        <div class="mb-5 mt-2 questionCreatePanel">
            <div class="form-group mb-0" @mouseover="showEditNavigation()" @mouseout="hide">

                <div class="col-md-12">
                    <label :for="'Q'+(index+1)" class="questionCount ">{{ trans('__quiz__.Question') }} <span>{{': '+(index+1)}}</span></label>
                        <div class="d-flex justify-content-between">
                            <div v-if="check_if_enabled('enable_video_and_image_navigations')" class="questionsNavigationButton" :class="{'_show':showNavigation}" data-toggle="modal"
                                :data-target="'#exampleModalCenter'+index">
                                <button style="margin-right: -4px;" @click.prevent="questionNavigationControl('image', 'image', 'quiz.Choose file', index, 'jpeg | jpg | png ', 'image')">
                                    <svg class="bi bi-card-image"
                                        width="1.4em" height="1.4em"
                                        viewBox="0 0 16 16"
                                        fill="currentColor"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                        <path
                                            d="M10.648 7.646a.5.5 0 0 1 .577-.093L15.002 9.5V13h-14v-1l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71z"/>
                                        <path fill-rule="evenodd"
                                            d="M4.502 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                                    </svg>
                                </button>
                                <button @click.prevent="questionNavigationControl('video', 'quiz.video', 'quiz.Choose file', index, 'quiz.Youtube video url', 'quiz.video__')">
                                    <svg class="bi bi-camera-video-fill"
                                        width="1.4em" height="1.4em"
                                        viewBox="0 0 16 16"
                                        fill="currentColor"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M2.667 3h6.666C10.253 3 11 3.746 11 4.667v6.666c0 .92-.746 1.667-1.667 1.667H2.667C1.747 13 1 12.254 1 11.333V4.667C1 3.747 1.746 3 2.667 3z"/>
                                        <path
                                            d="M7.404 8.697l6.363 3.692c.54.313 1.233-.066 1.233-.697V4.308c0-.63-.693-1.01-1.233-.696L7.404 7.304a.802.802 0 0 0 0 1.393z"/>
                                    </svg>
                                </button>
                            </div>

                        </div>
                    <div class="row">
                    <div class="col-md-6">


                        <input type="text"
                            @input="questionNameChange"
                            class="form-control questionName w-100"
                            :placeholder="trans('__quiz__.Enter your question')" :id="'Q'+(index+1)"
                            v-model="questionName">
                        <div class="valid q-correct mt-2 position-absolute" v-show="valid_error.r_title">
                            {{trans('__quiz__.Is required question title')}}
                        </div>
                        <div class="valid q-correct mt-2 position-absolute" v-show="valid_error.r_select">
                            {{trans('__quiz__.Please select question type')}}
                        </div>
                        <div class="valid q-correct mt-2 position-absolute" v-show="valid_error.r_limit">
                            {{trans('__quiz__.This field must not exceed 255 characters')}}
                        </div>
                    </div>

                        <div class="dropdown col-md-6" style="max-width: 100%">
                <button class="btn btn-secondary dropdown-toggle w-100" type="button"
                        id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ questionCurrentType || 'Select question type' }}
                </button>
                <div class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                    <table class="table drop-table">
                        <tr>
                            <td v-if="check_if_enabled('multiple') " @click="selectQuestionType('multiple', 'quiz.Multiple')">
                                <i class="fas fa-bars"></i>{{ trans('__quiz__.Multiple') }}
                            </td>
                            <td v-if="check_if_enabled('radio')" @click="selectQuestionType('radio', 'Yes/No')">
                                <i class="fas fa-dot-circle"></i>{{ trans('__quiz__.Yes/No') }}
                            </td>
                        </tr>
                        <tr>
                            <td v-if="check_if_enabled('dropdown')" @click="check_if_enabled('dropdown') && selectQuestionType('dropdown', 'Dropdown')">
                                <i class="fas fa-caret-down"></i>{{ trans('__quiz__.Dropdown') }}
                            </td>
                            <td v-if="check_if_enabled('text')"  @click="check_if_enabled('text') && selectQuestionType('text', 'Short Text')">
                                <i class="fas fa-align-justify"></i>{{ trans('__quiz__.Short Text') }}
                            </td>
                        </tr>
                        <tr>
                            <td v-if="check_if_enabled('file')"  @click="check_if_enabled('file') && selectQuestionType('file', 'Picture Choice')">
                                <i class="far fa-image"></i>{{ trans('__quiz__.Picture Choice') }}
                            </td>
                            <td v-if="check_if_enabled('textarea')"  @click="check_if_enabled('textarea') && selectQuestionType('textarea', 'Long Text')">
                                <i class="fas fa-align-justify"></i>{{ trans('__quiz__.Long Text') }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
                    </div>
                </div>


            </div>

        </div>

        <div v-if="questionType === 'multiple'" v-for="(item, index) in data"
                class="block-3 d-flex align-items-center mb-3 ">
            <div class="form-group mb-0 position-relative answer flex-grow-1 d-flex align-items-center overflow-hidden">
                <button @click.prevent="deleteAnswer(index)" class="answer-delete-btn">X</button>
                <input type="text" class="form-control"  maxlength="250"  :placeholder="'Enter an answer choice'"
                        v-model="data[index]['title']">
                <div class="position-absolute correct-answer checkbox checkbox-outline checkbox-outline-2x checkbox-success ">
                    <span class="CP">Correct answer_by_one</span>
                    <span class="mobile position-absolute">
                        Correct answer
                    </span>
                    <input type="checkbox" @change="showMessageSelectCorrectAnswer($event)" v-model="data[index]['is_right']">
                </div>
            </div>

        </div>
        <div v-if="questionType === 'radio'"
                class="block-3  mb-3 pl-4">
            <div class="d-flex align-items-center mb-3 answer">
                <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-success mr-1 mb-0">
                <span class="d-flex align-items-center " style="width: 30px;">
                    Yes
                </span>
                </label>

                <div class="form-group mb-0 position-relative flex-grow-1 ml-3">
                    <div class="correct-answer checkbox checkbox-outline checkbox-outline-2x checkbox-success justify-content-start" style="background: transparent;">
                        <span class="mr-3">Correct answer</span>
                        <input type="radio" name="Yes/No" :value="true" @change="getRadioValue(true, 'Yes')">
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-success mr-1 mb-0">
                <span class="d-flex align-items-center " style="width: 30px;">
                    No
                </span>
                </label>
                <div class="form-group mb-0 position-relative flex-grow-1 ml-3">
                    <div class="correct-answer checkbox checkbox-outline checkbox-outline-2x checkbox-success justify-content-start" style="background: transparent;">
                        <span class="mr-3 ">Correct answer</span>
                        <input type="radio" name="Yes/No" :value="false" @change="getRadioValue(false, 'No')">
                    </div>
                </div>
            </div>

        </div>
        <div v-if="questionType === 'file'" :data-id="index" class="block-3 pl-4 my-d-md-flex align-items-center mb-3 image-block"
                v-for="(item, index) in data">
            <div class="position-relative mb-3 block-5 " >
                <button type="button" class="position-absolute userSelectImageIcon"
                        @click="deleteAnswer(index)">×
                </button>
                <div class="img-preview block-5 mr-0">
                    <img class="rounded" alt="">
                </div>
            </div>
            <div class="block-3 answer d-flex align-items-center mb-3 mt-1 position-relative">
                <div class="custom-file w-auto ">
                    <input type="file" class="custom-file-input answer-image"  accept="image/x-png,image/jpeg"
                            id="customFile" @change="getImages(index, $event)">
                    <label class="custom-file-label answer-image-label"  for="customFile">Choose file</label>
                </div>
                <div class="correct-answer checkbox checkbox-outline checkbox-outline-2x checkbox-success " style="background: transparent;">
                    <span class="CP">Correct answer</span>
                    <span class="mobile position-absolute" style="top: -14px; width: auto">
                        Correct answer
                    </span>
                    <input type="checkbox" @change="showMessageSelectCorrectAnswer($event)" v-model="data[index]['is_right']">
                </div>
            </div>
        </div>
        <div v-if="questionType === 'dropdown'" v-for="(item, index) in data"
                class="block-3 d-flex align-items-center mb-3">
            <div class="form-group mb-0 position-relative answer flex-grow-1 d-flex align-items-center overflow-hidden">
                <button @click.prevent="deleteAnswer(index)" class="answer-delete-btn">X</button>
                <input type="text" class="form-control pr-5" maxlength="250" :placeholder="'Enter an answer choice' "
                        v-model="data[index]['title']" >
                <div class="position-absolute correct-answer checkbox checkbox-outline checkbox-outline-2x checkbox-success ">
                    <span class="CP">Correct answer</span>
                    <span class="mobile position-absolute">
                        Correct answer
                    </span>
                    <input type="checkbox" @change="showMessageSelectCorrectAnswer($event)" v-model="data[index]['is_right']">
                </div>
            </div>
        </div>
        <div v-if="questionType === 'text'" v-for="(item, index) in data"
             class="block-3 d-flex align-items-center mb-3">
            <div class="form-group mb-0 position-relative answer flex-grow-1 d-flex align-items-center overflow-hidden">
                <input type="text" class="form-control pr-5" maxlength="250" :placeholder="'Enter an answer choice' "
                       v-model="data[index]['short_answer']" >
            </div>
        </div>
        <div v-if="validationAnswer" style="color: red">
            Please fill in all fields and select at least one correct variant
        </div>
        <div v-if="validationAnswerUploadFile" class="file_validate_err" style="color: red">
            Please select image
        </div>
        <div v-if="addOtherQuestionShow"
                class="block-4 d-inline-flex align-items-center mt-3"
                @click="addOtherQuestion()">
            <span class="mr-2 badge badge-primary">
                <i class="fas fa-plus"></i>
            </span>
            <p class="m-0">Add new answer</p>
        </div>
        <div class="text-right mr-3">
            <a href="#" class="btn btn-secondary mr-2"
                @click.prevent="formToEmpty">Clear</a>
            <button type="submit" class="btn btn-primary" :disabled="loading">
                <span v-if="loading" class="spinner-border spinner-border-sm mr-1" style="padding: 5px;" role="status" aria-hidden="true"></span>
                <span>Save</span>
            </button>
        </div>
    </div>
</form>
</template>

<script>
import ClickOutside from 'vue-click-outside'
import validator from "validate-image-url";

export default {
    name: "Question",
    data() {
        return {
            enabled_options: window.question_options.split(',').map(item=>item.trim()),
            i: 0,
            questionCurrentType: null,
            formChanged: false,
            questionType: '',
            addOtherQuestionShow: false,
            data: [],
            validationAnswerUploadFile: false,
            questionName: '',
            questionId: null,
            validationAnswer: false,
            showNavigation: false,
            question_file_type: '',
            showQuestionAnswer: true,
            edit: false,
            valid: true,
            loading: false,
            modal_button_save: true,
            // answerImgDeleteButtonShow: false,
            fromButtonShow: false,
            exceptionAnswers: [
                'text',
                'textarea',
                'radio'
            ],
            questionNavigation: {
                type: '',
                inputUrl: true,
                url: null,
                file: null,
                class: false,
                file_url: null,
                file_video_url: null,
                videoBlock_show: false,
                file_type: {
                    name: null,
                    url: true,
                    file: true,
                },
            },
            valid_error: {
                r_title: false,
                r_select: false,
                r_limit: false,
            },
            error: {
                validUrl: false,
                validUrlYoutube: false,
                validUploadFile: false
            }
        }
    },

    props: [
        'index',
        'quizResponse',
        'quiz_id',
        'item',
        'urlprefix'
    ],
    methods: {
        showMessageSelectCorrectAnswer(e) {
            if($(e.target).is(":checked")){
                $(e.target).siblings('.mobile').addClass('mobile_is_true')
            }else{
                $(e.target).siblings('.mobile').removeClass('mobile_is_true')
            }
        },
        checkURL(url) {
            return (url.match(/\.(jpeg|jpg|gif|png|svg)$/) != null);
        },
        async deleteAnswer(index){

            if(this.questionType == 'file'){
                let imageBlock = document.querySelectorAll('.image-block');
                if (imageBlock[0]){
                    await imageBlock.forEach(item=>{
                        if (item.getAttribute('data-id') == index){
                            if(item.getAttribute('data-id') == 0){
                                item.classList.add('d-none')
                            }else {
                                item.remove()
                            }
                        }
                    })
                    $('.file_validate_err').html('');
                }
                this.data[index] = {}
            }else {
                this.$delete(this.data, index);
            }
        },
        questionDelete(index) {
            /*document.querySelectorAll('.questionItem').forEach(item => {
                if (item.getAttribute('data-index') == index) {
                    item.remove();
                }
            })*/
            this.$emit('questionCountDelete', index);

        },
        async validationAnswers(){
            if(this.questionType != 'text' && this.questionType != 'textarea'){
                if (this.questionType == 'file'){
                    await this.data.forEach((item, index)=>{
                        if(_.isEmpty(item)) {
                            this.$delete(this.data, index)
                        }
                    });
                    if(this.data[0]){
                        let i = 0;
                        while (i < this.data.length) {
                            if (this.data[i].file){
                                if (this.data[i].is_right) {
                                    this.validationAnswer = false;
                                    break;
                                }else {
                                    this.validationAnswer = true;
                                }
                            }else {
                                this.validationAnswer = true;
                                break;
                            }
                            i++;
                        }
                    }else{
                        this.validationAnswer = true;
                    }
                }else {
                    if (this.questionType == 'radio'){
                        let i = 0;
                        while (i < this.data.length) {
                            if (this.data[i].is_right != undefined){
                                this.validationAnswer = false;
                                break;
                            }else {
                                this.validationAnswer = true;
                            }
                            i++;
                        }
                    }else {
                        let i = 0;
                        while (i < this.data.length) {
                            if (this.data[i].title == undefined || this.data[i].title == ""){
                                this.validationAnswer = true;
                                break;
                            } else {
                                this.validationAnswer = false;
                            }
                            i++;
                        }
                    }
                }
            }else {
                this.validationAnswer = false;
            }
        },
        questionNameChange() {
            if (this.questionName == "") {
                this.valid = false;
                this.valid_error.r_title = true;
            } else {
                this.valid = true;
                this.valid_error.r_title = false;
            }
        },
        formToEmpty() {
            this.questionName = '';
            this.questionNavigation.type = null;
            this.questionNavigation.url = null;
            this.questionNavigation.file = null;
            this.questionNavigation.file_url = null;
            this.error.validUrlYoutube = false;
            this.error.validUrl = false;
            this.modal_button_save = true;
            this.data = [];
            this.questionType = '';
            this.questionCurrentType = null;
            this.addOtherQuestionShow = false;
        },
        getRadioValue(is_tight, title) {
            this.data = [{}];
            if (is_tight) {
                this.data[0]['title'] = title;
                this.data.push({
                    title: 'No',
                    order: 2
                });
                this.data[0]['is_right'] = true;
                this.data[0]['order'] = 1;
            } else {
                this.data[0]['title'] = title;
                this.data.push({
                    title: 'Yes',
                    order: 1
                });
                this.data[0]['is_right'] = true;
                this.data[0]['order'] = 2;
            }
        },
        editQuestionAnswer() {
            this.showQuestionAnswer = true
        },
        validURL(str) {
            let pattern = new RegExp('^(https?:\\/\\/)?' +
                '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' +
                '((\\d{1,3}\\.){3}\\d{1,3}))' +
                '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' +
                '(\\?[;&a-z\\d%_.~+=-]*)?' +
                '(\\#[-a-z\\d_]*)?$', 'i');
            return !!pattern.test(str);
        },
        questionNavigationUrlChange() {
            this.questionNavigation.url.trim();
            if (this.validURL(this.questionNavigation.url)) {
                if (this.questionNavigation.file_type.name == 'image' && this.checkURL(this.questionNavigation.url)){
                    this.error.validUrlYoutube = false;
                    this.questionNavigation.type = 'image_url';
                    this.error.validUrl = false;
                    this.modal_button_save = true;
                }else {
                    this.modal_button_save = false;
                    this.error.validUrl = true;
                }
                if (this.questionNavigation.file_type.name == 'video'){
                    this.error.validUrl = false;
                    if (this.validateYouTubeUrl( this.questionNavigation.url )) {
                        this.questionNavigation.type = 'youtube';
                        this.error.validUrlYoutube = false;
                        this.modal_button_save = true;
                    } else {
                        this.modal_button_save = false;
                        this.error.validUrlYoutube = true;
                    }

                }

                this.questionNavigation.file_type.file = false;
                this.formChanged = true;
            } else if (this.questionNavigation.url == "") {
                this.error.validUrl = false;
            } else {
                this.modal_button_save = false;
                this.error.validUrl = true
            }
        },
        validateYouTubeUrl(url){
            var p = /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
            if(url.match(p)){
                return url.match(p)[1];
            }
            return false;
        },
        questionNavigationFileClear(choose, index) {
            this.questionNavigation.file_type.url = true;
            this.questionNavigation.file_type.file = true;
            this.questionNavigation.url = null;
            this.questionNavigation.file = null;
            this.questionNavigation.file_video_url = null;
            this.questionNavigation.videoBlock_show = false;
            this.questionNavigation.class = false;
            this.questionNavigation.file_url = null;
            this.error.validUrlYoutube = false;
            this.error.validUploadFile = false;
            this.error.validUrl = false;
            document.getElementById('c-file'+index).value = "";
            document.getElementById('c-file'+index).nextElementSibling.innerHTML = choose;
            this.questionNavigation.class = false;
            this.formChanged = false;
        },
        hide() {
            this.showNavigation = false
        },
        getImages(index, e) {

            let files = e.target.files;
            if (files[0]){
                let currentType = files[0].type.slice(0, 5);
                if (currentType == 'image') {
                    this.validationAnswerUploadFile = false;
                    let imgBlock = $(e.target).closest('.image-block').find('.img-preview')[0];
                    imgBlock.innerHTML = '';
                    for (let i = 0, f; f = files[i]; i++) {
                        if (!f.type.match('image.*')) {
                            continue;
                        }
                        let reader = new FileReader();
                        reader.onload = (function (theFile) {
                            return function (e) {
                                var span = document.createElement('span');
                                span.innerHTML = ['<img class="thumb rounded" src="', e.target.result,
                                    '" title="', theFile.name, '"/>'].join('');
                                imgBlock.insertBefore(span, null);
                            };
                        })(f);
                        reader.readAsDataURL(f);
                    }
                    this.data[index].file = e.target.files[0];
                    this.data[index]['file_type'] = 'image';
                    // this.answerImgDeleteButtonShow = true;
                    e.target.nextElementSibling.innerHTML = e.target.files[0].name
                }else {
                    this.validationAnswerUploadFile = true;
                }

            }
        },

        checkExceptionAnswers() {
            this.exceptionAnswers.forEach((item) => {
                if (item == this.questionType) {
                    this.addOtherQuestionShow = false;
                }
            })
        },
         showSweet(obj,level){
            showSweetMsg(obj,level);
        },
        async selectQuestionType(name, currentName) {
            this.data = [];
            this.questionType = name;
            this.questionCurrentType = currentName;
            this.data.push({});
            this.edit = false;
            this.addOtherQuestionShow = true;
            this.valid_error.r_select = false;
            this.validationAnswer = false;
            this.checkExceptionAnswers();
            if (this.questionId) await axios.delete(`/${window.urlprefix}/quizable/questions/${this.questionId}/answers`).catch(error => {
                console.log(error)
            });
        },
        async createQuestion(url, method) {
            let form = new FormData();
            form.append('title', this.questionName);
            form.append('type', this.questionType);
            // if (this.questionId) form.append('_method', 'PATCH');
            if (this.questionNavigation.file) form.append('file', this.questionNavigation.file);
            if (this.questionNavigation.url) form.append('url', this.questionNavigation.url);
            form.append('file_type', this.questionNavigation.type);
            await axios({
                url: url,
                method: method,
                data: form
            }).then(response => {
                this.valid = true;
                this.questionId = response.data.data.id;
                this.showSweet({successmsg:'Question created successfully'}, 'success');
            }).catch(error => {
                this.valid = false;
                console.log(error)
            })
        },
        async createQuestionAnswer(index) {
            await this.validationAnswers();
            if (!this.validationAnswer) {
                if (this.questionType != 'text' && this.questionType != 'textarea'){
                    let i = 0;
                    while (i < this.data.length) {
                        if (this.data[i].is_right) {
                            this.validationAnswer = false;
                            break;
                        } else{
                            this.validationAnswer = true;
                        }
                        i++;
                    }
                }else {
                    this.validationAnswer = false;
                }
                if (!this.validationAnswer){

                    if (this.questionName == "") {
                        this.valid = false;
                        this.valid_error.r_title = true;
                        this.valid_error.r_select = false;
                    } else if (this.questionType == "") {
                        this.valid = false;
                        this.valid_error.r_title = false;
                        this.valid_error.r_select = true;
                    }/* else if (this.questionName.length > 255) {
                        this.valid_error.r_title = false;
                        this.valid_error.r_select = false;
                        this.valid_error.r_limit = true;
                        this.valid = false;
                    }*/else {
                        this.valid = true;
                        this.valid_error.r_limit = false;
                        this.valid_error.r_title = false;
                        this.valid_error.r_select = false;
                    }
                    if (this.valid) {
                        this.loading = true;
                        await this.createQuestion(`/${window.urlprefix}/quizable/quiz/${this.quiz_id}/questions`, 'post');
                        if (this.edit) {
                            await axios.patch(`/${window.urlprefix}/quizable/questions/${this.questionId}/update-answers`, {
                                data: this.data
                            }).then(response => {
                                this.valid = true;
                                this.showQuestionAnswer = false;
                                this.getAllQuizQuestions()
                            }).catch(error => {
                                console.log(error)
                            })
                        } else {
                            let formData = new FormData();
                            if (this.questionType == 'file') {
                                for (let i = 0; i < this.data.length; i++) {
                                    let data = this.data[i];
                                    formData.append(`data[${i}][file_type]`, data.file_type);
                                    if (data.file) formData.append(`data[${i}][file]`, data.file);
                                    if (data.is_right) {
                                        formData.append(`data[${i}][is_right]`, 1);
                                    } else formData.append(`data[${i}][is_right]`, 0);
                                    if (data.title) formData.append(`data[${i}][title]`, data.title);
                                }
                            } else {
                                formData = {
                                    data: this.data
                                }
                            }
                            await axios.post(`/${window.urlprefix}/quizable/questions/${this.questionId}/answers`, formData)
                                .then(response => {
                                    this.valid = true;
                                    this.edit = true;
                                    this.questionEditShow = true;
                                    for (let i = 0; i < response.data.data.length; i++) {
                                        this.data[i]['id'] = response.data.data[i].id
                                    }
                                    document.querySelectorAll('.questionItem').forEach(item => {
                                        if (item.getAttribute('data-index') == index) {
                                            item.remove()
                                        }
                                    });
                                    this.loading = false;
                                    this.showQuestionAnswer = false;
                                    this.getAllQuizQuestions()
                                }).catch(error => {
                                    console.log(error);
                                    this.loading = false;
                                })
                        }
                    }
                }
            }
        },
        addOtherQuestion() {
            if (this.questionType) {
                this.data.push({});
                this.edit = false;
            }
        },
        async getFileQuestion(e) {
            var that = this;
            let files = e.target.files;
            if (files[0] != undefined) {
                let currentType = files[0].type.slice(0, 5);
                this.error.validUploadFile = false;
                if (currentType == 'image' || currentType == 'video'){
                    this.error.validUploadFile = false;
                    if (this.questionNavigation.file_type.name == 'video') {
                        if (currentType == 'video'){
                            this.error.validUploadFile = false;
                            this.questionNavigation.type = 'video';
                            var reader = new FileReader();
                            reader.onload = function (file) {
                                that.questionNavigation.file_video_url = file.target.result;
                                that.questionNavigation.videoBlock_show = true
                            };
                            reader.readAsDataURL(files[0]);
                            this.questionNavigation.file_type.url = false;
                            this.questionNavigation.file = e.target.files[0];
                            this.modal_button_save = true;
                            $(e.target).next().text(files[0].name);

                        }else {
                            this.questionNavigation.file_url = '';
                            this.questionNavigation.file_video_url = '';
                            this.error.validUploadFile = true;
                            that.questionNavigation.videoBlock_show = false;
                            this.modal_button_save = false;
                        }
                    } else {
                        if (currentType == 'image'){
                            this.error.validUploadFile = false;
                            this.questionNavigation.type = 'image';
                            for (let i = 0, f; f = files[i]; i++) {
                                if (!f.type.match('image.*')) {
                                    continue;
                                }
                                let reader = new FileReader();
                                reader.onload = (function (theFile) {
                                    return function (e) {
                                        that.questionNavigation.class = true;
                                        that.questionNavigation.file_url = e.target.result;
                                    };
                                })(f);
                                reader.readAsDataURL(f);
                            }
                            this.questionNavigation.file_type.url = false;
                            this.modal_button_save = true;
                            $(e.target).next().text(files[0].name);
                            this.questionNavigation.file = e.target.files[0];
                        }else {
                            this.error.validUploadFile = true;
                            that.questionNavigation.class = false;
                            this.questionNavigation.file_url = '';
                            this.modal_button_save = false;
                            this.questionNavigation.file_video_url = '';
                        }
                    }
                }else {
                    this.error.validUploadFile = true;
                    this.questionNavigation.file_url = '';
                    this.questionNavigation.file_video_url = '';
                    this.modal_button_save = false;
                }
            }
            this.formChanged = true;
        },
        questionNavigationControl(type, currentTypeName, choose, index, questionFileType, currentTypeName__) {
            this.questionNavigation.checkLangType = currentTypeName;
            this.questionNavigation.checkLangType__ = currentTypeName__;
            this.question_file_type = questionFileType;
            if (this.questionNavigation.file_type.name != type) {
                this.questionNavigation.file_video_url = null;
                this.questionNavigation.videoBlock_show = false;
                this.questionNavigation.class = false;
                this.questionNavigation.file_url = null;
                this.questionNavigation.class = false;
                this.questionNavigation.file_type.name = type;
                this.questionNavigation.file_type.url = true;
                this.questionNavigation.file_type.file = true;
                this.questionNavigation.url = null;
                this.error.validUrlYoutube = false;
                this.error.validUrl = false;
                this.error.validUploadFile = false;
                this.formChanged = false;
            }
        },
        showEditNavigation() {
            this.showNavigation = !this.showNavigation
        },
        getAllQuizQuestions() {
            axios.get(`/${window.urlprefix}/quizable/quiz/${this.quiz_id}/questions`)
                .then(response => {
                    this.$emit('allQuestions', response);
                }).catch(error => {
                console.log(error)
            })
        },
        check_if_enabled(option){
            if (this.enabled_options.includes(option)) {
            } else{
            }
           return this.enabled_options.includes(option);
        },
    },
    mounted() {
        $('.questionCreateModel').on('shown.bs.modal' , function (){
                let modalcontent = $('.questionCreateModel');
                let fileinput = modalcontent.find('.custom-file-input');
                fileinput.val(null);
                fileinput.trigger('refresh');
                $(fileinput.next()).text(fileinput.next().attr('data-browse'));
        });
    },
    computed: {},
    directives: {
        ClickOutside
    }
}
</script>

<style lang="scss">
.table.drop-table{
    z-index: 999999;
}
.table.drop-table td i{
    margin-left: 10px;
}
.questionItem{
    position: relative;
}
.table.drop-table i{
    margin-right:10px;
}
#quiz{
.block-5 img{
    object-fit: contain!important;
}
}
.answer{
>input[type="text"]{
    padding-right: 48.5px!important;
}
.mobile{
    top: 0;
    color: green;
    font-size: 11px;
    opacity: 0;
    visibility: hidden;
    width: 125px;
    display: block;
    white-space: nowrap;
}
}
.correct-answer{
    right: 0;
    padding: 10px 15px 10px 15px;
    display: flex;
    align-items: center;
    background: #efefef;
    justify-content: flex-end;
    border-bottom-right-radius: 4px;
    border-top-right-radius: 4px;
>span.CP{
    display: none;
    color: #555;
    margin: 0 20px;
}
input{
    cursor:pointer;

}

}
@media (min-width: 768px) {
.correct-answer{
    padding: 10px 20px 10px 0;
    span.CP{
        display: block;
    }
}
.answer{
    >input[type="text"]{
        padding-right: 170px!important;
    }
    .mobile{
        display: none;
    }
}
.block-2 .dropdown {
    width: 42%;
}
.my-d-md-flex{
    display:flex
}
}

.answer-delete-btn{
    background: #ddd;
    border: none;
    font-size: 10px;
    width: 25px;
    height: 25px;
    margin-left: 10px;
    margin-right: 10px;
    transition: .2s;
&:hover{
    color: #fff;
    background: #5766db;
}
    border-radius: 48%;
}

.questionDelete {
    position: absolute;
    right: 2px;
    top: 2px;
    border: none;
    width: 38px;
    background: #fff;
    transition: background-color .2s;

&:hover {
    background: #ddd;
}
}

.userSelectImageIcon {
    right: 5px;
    top: 5px;
    background: #ddd;
    border: none;
    font-size: 18px;
    width: 25px;
    height: 25px;
    border-radius: 2px;
    transition: color .3s, background-color .3s;
&:hover {
    background: #5766db;
    color: #fff;
    span {
        color: #fff;
    }
}

span {
    margin-top: -1px;
    display: block;
}
}

.my-style {
    width: 80px !important;
    height: 80px !important;
    border-radius: 4px;
    overflow: hidden;
}

.plus-vertical-correction {
    margin-top: -1px;
    display: block;
}

.error-validation {
    display: none;
    padding-left: 5px;
    color: red;
}
._show {
    opacity: 1 !important;
    visibility: visible !important;
}
.correct-icon {
    opacity: .5;
    cursor: pointer;
}

.valid {
    color: red;
}

.questionsNavigationButton {
    background: rgba(0, 0, 0, 0.34);
    border-radius: 3px;
    overflow: hidden;
    transition: .2s;
    opacity: 0;
    visibility: hidden;

button {
    margin: 0;
    height: 25.5px;
    border: none;
    background: transparent;

    svg {
        fill: #fff
    }

    &:hover {
        background: #ddd;
    }
}
}
.drop-table td{
    font-size: 1rem!important;
}

.answer{
.mobile_is_true {
    opacity: 0;
    visibility: hidden;
    animation: showHide 2s forwards; /* IE 10+, Fx 29+ */
}
}

@keyframes showHide {
0% {
    opacity: 0;
    visibility: visible;
}

50% {
    opacity: 0.5;
    visibility: visible;
}
100% {
    overflow: hidden;
    visibility: hidden;
}
}
</style>
