$(function(){
    $("#logout").click(function(){
        sessionStorage.setItem('auth','none')
        location.href = "/"
    })
    const home = sessionStorage.getItem('location').split(".")
    $(".welcome p").append(" OF "+sessionStorage.getItem('location').toUpperCase())
    $("#"+home[0]).append('<h6 style="margin: 10px 0 0 0; color: #333">Hometown</h6>').prependTo(".flex-body")
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