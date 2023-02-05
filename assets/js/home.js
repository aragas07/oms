$(function(){
    $("#logout").click(function(){
        sessionStorage.setItem('auth','none')
        location.href = "/"
    })
    $(".card").click(function(e){
        e.preventDefault();
        $.ajax({
            url: "route/getMun",
            type: "POST",
            data: {city: $(this).children('h4').text()},
            dataType: "json",
            success: function(result){
                sessionStorage.setItem("city", result.name)
                sessionStorage.setItem("img", result.img)
                window.location.href = "/municipality"
            }
        })
    })
})