$(document).ready(function(){
    $('.servicesTabs .serv').click(function (){
        $(this).parent('.servicesTabs').children('.content').toggleClass('opened');
    });
});


var meter = {
    'add': function(abonent_id) {
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
