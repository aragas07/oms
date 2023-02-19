$(function(){
    view("home",false,"")
    // $(".notif").css("display",'flex')
    $(".close-modal").click(function(){
        $(".modal-form").css("transform","scale(0)")
        getData('PERSONNEL')
        setTimeout(()=>{
            $(".modal").hide()
            $(".modal-form").css({"transform":"scale(1)",'width':'fit-content'})
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
        getData(text[0])
    })

    function getData(text){
        $.ajax({
            url: "route/getData",
            type: "POST",
            dataType: "JSON",
            data: {type: text},
            success: function(result){
                view("status",true,result)
            },
            error: function (request, status, error) {
                console.log(request.responseText);
            }
        })
    }

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

                        $("#custom-btn").click(function(){
                            $(".modal-head").hide()
                            $(".modal").css({
                                "display":"flex",
                                "justify-content":"center",
                            })
                            $(".modal-body").html("<button id='attendance' class='btn-bottom-border'>Attendance</button><button id='team' class='btn-bottom-border'>Team</button>")
                            $("#attendance").click(function(){
                                $(".modal-head h4").text("Personnel Attendance")
                                $(".modal-head").show()
                                $.get('./../../templates/properties/attendance.html',function(e){
                                    $(".modal-body").html(e)
                                    $("#submit-attendance").click(function(){
                                        $.ajax({
                                            url: "route/attendance",
                                            type: "POST",
                                            data: {name: $("input[name='personnel']").val()+", "},
                                            dataType: "JSON",
                                            success: function(data){
                                                console.log(data)
                                                Swal.fire({
                                                    icon: data.icon,
                                                    title: data.msg,
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                })
                                                if(data.icon == 'success'){
                                                    $("input[name='personnel']").val("")
                                                    getData('PERSONNEL')
                                                }
                                            },
                                            error: function (request, status, error) {
                                                console.log(request.responseText);
                                            }
                                        })
                                    })
                                })
                            })

                            $("#team").click(function(){
                                $(".modal-head").show()
                                $(".modal-form").width("40%")
                                $.get("./../../templates/properties/team.html",function(e){
                                    $(".modal-body").html(e)
                                })
                            })
                        })
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