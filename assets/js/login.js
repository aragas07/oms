$(function(){
    $("form").on('submit',function(e){
        e.preventDefault();
        $.ajax({
            url: "route/login",
            type: "post",
            data: {username: $("#username").val(), password: $("#password").val()},
            success: function(result){
                result ? success() : $(".error").css("display","block")
            }
        })
    })
    console.log(sessionStorage.getItem('auth'))
    function success(){
        sessionStorage.setItem('auth','login')
        console.log(sessionStorage.getItem('auth'))
        window.location.href = "/home"
    }
    $("#signup").click(function(e){
        e.preventDefault();
        window.location.href = '/signup';
    })
})