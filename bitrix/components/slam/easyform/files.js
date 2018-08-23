/*
// инициализация валидации форм
function initFormValidations(obj) {
    'use strict';
    var isAllInclude = true;
    var form = $(obj.form);
    var modal = $(obj.messageModal);

    if(!form.length){
        console.log('Ошибка формы: ID формы не найден. Укажите ID формы в настройках комопнента easyform.');
        isAllInclude = false;
    }

    if(modal.length && !$.fn.modal){
        console.log('Ошибка формы: не подключена библиотека bootstrap. Вы можете подключить библиотеку bootstrap в настройках комопнента easyform.');
        isAllInclude = false;
    }

    if(!$.fn.bootstrapValidator){
        console.log('Ошибка формы: не подключена библиотека bootstrapValidator');
        isAllInclude = false;
    }

    if (isAllInclude) {

        // captcha
        if (obj.captcha) {
            var captcha = true;
            var captchaCallback = function(response) {
                if (response !== undefined) {
                    $('input[name=' + obj.captcha.inputName + ']').val(1);
                } else {
                    $('input[name=' + obj.captcha.inputName + ']').val('');
                }
                form.bootstrapValidator('updateStatus', obj.captcha.inputName, 'NOT_VALIDATED')
                    .bootstrapValidator('validateField', obj.captcha.inputName);
            };
            grecaptcha.render(obj.captcha.containerId, {
                'sitekey': obj.captcha.sitekey,
                'callback': captchaCallback,
                'expired-callback': captchaCallback
            });

        }

        // switch select
        var switchSelects = form.find('.switch-select');
        if (switchSelects.length) {
            switchSelects.each(function() {
                var self = $(this);
                var parent = self.find('.switch-parent');
                var child = self.find('.switch-child');
                var btnBack = self.find('.btn-switch-back');
                var select = self.find('select');
                if (select.length && btnBack.length && child.length && parent.length) {
                    select.on('change', function() {
                        var optionSelected = select.find('option:selected');
                        var dataSwitch = optionSelected.data('switch');
                        if (dataSwitch !== undefined) {
                            parent.addClass('hidden');
                            child.removeClass('hidden');
                        }
                    });
                    btnBack.on('click', function(e) {
                        e.preventDefault();
                        parent.removeClass('hidden');
                        child.addClass('hidden');
                        select.find('option').eq(0).prop('selected', true);
                        //form.bootstrapValidator('updateStatus', select.attr('name'), 'NOT_VALIDATED');
                        setTimeout(function() {
                            select.trigger('refresh');
                        }, 1);
                    });

                    form.on('reset', function() {
                        parent.removeClass('hidden');
                        child.addClass('hidden');
                        select.find('option').eq(0).prop('selected', true);
                        //form.bootstrapValidator('updateStatus', select.attr('name'), 'NOT_VALIDATED');
                        setTimeout(function() {
                            select.trigger('refresh');
                        }, 1);
                    });
                }
            });
        }


        // init form valid
        form.bootstrapValidator({
            //feedbackIcons: {
            //    valid: 'glyphicon glyphicon-ok',
            //    invalid: 'glyphicon glyphicon-remove',
            //    validating: 'glyphicon glyphicon-refresh'
            //},
            fields: obj.fields
        }).on('success.form.bv', function(e) {
            e.preventDefault();

            // сообщение в модальном окне или в форме
            var _showMessage = function (status, message) {

                var alert,
                    alertSuccess,
                    alertDanger,
                    resetTimeout,
                    serverMessage;
                if (modal.length) {
                    alert = modal.find('.alert');
                    if (status === undefined || !alert.length) {
                        return false;
                    }
                    alertSuccess = alert.filter('.alert-success');
                    alertDanger = alert.filter('.alert-danger');
                    if (status === true) {
                        alert.addClass('hidden');
                        alertSuccess.removeClass('hidden');
                        serverMessage = message || alertSuccess.data('message');
                        alertSuccess.find('.msg').text(serverMessage);
                        modal.modal('show');
                    } else if (status === false) {
                        alert.addClass('hidden');
                        alertDanger.removeClass('hidden');
                        serverMessage = message || alertDanger.data('message');
                        alertDanger.html(serverMessage);
                        modal.modal('show');
                    } else {
                        modal.modal('hide');
                    }
                    // сброс формы
                    resetTimeout = setTimeout(function() {
                        modal.modal('hide');
                        $(form).data('bootstrapValidator').resetForm(true);
                        $(form)[0].reset();
                        switchSelects.find('select').trigger('refresh');
                        if (captcha === true) {
                            grecaptcha.reset();
                        }
                    }, 3000);
                } else {
                    alert = form.find('.alert');
                    if (status === undefined || !alert.length) {
                        return false;
                    }
                    alertSuccess = alert.filter('.alert-success');
                    alertDanger = alert.filter('.alert-danger');

                    if (status === true) {
                        alert.addClass('hidden');
                        serverMessage = message || alertSuccess.data('message');
                        alertSuccess.find('.msg').text(serverMessage);
                        alertSuccess.removeClass('hidden');
                    } else if (status === false) {
                        alert.addClass('hidden');
                        serverMessage = message || alertDanger.data('message');
                        alertDanger.html(serverMessage);
                        alertDanger.removeClass('hidden');
                    } else {
                        alert.addClass('hidden');
                    }
                    // сброс формы
                    resetTimeout = setTimeout(function() {
                        alert.addClass('hidden');
                        $(form).data('bootstrapValidator').resetForm(true);
                        $(form)[0].reset();
                        switchSelects.find('select').trigger('refresh');
                        if (captcha === true) {
                            grecaptcha.reset();
                        }
                    }, 3000);
                }
            };

            // ajax
            $.ajax({
                type: 'POST',
                //url: obj.url,
                data: form.serialize(),
                success: function(data) {
                    data = JSON.parse(data);
                    console.log(data);

                    if (data.result === 'ok') {
                        _showMessage(true, data.messageOK);
                    } else {
                        _showMessage(false, data.message);
                    }
                },
                error: function() {
                    _showMessage(false);
                }
            });
        });
    }
}

*/
document.addEventListener('DOMContentLoaded', function () { 
    
    if ($('.form__formFocus').length) {

        var form = $('.form__formFocus');

        form.filter(function () {

            var _self = $(this),
                alone = _self.data('multifile') == false ? false : true;
            
            if( _self.find('#file-input-button').length ) {
              
                
                //FIELDS[PHOTO]
                _self.find('#file-input-button').dropzone({
                    url: "/bitrix/components/slam/easyform/ajax.php",
                    paramName: 'files',
                    maxFilesize: 50,
                    maxFiles: 1,
                    uploadMultiple: alone,
                    previewsContainer: '#files-input',
                    createImageThumbnails: false,
                    addRemoveLinks: true,
                    dictDefaultMessage: 'Прикрепить резюме',
    
                    dictFileTooBig: 'Файл слишком большой',
                    dictResponseError: 'Сервер ответил с ошибкой',
                    dictInvalidFileType: 'Неверный тип файла',
                    acceptedFiles: "image/*",
                    init: function init() {
                        this.on("removedfile", function (file) {
                            $.ajax({
                                type: "POST",
                                url: "/bitrix/components/slam/easyform/ajax.php",
                                data: "del=" + file['name'],
                                dataType: "html"
                            });
                        });
                        this.on("error", function () {
                            $(this).find('.dz-message_waring').addClass('dis-error');
                            $(this).find('.dz-message_error').removeClass('dis-error');
                        });
                        this.on('resetFiles', function () {
                            if (this.files.length !== 0) {
                                for (i = 0; i < this.files.length; i++) {
                                    this.files[i].previewElement.remove();
                                }
                                this.files.length = 0;
                            }
                        }),
                        this.on("maxfilesexceeded", function (file) {
                            return false;
                        });
                    },
                    sending: function (file, xhr, formData) {
                        formData.append('action', 'FILE');
                    }
                });
    
                
                
            }
    
            
        });
    }
});