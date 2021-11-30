$(document).ready(function(){
    $('.servicesTabs .serv').click(function (){
        $(this).parent('.servicesTabs').children('.content').toggleClass('opened');
    });
});
