$(function(){
    let page = ''
    view("home",false,"")
    if(sessionStorage.getItem('city') == sessionStorage.getItem('location'))
        hasNotif()
    $(".close-modal").click(function(){
        $(".modal-form").css("transform","scale(0)")
        if(page == 'PERSONNEL' || page == 'INCIDENT')
            getData(page)
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
        page = $(this).attr('value')
        view(page,false,"")
    })
    $(".drp-dwn").siblings("ul").children().click(function(){
        if(!submenu){
            submenu = true 
        }
        $(".nav").children(".active").removeClass("active")
        $(this).siblings(".active").removeClass("active")
        $(this).addClass("active").parent().parent().addClass("active")
        text = $(this).text().split(" ")
        page = text[0]
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
                    if(result.showbtn){
                        $("table").after("<button class='right' id='custom-btn'>Update</button>")
                        if(text[0] == 'PERSONNEL'){
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
                        }else if(text[0] == 'VEHICLE'){
                        }else{
                            $("#custom-btn").click(function(){
                                $(".modal").show().children().width('40%')
                                table = '<table class="box-shadow" id="modal-table"><thead>'+result.thead+'</thead><tbody>'+result.tbody+'</tbody></table>'
                                table += "<div class='f-width text-right mt-10 mb-5'><button id='edit' class='btn-primary'>Edit</button></div>"
                                $(".modal-body").html(table)
                               $("#modal-table").children().each(function(i){
                                    $(this).children().each(function(){
                                        i > 0 ? 
                                        $(this).children().eq(3).html('<select alt="'+$(this).attr('value')+'"><option value="2">On working</option><option value="3">Done</option></select>') :
                                        $(this).children().eq(3).text('Change Status')
                                        $(this).children().eq(1).hide()
                                    })
                                })

                                $("#edit").click(function(){
                                    $("select").each(function(){
                                        var id = $(this).attr('alt').split('|')
                                        $.ajax({
                                            url: 'route/rtcs',
                                            type: "POST",
                                            data: {activities: id[0], team: id[1], status: $(this).val()}
                                        })
                                        swal.fire('success','The status has been update','success')
                                    })
                                })
                            })
                        }
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

    function hasNotif(){
        $.ajax({
            url: 'route/getnewAc',
            success: function(num){
                if(num > 0){
                    $(".notif").css("display",'flex')
                    $(".notif").html(num)
                }else{
                    $(".notif").css("display",'none')
                }
                setTimeout(()=>{
                    hasNotif()
                }, 3000)
            }
        })
    }
})