$(function(){
    view("home",false,"")
    $(".modal").show()
    $(".close").click(function(){
        $(".modal-form").css("transform","scale(0)")
        setTimeout(()=>{
            $(".modal").hide()
            $(".modal-form").css("transform","scale(1)")
        }, 700)
    })
    let submenu = false;
    let text = "";
    $("#body-logo").click(function(){
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
        view($(this).text()+"",false,"")
    })
    $(".drp-dwn").siblings("ul").children().click(function(){
        if(!submenu){
            submenu = true 
        }
        $(".nav").children(".active").removeClass("active")
        $(this).siblings(".active").removeClass("active")
        $(this).addClass("active").parent().parent().addClass("active")
        text = $(this).text().split(" ")
        $.ajax({
            url: "route/getData",
            type: "POST",
            dataType: "JSON",
            data: {type: text[0]},
            success: function(result){
                console.log(result)
                view("status",true,result)
            },
            error: function (request, status, error) {
                console.log(request.responseText);
            }
        })
    })
    function view(link,stat,result){
        $.ajax({
            url: "templates/properties/"+link+".html",
            success: function(data){
                $("#container").html(data)
                if(stat){
                    $("thead").html(result.thead)
                    $("tbody").html(result.tbody)
                    if(text[0] == 'PERSONNEL' && result.showbtn){
                        $("table").after("<button class='right' id='custom-btn'>Update</button>")
                    }
                }
            }
        })
    }
    $("#container").scroll(function(e){
        $(this).css($(this).scrollTop() > 0 ? 
        {"box-shadow": "inset 0 7px 9px -7px #00000077", "border-top":"1px solid #00000041"}:
        {"box-shadow":"none","border-top": "none"})
    })

})