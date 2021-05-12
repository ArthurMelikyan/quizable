<template>


</template>

<script>
    import Question from "./question";
    import ClickOutside from 'vue-click-outside';
    export default {
        data() {
            return {
                quiz_is_active: false,
                questionCurrentType: null,
                formChanged: false,
                validationAnswer: false,
                validationAnswerUploadFile: false,
                quiz_edit_block_show: false,
                questionType: null,
                addOtherQuestionShow: false,
                questionName: '',
                questionId: null,
                question_file_type: '',
                data: [],
                showNavigation: true,
                showQuestionAnswer: true,
                edit: false,
                valid: true,
                question_id: null,
                modal_button_save: true,
                fromButtonShow: false,
                loading: false,
                valid_error: {
                    r_title: false,
                    r_select: false,
                    r_limit: false
                },
                questionNavigation: {
                    type: '',
                    checkLangType: '',
                    inputUrl: true,
                    image: false,
                    url: null,
                    video: false,
                    file: null,
                    file_url: null,
                    class: false,
                    file_type: {
                        name: null,
                        url: true,
                        file: true,
                    },
                },
                exceptionAnswers: [
                    'text',
                    'textarea',
                    'radio'
                ],
                error: {
                    validUrl: false,
                    validUrlYoutube: false,
                    validUploadFile: false
                },
                opened: null,
                __edit: null,
                ___i: null,

                quiz_id: null,
                copyText: '',
                questionData: [],
                title: '',
                description: '',
                time_limit: '',
                multiple: false,
                multipleChoiceType: null,
                dataQuestions: [],
                openQuestion: false,
                quizHide: true,
                quizResponse: null,
                saveOrEdit: true,
                quiz_create_valid: {
                    title: false,
                    description: false,
                    limit_time: false
                }
            }
        },
        components: {
            'app-question': Question
        },
        props: [
            'quiz'
        ],
        methods: {
            openedItem(item_id) {
                if (this.__edit) {
                    this.showEditBlock(true, item_id);
                }
                if (this.opened === item_id) {
                    this.opened = 0;
                    this.__edit = 0;
                    return;
                }
                this.__edit = 0;
                this.opened = item_id;

            },
            quizActive(){
                let formData = new FormData();
                formData.append('is_active', this.quiz_is_active);
                axios.patch(`/dashboard/api-quiz-is_active/${this.quiz_id}`, {is_active:this.quiz_is_active})
                    .then()
                    .catch(error => console.log(error))
            },
            questionCountDelete(index)
            {
                this.questionData.splice(index, 1);
            },
            showMessageSelectCorrectAnswer(e) {
                if($(e.target).is(":checked")){
                    $(e.target).siblings('.mobile').addClass('mobile_is_true')
                }else{
                    $(e.target).siblings('.mobile').removeClass('mobile_is_true')
                }
            },
            async deleteAnswer(index) {
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
                    }
                    this.data[index] = {}
                }else {
                    this.$delete(this.data, index);
                }
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
            formToEmpty() {
                this.questionName = '';
                this.questionNavigation.type = null;
                this.questionNavigation.url = null;
                this.questionNavigation.file = null;
                this.questionNavigation.file_url = null;
                this.error.validUrlYoutube = false;
                this.error.validUrl = false;
                this.data = [];
                this.questionType = '';
                this.valid = true;
                this.questionCurrentType = null;
                this.addOtherQuestionShow = false;
            },
            checkURL(url) {
                return (url.match(/\.(jpeg|jpg|gif|png|svg)$/) != null);
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
            questionNavigationUrlChange() {
                if (this.validURL(this.questionNavigation.url)) {
                    if (this.questionNavigation.file_type.name == 'image' && this.checkURL(this.questionNavigation.url)){
                        this.error.validUrlYoutube = false;
                        this.questionNavigation.type = 'image_url';
                        this.error.validUrl = false;
                        this.modal_button_save = true;
                    }else {
                        this.error.validUrl = true;
                        this.modal_button_save = false;
                    }
                    if (this.questionNavigation.file_type.name == 'video'){
                        this.error.validUrl = false;
                        if (this.validateYouTubeUrl( this.questionNavigation.url )) {
                            this.questionNavigation.type = 'youtube';
                            this.error.validUrlYoutube = false;
                            this.modal_button_save = true;
                        } else {
                            this.error.validUrlYoutube = true;
                            this.modal_button_save = false;
                        }
                    }
                    this.questionNavigation.file_type.file = false;
                    this.formChanged = true;
                } else if (this.questionNavigation.url == "") {
                    this.error.validUrl = false;
                    this.modal_button_save = true;
                } else {
                    this.error.validUrl = true;
                    this.modal_button_save = false;
                }
            },
            validateYouTubeUrl(url){
                var p = /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
                if(url.match(p)){
                    return url.match(p)[1];
                }
                return false;
            },
            questionNavigationFileTypeChange(choose) {
                this.formChanged = false;
                this.questionNavigation.file_type.url = true;
                this.questionNavigation.file_type.file = true;
                this.questionNavigation.url = null;
                this.questionNavigation.file = null;
                this.questionNavigation.file_url = null;
                this.questionNavigation.video = false;
                this.questionNavigation.class = false;
                this.error.validUploadFile = false;
                this.questionNavigation.url = null;
                this.error.validUrl = false;
                this.error.validUrlYoutube = false;
                this.formChanged = false;
                this.questionNavigation.class = false;
                document.getElementById('file').nextElementSibling.innerHTML = choose;

            },
            checkExceptionAnswers() {
                this.exceptionAnswers.forEach((item) => {
                    if (item == this.questionType) {
                        this.addOtherQuestionShow = false;
                    }
                })
            },
            hide() {
                this.showNavigation = false
            },
            showEditNavigation() {
                this.showNavigation = !this.showNavigation
            },
            addOtherQuestion() {
                if (this.questionType) {
                    this.data.push({});
                    this.edit = false;
                }
            },
            getFileQuestion(e) {
                var that = this;
                let files = e.target.files;
                if (files[0] != undefined) {
                    let currentType = files[0].type.slice(0, 5);
                    if (currentType == 'image' || currentType == 'video'){
                        this.error.validUploadFile = false;
                        if (this.questionNavigation.file_type.name == 'video') {
                            if (currentType == 'video') {
                                this.questionNavigation.type = 'video';
                                var reader = new FileReader();
                                reader.onload = function (file) {
                                    var fileContent = file.target.result;
                                    that.questionNavigation.class = false;
                                    that.questionNavigation.file_url = fileContent;
                                    that.questionNavigation.video = true;
                                };
                                reader.readAsDataURL(files[0]);
                                this.error.validUploadFile = false;
                                this.questionNavigation.file_type.url = false;
                                this.questionNavigation.file = e.target.files[0];
                                this.modal_button_save = true;
                            }else {
                                this.error.validUploadFile = true;
                                that.questionNavigation.video = false;
                                this.questionNavigation.file_url = '';
                                this.modal_button_save = false;
                            }
                        } else {
                            if (currentType == 'image'){
                                this.questionNavigation.type = 'image';
                                this.error.validUploadFile = false;
                                for (let i = 0, f; f = files[i]; i++) {
                                    if (!f.type.match('image.*')) {
                                        continue;
                                    }
                                    let reader = new FileReader();
                                    reader.onload = (function (theFile) {
                                        return function (e) {
                                            that.questionNavigation.file_url = e.target.result;
                                            that.questionNavigation.video = false;
                                            that.questionNavigation.class = true;
                                        };
                                    })(f);
                                    reader.readAsDataURL(f);
                                }
                                this.questionNavigation.file_type.url = false;
                                this.questionNavigation.file = e.target.files[0];
                                this.modal_button_save = true;
                            }else {
                                that.questionNavigation.class = false;
                                this.error.validUploadFile = true;
                                this.questionNavigation.file_url = '';
                                this.modal_button_save = false;
                            }

                        }

                    }else {
                        this.error.validUploadFile = true;
                        this.questionNavigation.file_url = '';
                        this.modal_button_save = false;
                    }

                }
                this.formChanged = true;
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
            clearUserSelectImg(index, choose) {
                // this.answerImgDeleteButtonShow = false;
                this.data.splice(index, 1);
                event.target.nextElementSibling.innerHTML = '<img>';
                event.target.parentElement.nextElementSibling.querySelector('.answer-image').value = '';
                event.target.parentElement.nextElementSibling.querySelector('.answer-image-label').innerHTML = choose;
                // event.target.style.display = 'none';
            },
            questionNavigationControl(type, currentTypeName, choose, questionFileType, currentTypeName__) {
                this.questionNavigation.checkLangType = currentTypeName;
                this.questionNavigation.checkLangType__ = currentTypeName__;
                this.question_file_type = questionFileType;
                if (this.questionNavigation.file_type.name != type) {
                    document.getElementById('file').nextElementSibling.innerHTML = choose;
                    this.questionNavigation.file_type.url = true;
                    this.questionNavigation.file_type.file = true;
                    this.questionNavigation.file_type.name = type;
                    this.error.validUploadFile = false;
                    this.questionNavigation.url = null;
                    this.questionNavigation.file_url = '';
                    this.questionNavigation.video = false;
                    this.questionNavigation.class = false;
                    this.error.validUrl = false;
                    this.error.validUrlYoutube = false;
                    this.formChanged = false;
                }

            },
            getImages(index, e) {
                let files = e.target.files;
                if (files[0]) {
                    let currentType = files[0].type.slice(0, 5);
                    if (currentType == 'image') {
                        this.validationAnswerUploadFile = false;
                        let imgBlock = $(e.target).closest('.image-block').find('.img-preview')[0];
                        // $(imgBlock).siblings('button.userSelectImageIcon')[0].style.display = 'block';
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
                        e.target.nextElementSibling.innerHTML = e.target.files[0].name
                    }else {
                        this.validationAnswerUploadFile = true
                    }
                }
            },
            /*chooseRightOption(index) {
                if (this.data[index]['is_right']) {
                    this.data[index]['is_right'] = false;
                    event.target.style.opacity = '0.5'
                } else {
                    this.data[index]['is_right'] = true;
                    event.target.style.opacity = '1'
                }
                console.log(this.data)
            },*/
            async selectQuestionType(name, id, currentName) {
                this.data = [];
                this.questionType = name;
                this.questionCurrentType = currentName;
                this.valid_error.r_select = false;
                this.data.push({});
                this.edit = false;
                this.createAnswer = false;
                this.validationAnswer = false;
                this.addOtherQuestionShow = true;
                this.checkExceptionAnswers();
            },
            async questionUpdate(url, method) {
                let form = new FormData();
                form.append('title', this.questionName);
                form.append('type', this.questionType);
                form.append('_method', 'PATCH');
                if (this.questionNavigation.file) form.append('file', this.questionNavigation.file);
                if (this.questionNavigation.url) form.append('url', this.questionNavigation.url);
                if (this.questionNavigation.type) form.append('file_type', this.questionNavigation.type);
                await axios({
                    url: url,
                    method: method,
                    data: form
                }).then(response => {
                    this.valid = true;
                    this.questionId = response.data.data.id;
                }).catch(error => {
                    this.valid = false;
                    console.log(error)
                })
            },
            async questionUpdateSave(question_id) {
                await this.validationAnswers();
                if (!this.validationAnswer) {
                    if (this.questionType != 'text' && this.questionType != 'textarea') {
                        let i = 0;
                        while (i < this.data.length) {
                            if (this.data[i].is_right) {
                                this.validationAnswer = false;
                                break;
                            } else {
                                this.validationAnswer = true;
                            }
                            i++;
                        }
                    } else {
                        this.validationAnswer = false;
                    }
                    if (!this.validationAnswer) {
                        if (this.questionName == "") {
                            this.valid = false;
                            this.valid_error.r_title = true;
                            this.valid_error.r_select = false;
                        } else if (this.questionType == "") {
                            this.valid = false;
                            this.valid_error.r_title = false;
                            this.valid_error.r_select = true;
                        } /*else if (this.questionName.length > 255) {
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
                            let edit_block = document.querySelectorAll('.card-body');
                            edit_block.forEach((item, index) => {
                                if (item.getAttribute('data-question-id') == question_id) {
                                    item.querySelector('.preview').style.display = 'block';
                                    item.querySelector('.edit-block').style.display = 'none';
                                }
                            });
                            await this.questionUpdate(`/dashboard/quiz/${this.quiz_id}/questions/${question_id}`, 'post');
                            await axios.delete(`/dashboard/questions/${question_id}/answers`).catch(error => {
                                console.log(error)
                            });
                            let formData = new FormData();
                            if (this.questionType == 'file') {
                                for (let i = 0; i < this.data.length; i++) {
                                    let data = this.data[i];
                                    if (data.file_type) formData.append(`data[${i}][file_type]`, data.file_type);
                                    if (data.file) formData.append(`data[${i}][file]`, data.file);
                                    if (data.is_right) {
                                        formData.append(`data[${i}][is_right]`, 1);
                                    } else formData.append(`data[${i}][is_right]`, 0);
                                    if (data.title) formData.append(`data[${i}][title]`, data.title);
                                    if (data.file_url) formData.append(`data[${i}][url]`, data.file_url);
                                    if (data.url) formData.append(`data[${i}][url]`, data.url);
                                }
                            } else {
                                formData = {
                                    data: this.data
                                }
                            }
                            axios.post(`/dashboard/questions/${question_id}/answers`, formData).then(response => {
                                this.getAllQuizQuestions();
                                this.valid = true;
                                this.edit = true;
                                this.createAnswer = false;
                                this.showQuestionEditBLock = false;
                                this.showEditBlock(false, this.question_id);
                                this.loading = false;
                                this.showQuestionAnswer = false;
                                for (let i = 0; i < response.data.data.length; i++) {
                                    this.data[i]['id'] = response.data.data[i].id
                                }
                            }).catch(error => {
                                console.log(error);
                                this.loading = false;
                            })
                        } else {
                            this.valid = false;
                            this.validError = true
                        }
                    }
                }


            },
            showEditBlock(is_show, question_id) {
                if (this.__edit == question_id){
                    this.__edit = 0;
                    is_show = false;
                }else this.__edit = question_id;

                let edit_block = document.querySelectorAll('.questionBodyCollapse');
                document.getElementById(`collapseOne${question_id}`).classList.add('show');
                edit_block.forEach((item) => {
                    item.querySelector('.preview').style.display = 'block';
                    item.querySelector('.edit-block').style.display = 'none';
                    if (is_show) {
                        if (item.getAttribute('data-question-id') == question_id) {
                            item.querySelector('.preview').style.display = 'none';
                            item.classList.add('show');
                            item.querySelector('.edit-block').style.display = 'block';
                        } else {
                            this.opened = question_id;
                            item.querySelector('.preview').style.display = 'block';
                            item.querySelector('.edit-block').style.display = 'none';
                        }
                    } else {
                        if (item.getAttribute('data-question-id') == question_id) {
                            this.opened = question_id;
                            item.querySelector('.preview').style.display = 'block';
                            item.querySelector('.edit-block').style.display = 'none';
                        }
                    }
                });
            },
            questionEdit(question, currentType, choose) {
                if (this.questionId != question.id){
                    this.formChanged = false;
                    this.questionNavigation.file_type.url = true;
                    this.questionNavigation.file_type.file = true;
                    this.questionNavigation.url = null;
                    this.questionNavigation.file = null;
                    this.error.validUrlYoutube = false;
                    this.error.validUrl = false;
                    document.getElementById('file').value = "";
                    this.questionNavigation.class = false;
                    document.getElementById('file').nextElementSibling.innerHTML = choose;
                    this.questionNavigation.file_type.name = null;
                }
                this.showQuestionEditBLock = !this.showQuestionEditBLock;
                this.data = [];
                this.questionName = question.title;
                this.questionType = question.type;
                this.checkQuestionTypeName(question.type, currentType);
                this.question_id = question.id;
                this.showEditBlock(true, question.id);
                this.formChanged = true;
                this.questionNavigation.type = question.file_type;
                if (question.file_type == 'image') {
                    this.questionNavigation.file_type.name = 'image';
                    this.questionNavigation.file_type.url = false;
                    this.questionNavigation.file_url = question.file_url;
                    this.questionNavigation.file_type.file = true;
                    this.questionNavigation.video = false;
                    this.questionNavigation.class = true;
                } else if (question.file_type == 'image_url') {
                    this.questionNavigation.file_type.name = 'image';
                    this.questionNavigation.url = question.url;
                    this.questionNavigation.file_type.url = true;
                    this.questionNavigation.file_type.file = false;
                } else if (question.file_type == 'video') {
                    this.questionNavigation.file_type.name = 'video';
                    this.questionNavigation.file_url = question.file_url;
                    this.questionNavigation.file_type.file = true;
                    this.questionNavigation.file_type.url = false;
                    this.questionNavigation.class = false;
                    this.questionNavigation.video = true;
                } else if (question.file_type == 'youtube') {
                    this.questionNavigation.file_type.name = 'video';
                    this.questionNavigation.url = question.url;
                    this.questionNavigation.file_type.url = true;
                    this.questionNavigation.file_type.file = false;
                } else{
                    this.formChanged = false;
                    this.questionNavigation.file_type.url = true;
                    this.questionNavigation.file_type.file = true;
                    this.questionNavigation.url = null;
                    this.questionNavigation.file = null;
                    this.error.validUrlYoutube = false;
                    this.error.validUrl = false;
                    this.questionNavigation.class = false;
                    document.getElementById('file').nextElementSibling.innerHTML = choose;
                    this.questionNavigation.file_type.name = null;
                }

                if (question.answers.length) {
                    question.answers.forEach((item) => {
                        if (item.title == null) {
                            delete item.title;
                        }
                        delete item.file;
                        delete item.id;
                        if (!item.file_type) {
                            delete item.file_type;
                            delete item.file_url;
                            delete item.url;
                        }
                        if (item.file_url =='https://aist-elearning.s3.eu-central-1.amazonaws.com/CixbCxTd4rko/'){

                        }
                        delete item.question_id;
                        delete item.created_at;
                        delete item.deleted_at;
                        this.data.push(item)
                    });
                    if (this.data) this.addOtherQuestionShow = true;
                }
                this.exceptionAnswers.forEach(item => {
                    if (question.type == item) {
                        this.addOtherQuestionShow = false;
                    }
                });

            },


            checkQuestionTypeName(question_type, currentType) {
                if (question_type == 'multiple') this.questionCurrentType = currentType[0];
                else if (question_type == 'radio') this.questionCurrentType = currentType[1];
                else if (question_type == 'dropdown') this.questionCurrentType = currentType[2];
                else if (question_type == 'text') this.questionCurrentType = currentType[3];
                else if (question_type == 'file') this.questionCurrentType = currentType[4];
                else if (question_type == 'textarea') this.questionCurrentType = currentType[5];
            },
            async validationAnswers() {
                if (this.questionType != 'text' && this.questionType != 'textarea') {
                    if (this.questionType == 'file') {
                        await this.data.forEach((item, index) => {
                            if (_.isEmpty(item)) {
                                this.$delete(this.data, index)
                            }
                        });
                        if (this.data[0]) {
                            let i = 0;
                            while (i < this.data.length) {
                                if (this.data[i].file || this.data[i].file_url || this.data[i].url) {
                                    if (this.data[i].is_right) {
                                        this.validationAnswer = false;
                                        break;
                                    } else {
                                        this.validationAnswer = true;
                                    }
                                } else {
                                    this.validationAnswer = true;
                                    break;
                                }
                                i++;
                            }
                        } else {
                            this.validationAnswer = true;
                        }
                    } else {
                        if (this.questionType == 'radio') {
                            let i = 0;
                            while (i < this.data.length) {
                                if (this.data[i].is_right != undefined) {
                                    this.validationAnswer = false;
                                    break;
                                } else {
                                    this.validationAnswer = true;
                                }
                                i++;
                            }
                        } else {
                            let i = 0;
                            while (i < this.data.length) {
                                if (this.data[i].title == undefined || this.data[i].title == "") {
                                    this.validationAnswer = true;
                                    break;
                                } else {
                                    this.validationAnswer = false;
                                }
                                i++;
                            }
                        }
                    }
                } else {
                    this.validationAnswer = false;
                }
            },
            async createQuiz() {
                if (this.validation()) {
                    let form = new FormData(), url;
                    form.append('title', this.title);
                    form.append('description', this.description);
                    if (this.time_limit) form.append('time_limit', this.time_limit);
                    this.loading = true;
                    if (!this.quizResponse && !this.quiz_id) {
                        url = '/dashboard/api-quiz';
                        await this.sendMethod(url, 'post', form);
                    } else {
                        form.append('answer_by_one', 0);
                        form.append('_method', 'PATCH');
                        url = '/dashboard/api-quiz/' + this.quiz_id + "/update";
                        await this.sendMethod(url, 'post', form);
                    }
                }

            },
            quizEdit() {
                this.saveOrEdit = true;
                this.quizHide = true
            },
            async cloneQuestion(question_id) {
                await axios.post(`/dashboard/quiz/${this.quiz_id}/questions/${question_id}`)
                    .then(response => {
                        this.getAllQuizQuestions();
                    }).catch(error => {
                    });
            },
            addNewQuestion() {
                this.questionData.push({
                    check:true
                });
                if ($('.questionItem').last().length){
                    $('html, body').animate({
                        scrollTop: $('.questionItem').last().offset().top
                    }, 700);
                }else {
                    $('html, body').animate({
                        scrollTop: $("#kt-portlet__body").offset().top
                    }, 700);
                }
            },
            sendMethod(url, method, form) {
                axios({
                    url: url,
                    method: method,
                    data: form,
                }).then(response => {
                    this.quiz_id = response.data.data.id;
                    this.quizResponse = response.data;
                    this.openQuestion = true;
                    this.saveOrEdit = false;
                    this.loading = false;
                    this.quizHide = false
                }).catch(error => {
                    this.validation();
                    console.log(error);
                    this.loading = false;
                })
            },
            questionDelete(questionId, index) {
                axios.delete(`/dashboard/quiz/${this.quiz_id}/questions/${questionId}`)
                    .then(resp => {
                        this.getAllQuizQuestions();
                    }).catch(error => {
                    console.log(error)
                })
            },
            validation() {
                let i = 0;
                let parsTimeLimit = parseInt(this.time_limit);
                if (parsTimeLimit){
                    if (parsTimeLimit <= 0 || parsTimeLimit > 9999) {
                        this.quiz_create_valid.limit_time = true;
                        i++
                    } else {
                        this.quiz_create_valid.limit_time = false;
                    }
                }else {
                    i++;
                    this.quiz_create_valid.limit_time = true;
                    if (this.time_limit == "" || this.time_limit == null){
                        i = 0;
                        this.quiz_create_valid.limit_time = false;
                    }
                }
                if (this.title == "" || this.title.length > 255) {
                    this.quiz_create_valid.title = true;
                    i++
                } else {
                    this.quiz_create_valid.title = false;
                }
                if (this.description == "") {
                    this.quiz_create_valid.description = true;
                    i++
                } else {
                    this.quiz_create_valid.description = false;
                }

                if (i > 0) {
                    return false
                } else return true
            },
            allQuestions(data) {
                this.dataQuestions = data.data.data
            },
            async changeQuestions() {
                var obj = {};
                this.dataQuestions.map(function (val, index) {
                    val.order = index + 1;
                    obj[val.id] = val.order
                });
                await axios({
                    method: 'patch',
                    url: `/dashboard/quiz/${this.quiz_id}/questions`,
                    data: {
                        ids: obj
                    },
                    header: {
                        'Content-Type': 'application/json'
                    }
                }).then(response => {
                    this.dataQuestions = response.data.data;
                }).catch(error => {
                    console.log(error)
                })
            },
            async getAllQuizQuestions() {
                await axios.get(`/dashboard/quiz/${this.quiz_id}/questions`)
                    .then(response => {
                        this.dataQuestions = response.data.data;
                        this.questionData = [];
                        for (let i = 0; i < response.data.data.length; i++) {
                            if (i == response.data.data.length - 1 && this.___i) {
                                this.questionData.push({
                                    check: true
                                });
                                this.___i = true;
                            } else {
                                this.questionData.push({
                                    check: false
                                })
                            }
                        }

                    }).catch(error => {
                        console.log(error)
                    })
            },
            async init() {
                if (this.quiz) {
                    this.quiz_id = this.quiz.id;
                    this.openQuestion = true;
                    this.title = this.quiz.title;
                    this.description = this.quiz.description;
                    this.time_limit = this.quiz.time_limit;
                    this.quizHide = false;
                    if (this.quiz.is_active)
                    this.quiz_is_active = true;
                }
                await this.getAllQuizQuestions();
                /*$('.__open__block').click(function () {
                    if ($(this).prop('tagName') === 'IMG'){
                        $(this).addClass('rotate');
                    }else {
                        $(this).parent().find('img.__open__block').toggleClass('rotate');
                    }
                });*/
            }
        },
        mounted() {
        },
        created: function () {
            if (this.quiz) {
                this.init();
            } else this.questionData.push({
                check:true
            });
        },
        directives: {
            ClickOutside
        },
        computed: {
            dragOptions() {
                return {
                    animation: 200,
                    group: "description",
                    disabled: false,
                    ghostClass: "ghost",
                    handle: '.my-handle'
                };
            }
        }
    }
</script>


<style scoped lang="scss">

    .active{
        background: #ddd!important;
    }
    .answer-delete-btn {
        background: #ddd;
        border: none;
        font-size: 10px;
        width: 25px;
        height: 25px;
        margin-right: 10px;
        margin-left: -10px;
        transition: .2s;
        margin-left: 0;
        &:hover {
            color: #fff;
            background: #5766db;
        }

        border-radius: 48%;
    }

    .quiz-question-title-ellipsis {
        display: block;
        text-overflow: ellipsis;
        width: 100%;
        white-space: nowrap;
        overflow: hidden;
    }

    .my-style {
        width: 80px !important;
        height: 80px !important;
        border-radius: 4px;
        overflow: hidden;
    }

    .my-handle {
        cursor: move;
    }

    .questionItem {
        margin-bottom: 20px;

        &:first-child {
            margin-top: 0;
        }
    }

    .open {
        display: block;
    }

    .edit-block {
        display: none;
    }

    .preview {
        display: block;
    }

    ._show {
        opacity: 1 !important;
        visibility: visible !important;
    }

    .error {
        display: block !important;
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


    @media (max-width: 768px) {
        .questionItemEdit{
            padding-left: 1.25rem!important;
            .dropdown{
                width: 100%;
            }
        }
    }
    @media (min-width: 768px) {
        .questionItemEdit{
            .dropdown{
                width: 60%;
            }
        }
    }
    .material-switch > input[type="checkbox"] {
        display: none;
    }

    .material-switch > label {
        cursor: pointer;
        height: 0px;
        position: relative;
        width: 40px;
    }

    .material-switch > label::before {
        background: rgb(0, 0, 0);
        box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
        border-radius: 8px;
        content: '';
        height: 16px;
        margin-top: -8px;
        position:absolute;
        opacity: 0.3;
        transition: all 0.4s ease-in-out;
        width: 40px;
    }
    .material-switch > label::after {
        background: rgb(255, 255, 255);
        border-radius: 16px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        content: '';
        height: 24px;
        left: -4px;
        margin-top: -8px;
        position: absolute;
        top: -4px;
        transition: all 0.3s ease-in-out;
        width: 24px;
    }
    .material-switch > input[type="checkbox"]:checked + label::before {
        background: inherit;
        opacity: 0.5;
    }
    .material-switch > input[type="checkbox"]:checked + label::after {
        background: #0aba86;
        left: 20px;
    }

    .rotate{
        transform: rotate(180deg);
    }
</style>
