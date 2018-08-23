// инициализация валидации форм
function initSubscribeFormValidations(obj) {
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
        }).on('error.form.bv', function (e) {
            $('.errorformSubscribe').hide();
        }).on('error.field.bv', function (e, data) {
            $('.errorformSubscribe').hide();
        }).on('success.field.bv', function (e, data) {
            $('.errorformSubscribe').hide();
        }).on('status.field.bv', function (e, data) {
            $('.errorformSubscribe').hide();
        }).on('success.form.bv', function(e) {
            e.preventDefault();

            // сообщение в модальном окне или в форме
            var _showMessage = function (status, message) {

                var alert,
                    alertSuccess,
                    alertDanger,
                    resetTimeout,
                    serverMessage;

                alert = form.find('.errorformSubscribe');
                if (status === undefined || !alert.length) {
                    return false;
                }
                //alertSuccess = alert.filter('.alert-success');
                //alertDanger = alert.filter('.alert-danger');

                if (status === true) {
                    form.hide();
                    form.parent().find('.success').html(message).show();


                } else if (status === false) {
                    alert.hide();
                    form.find(".form-group").addClass('has-error');
                    alert.find('.help-block').html(message);
                    alert.show();
                } else {
                    alert.addClass('hidden');
                }
                // сброс формы
                resetTimeout = setTimeout(function() {
                    alert.addClass('hidden');
                    $(form).data('bootstrapValidator').resetForm(true);
                    $(form)[0].reset();
                    switchSelects.find('select').trigger('refresh');

                }, 300000);
            };


            $.ajax({
                type: 'POST',
                data: form.serialize(),
                url: '/include/ajax/subscribe_from.php',

                success: function(data) {

                    data = $.parseJSON(data);
 
                    if (data.result === 'ok') {
                        _showMessage(true, data.message);
                    } else {
                        _showMessage(false, data.message);
                    }
                },
                error: function() {
                    alert('!!');
                    _showMessage(false);
                }
            });
            //*/
        });
    }
}