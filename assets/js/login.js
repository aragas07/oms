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
    
    
    // sessionStorage.setItem('auth','superadmin')
    if(sessionStorage.length != 0 && sessionStorage.getItem("auth") == "login"){
        window.location.href = "/home"
    }else if(sessionStorage.length != 0 && sessionStorage.getItem("auth") == "superadmin"){
        console.log(sessionStorage.getItem("auth"))
        window.location.href = "/superadmin"
    }
    function success(res){
        sessionStorage.setItem('auth',res.auth == 'admin' ? 'login':'superadmin')
        sessionStorage.setItem('location',res.location)
        sessionStorage.setItem('badge',res.badge)
        console.log(res)
        window.location.href = res.auth == 'admin' ? "/home":"superadmin"
    }
    $("#signup").click(function(e){
        e.preventDefault();
        window.location.href = '/signup';
    })
})