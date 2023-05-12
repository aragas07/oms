$(function(){
    $("form").on('submit',function(e){
        e.preventDefault();
        $.ajax({
            url: "route/login",
            type: "post",
            data: {username: $("#username").val(), password: $("#password").val()},
            dataType: "JSON",
            success: function(result){
                result.login ? success(result) : $(".error").css("display","block")
            },
            error: function (request, status, error) {
                swal.fire("error","You are not connected to the database","error") 
            }
        })
    })
    
    if(sessionStorage.length != 0 && sessionStorage.getItem("auth") == "login"){
        window.location.href = "/home"
    }
    function success(res){
        sessionStorage.setItem('auth','login')
        sessionStorage.setItem('location',res.location)
        sessionStorage.setItem('badge',res.badge)
        window.location.href = "/home"
    }
    $("#signup").click(function(e){
        e.preventDefault();
        window.location.href = '/signup';
    })
})