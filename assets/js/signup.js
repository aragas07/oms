$(function(){
    $("form").on('submit',function(e){
        e.preventDefault()
        $("#password").val() == $("#confirmation").val() ? 
        $.ajax({
            url: "route/signup",
            type: "POST",
            data: {
                username: $("#username").val(),
                password: $("#password").val(),
                firstname: $("#firstname").val(),
                middlename: $("#middlename").val(),
                lastname: $("#lastname").val()
            },
            success: function(data){
                console.log(data)
                data.length > 1 ?
                swal.fire("error","You are not connected to the database","error") :
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
            sessionStorage.setItem('auth','login')
            window.location.href = "/home"
        }, 1500);

    }
    function error(){
        swal.fire("Sorry","We have a problem about database connection");
    }
})