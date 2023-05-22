$(function(){
    $.ajax({
        url: "route/getCity",
        success: function(result){
            console.log(result)
            $("select[name='municipality']").html(result)
        }
    })

    $("form").on('submit',function(e){
        e.preventDefault()
        $("#password").val() == $("#confirmation").val() ? 
        $.ajax({
            url: "route/signup",
            type: "POST",
            data: new FormData(this),
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            success: function(data){
                console.log(data)
                data.length > 1 ?
                swal.fire("error","You are not connected to the database","error") :
                success(data)
            },
            error: function (request, status, error) {
                console.log(request.responseText)
            }
        }) : $(".error").css("display","block")
    })
    function success(isadmin){
        console.log(isadmin)
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'You are successfully to sign-up',
            showConfirmButton: false,
            timer: 1500
        }).then(function(result) {
            if(isadmin.login){
                sessionStorage.setItem('auth','login')
                sessionStorage.setItem('location',isadmin.location)
                sessionStorage.setItem('badge',isadmin.badge)
                window.location.href = "/home"
            }else{
                window.location.href = "/"
            }
        });

    }
    function error(){
        wal.fire("Sorry","We have a problem about database connection");
    }
})