$(document).ready(function () {
    /*    $('.servicesTabs .serv').click(function (){
            $(this).parent('.servicesTabs').children('.content').toggleClass('opened');
        });*/

    $('#abonent_search').select2({
        minimumInputLength: 3,
        width: '100%',
        language: 'uk',
        placeholder: 'Введіть особовий рахунок...',
        ajax: {
            url: '/abonents/search',
            dataType: 'json',
            type: "GET",
            data: function (data) {
                return {
                    keyword: data.term
                };
            },
            processResults: function (response) {
                return {
                    results: $.map(response, function (response) {
                        return {
                            text: '(' + response.personal_account + ') ' + response.name,
                            id: response.id
                        }
                    })
                };
            },
            cache: true
        }
    }).on('select2:select', function (e) {
        $('#abonent_services').select2().empty();

        let id = e.params.data.id;

        $.ajax({
            url: '/abonents/' + id + '/services',
            dataType: 'json',
            type: "GET",
            success: function (response) {

                let options = response.map(function (nested) {
                    return {
                        text: nested.name,
                        id: nested.service_id,
                        abonent_id: id
                    }
                });


                $('#abonent_services').select2({
                    data: options,
                    minimumResultsForSearch: -1,
                }).on('select2:select', function (e) {
                    $('#abonent_services_meters').select2().empty();
                    let id = e.params.data.abonent_id;
                    let service_id = e.params.data.id;
                    $.ajax({
                        url: '/abonents/' + id + '/meters?service_id=' + service_id,
                        dataType: 'json',
                        type: "GET",
                        success: function (response) {

                            let meters = response.map(function (nested) {
                                return {
                                    text: nested.title,
                                    id: nested.id
                                }
                            });

                            console.log(meters);

                            $('#abonent_services_meters').select2({
                                placeholder: 'Введіть особовий рахунок...',
                                minimumResultsForSearch: -1,
                                data: meters
                            });

                        }
                    });

                });
            },
        })
    });



});


var abonent = {
    'add': function () {
        $.ajax({
            url: '/abonents',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $('#add_abonent form').serialize(),
            complete: function () {

            },
            success: function (data) {
                window.location.replace('/abonents/' + data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
}


var meter = {
    'add': function () {
        $.ajax({
            url: '/meters/add',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $('#add_meter form').serialize(),
            complete: function () {

            },
            success: function () {
                $('#card_meters').load('/abonents/1 #meters_content');
                $('#add_meter').modal('hide');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    },
    'remove': function (meter_id) {
        $.ajax({
            url: '/meters/remove/' + meter_id,
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            complete: function () {

            },
            success: function () {
                $('#card_meters').load('/abonents/1 #meters_content');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
}

function tabShow(id) {
    $('#' + id).toggleClass('opened');
}
