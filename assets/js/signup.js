$(function(){
    $("#signup").click(function(){
        $("form").submit()
    })
    $("form").on('submit',function(e){
        e.preventDefault()
        $("#password").val() == $("#confirmation").val() ? 
        $.ajax({
            url: "route/signup",
            type: "POST",
            data: {username: $("#username").val(),password: $("#password").val()},
            success: function(data){
                data ? success() : error()
            },
            error: function (request, status, error) {
                console.log(request.responseText)
            }
        }) : $(".error").css("display","block")
    })
    function success(){
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'You are successfully to sign-up',
            showConfirmButton: false,
            timer: 1300
        })
        setTimeout(() => {
            window.location.href= "/"
        }, 1500);

    }
    function error(){
        swal.fire("Sorry","We have a problem about database connection");
    }
})