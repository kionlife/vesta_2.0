function loadMeters(service, auto = false) {

    $('#abonent_services_meters').select2().empty();

    let id = 0;
    let service_id = 0;

    if (auto === true) {
        id = service[0].abonent_id;
        service_id = service[0].id;
    } else {
        id = service.params.data.abonent_id;
        service_id = service.params.data.id;
    }

    $.ajax({
        url: '/abonents/' + id + '/meters?service_id=' + service_id,
        dataType: 'json',
        type: "GET",
        success: function (response) {

            let meters = response['data'].map(function (nested) {
                return {
                    text: nested.title,
                    id: nested.id,
                    last_counter: nested.last_counter
                }
            });


            $('#abonent_services_meters').select2({
                placeholder: 'Введіть особовий рахунок...',
                minimumResultsForSearch: -1,
                data: meters
            }).on('select2:select', function (e) {
                let last_counter = e.params.data.last_counter;

                $('#last_counter').val(last_counter);
            });

            let last_counter = $('#abonent_services_meters').select2('data');
            $('#last_counter').val(last_counter[0]['last_counter']);

        }
    });
}


function loadServices(e) {
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
            }).on('select2:select', function (service) {
                loadBalance(service);
                loadMeters(service);
            });

            loadMeters($('#abonent_services').select2('data'), true);
            loadBalance($('#abonent_services').select2('data'), true);
        }

    });

}


function loadBalance(service, auto = false) {

    let id = 0;
    let service_id = 0;

    if (auto === true) {
        id = service[0].abonent_id;
        service_id = service[0].id;
    } else {
        id = service.params.data.abonent_id;
        service_id = service.params.data.id;
    }

    $.ajax({
        url: '/abonents/' + id + '/balances?service_id=' + service_id,
        dataType: 'json',
        type: "GET",
        success: function (response) {
            let balance = response.value;
            $('#current_balance').val(balance.toFixed(2));
        }
    });



}




$(document).ready(function () {
    /*    $('.servicesTabs .serv').click(function (){
            $(this).parent('.servicesTabs').children('.content').toggleClass('opened');
        });*/

    $('body').on('click', '.linkRow tr', function(e){
        e.prevenDefault; // на случай если вместо <tr> кто то захочет поставить поставить <a href="#"><tr>
        document.location.href = $(this).data('href');
    })



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
        loadServices(e);
    });

    $('#current_counter').on('keyup', function (e) {
        let used = $(this).val() - $('#last_counter').val();
       $('#used_counter').val(used);
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
        let data = $('#add_meter form').serialize();
        let abon_id = $('#add_meter form input[name=abonent_id]').val();
        $.ajax({
            url: '/meters/add',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            complete: function () {

            },
            success: function () {
                $('#card_meters').load('/abonents/'+ abon_id +' #meters_content');
                $('#add_meter').modal('hide');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    },
    'remove': function (meter_id, abon_id) {

        $.ajax({
            url: '/meters/remove/' + meter_id,
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            complete: function () {

            },
            success: function () {
                $('#card_meters').load('/abonents/' + abon_id + ' #meters_content');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
}

var person = {
    'add': function () {
        let data = $('#add_person form').serialize();
        let abon_id = $('#add_person form input[name=abonent_id]').val();
        $.ajax({
            url: '/abonents/family/add',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            complete: function () {

            },
            success: function () {
                $('#family_list').load('/abonents/'+ abon_id +' #family_content');
                $('#add_person').modal('hide');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    },
    'remove': function (person_id, abon_id) {

        $.ajax({
            url: '/abonents/family/remove/' + person_id,
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            complete: function () {

            },
            success: function () {
                $('#family_list').load('/abonents/'+ abon_id +' #family_content');
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

function checkAll(id) {
    let checkBoxes = $('#' + id + ' input[type=checkbox]');
    checkBoxes.prop("checked", !checkBoxes.prop("checked"));
}
