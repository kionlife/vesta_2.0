$(document).ready(function(){
/*    $('.servicesTabs .serv').click(function (){
        $(this).parent('.servicesTabs').children('.content').toggleClass('opened');
    });*/


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
            complete: function() {

            },
            success: function(data) {
                window.location.replace('/abonents/' + data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
}



var meter = {
    'add': function() {
        $.ajax({
            url: '/meters/add',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $('#add_meter form').serialize(),
            complete: function() {

            },
            success: function() {
                $('#card_meters').load('/abonents/1 #meters_content');
                $('#add_meter').modal('hide');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    },
    'remove': function(meter_id) {
        $.ajax({
            url: '/meters/remove/' + meter_id,
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            complete: function() {

            },
            success: function() {
                $('#card_meters').load('/abonents/1 #meters_content');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
}

function tabShow(id) {
    $('#' + id).toggleClass('opened');
}
