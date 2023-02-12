$(function(){
    $("form").on('submit',function(e){
        e.preventDefault();
        $.ajax({
            url: "route/login",
            type: "post",
            data: {username: $("#username").val(), password: $("#password").val()},
            success: function(result){
                console.log(result)
                result.length > 1 ?
                swal.fire("error","You are not connected to the database","error") :
                    result ? success() : $(".error").css("display","block")
            }
        })
    })
    function success(){
        sessionStorage.setItem('auth','login')
        window.location.href = "/home"
    }
    $("#signup").click(function(e){
        e.preventDefault();
        window.location.href = '/signup';
    })
})