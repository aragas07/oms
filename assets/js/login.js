$(function(){
    $("form").on('submit',function(e){
        e.preventDefault();
        $.ajax({
            url: "route/login",
            type: "post",
            data: {username: $("#username").val(), password: $("#password").val()},
            dataType: "JSON",
            success: function(result){
                result ? success(result.location) : $(".error").css("display","block")
            },
            error: function (request, status, error) {
                swal.fire("error","You are not connected to the database","error") 
            }
        })
    })
    function success(location){
        sessionStorage.setItem('auth','login')
        sessionStorage.setItem('location',location)
        window.location.href = "/home"
    }
    $("#signup").click(function(e){
        e.preventDefault();
        window.location.href = '/signup';
    })
})