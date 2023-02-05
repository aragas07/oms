$(function(){
    view("home")
    let submenu = false;
    $("#body-logo").click(function(){
        console.log("Exampel")
        location.href="/home"
    })
    $("#logout").click(function(){
        sessionStorage.setItem('auth','none')
        location.href = "/"
    })
    $("#body-logo").attr("src","./assets/img/"+sessionStorage.getItem("img"))
    $(".menu").click(function(){
        $(".active").removeClass("active")
        $(this).addClass("active")
        submenu = false;
        view($(this).text()+"")
    })
    $(".drp-dwn").siblings("ul").children().click(function(){
        if(!submenu){
            submenu = true 
            view("status")
        }
        $(".nav").children(".active").removeClass("active")
        $(this).siblings(".active").removeClass("active")
        $(this).addClass("active").parent().parent().addClass("active")
        let text = $(this).text().split(" ")
        $.ajax({
            url: "route/getData",
            type: "POST",
            dataType: "JSON",
            data: {type: text[0]},
            success: function(result){
                $("thead").html(result.thead)
                $("tbody").html(result.tbody)
                console.log(result)
            }
        })
    })
    function view(link){
        $.ajax({
            url: "templates/properties/"+link+".html",
            success: function(data){
                $("#container").html(data)
            }
        })
    }
    $("#container").scroll(function(e){
        $(this).css($(this).scrollTop() > 0 ? 
        {"box-shadow": "inset 0 7px 9px -7px #00000077", "border-top":"1px solid #00000041"}:
        {"box-shadow":"none","border-top": "none"})
    })

})