$(function(){
    $("#login").click(function(){
        $("form").submit();
    })
    $("#signup").click(function(e){
        e.preventDefault();
        window.location.href = '/signup';
    })
})