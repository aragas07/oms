$(function(){
    $("#login").click(function(){
        $("form").submit();
    })

    $("form").on('submit',function(e){
        $.ajax({
            url: "route/login",
            type: "post",
            data: {username: $("#")}
        })
    })
    $("#signup").click(function(e){
        e.preventDefault();
        window.location.href = '/signup';
    })
})