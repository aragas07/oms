$(function(){
    let page = ''
    view("home",false,"")
    if(sessionStorage.getItem('city') == sessionStorage.getItem('location'))
        hasNotif()
    console.log($("#update-about").html())
    $(".close-modal").click(function(){
        $('.btn-outline-primary').remove()
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
    $(".back").click(function(){
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
                console.log(result)
                view("status",true,result)
            },
            error: function (request, status, error) {
                console.log(request.responseText);
            }
        })
    }

    function view(link,stat,result){
        $("#update-about").attr("hidden",result.showbtn)
        $.ajax({
            url: "templates/properties/"+link+".html",
            success: function(data){
                $("#container").html(data)
                if(stat){
                    $("thead").html(result.thead)
                    $("tbody").html(result.tbody)
                    if(result.showbtn){
                        $("table").before("<button class='right' id='custom-btn'>Update</button>")
                        $("select").each(function(){
                            this.bool = false
                            this.val = $(this).val()
                            $(this).change(()=>{
                                $(this).val() == this.val ? $(this).removeClass('changed') : $(this).addClass('changed')
                            })
                        })
                        if(text[0] == 'PERSONNEL'){
                            $("#custom-btn").after("<button class='right btn-outline-primary mr-3' id='report-btn'>Report</button>")
                            $("#custom-btn").after("<button class='right' id='team'>Team</button>")
                            $("#custom-btn").text("Attendance")
                            $("#custom-btn").click(function(){
                                $(".modal").css({
                                    "display":"flex",
                                    "justify-content":"center",
                                })
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
                                                swal(data)
                                                if(data.icon == 'success'){
                                                    $("input[name='personnel']").val("")
                                                    getData('PERSONNEL')
                                                }
                                            }
                                        })
                                    })
                                })
    
                            })
                            $("#team").click(function(){
                                $(".modal").css({
                                    "display":"flex",
                                    "justify-content":"center",
                                })
                                $(".modal-head").children('h4').text('Team update')
                                const showteam = $.get("./../../templates/properties/team.html",function(e){
                                    $(".modal-body").html(e)
                                })
                                $(".modal-tools").prepend('<button id="add" class="btn-outline-primary mr-3">Add new</button>')
                                $("#add").click(()=>{
                                    $.ajax({
                                        url: 'route/glTeam',
                                        success: function(r){
                                            console.log(r)
                                            Swal.fire({
                                                title: "You'll add team "+r+" to your list of teams.",
                                                icon: 'question',
                                                showCancelButton: true,
                                                confirmButtonText: 'Yes'
                                            }).then((res)=>{
                                                if(res.isConfirmed){
                                                    $.ajax({
                                                        url: 'route/addteam',
                                                        success: function(isSuccess){
                                                            if(isSuccess)
                                                                Swal.fire('Success','The team will be added','success')
                                                            showteam
                                                        }
                                                    })
                                                }
                                            })
                                        }
                                    })
                                })
                                $(".modal-form").width("40%")
                                showteam
                            })
                            $("#report-btn").click(function(){
                                $(".modal").css({
                                    "display":"flex",
                                    "justify-content":"center",
                                })
                                $.get("./../../templates/properties/reportattendance.html",function(e){
                                    $(".modal-body").html(e)
                                })
                            })
                        }else if(text[0] == 'VEHICLE'){
                            // $("#custom-btn").after("<button id='add' class='right btn-primary mr-3'>Add vehicle</button>")
                            $("#add").click(()=>{
                                $(".modal").css({
                                    "display":"flex",
                                    "justify-content":"center",
                                })
                                $(".modal-head").children('h4').text('Add Vehicle')
                                $(".modal-body").html('')
                                $(".modal-form").width("40%")
                            })
                            $("#custom-btn").click(function(){
                                vehicle(0,0)
                            })
                            $("#team")
                        }else if(text[0] == 'TEAM'){
                            $("#custom-btn").click(function(){
                                $(".changed").each(function(){
                                    $.ajax({
                                        url: 'route/updateTeam',
                                        type: 'post',
                                        data: {id: $(this).attr('id'), value: $(this).val()}
                                    })
                                })
                                swal({
                                    icon: 'success',
                                    msg: "The data has been updated"
                                })
                            })
                        }else{
                            $("#custom-btn").click(function(){
                                if($(".changed").length > 0)
                                    incident(0,$(".changed").eq(0))
                            })
                        }
                    }
                }
            }
        })
    }

    function swal(data){
        Swal.fire({
            icon: data.icon,
            title: data.msg,
            showConfirmButton: false,
            timer: 1500
        })
    }
    function vehicle(i,response){
        let a = $(".vehStatus").eq(i),
        b = $(".vehicle-status").eq(i),
        c = $(".type-status").eq(i)
        $.ajax({
            url: 'route/updateVehicle',
            type: 'post',
            dataType: 'JSON',
            data: {id: a.attr('id'), stats: a.val(), response: response, vehicle: b.val(), type: c.val()},
            success: function(e){
                console.log(e)
                i++
                if(i <= $(".vehStatus").length)
                e.onUse ? 
                Swal.fire({
                    icon: 'question',
                    title: e.vehicle+' is on use',
                    text: 'Are you sure that you want to change this status?',
                    showDenyButton: true,
                    confirmButtonText: 'Yes',
                }).then((result) => {
                    let j = 1
                    result.isConfirmed ? i-- : j--
                    vehicle(i,j)
                }) : vehicle(i,0)
            }
        })
        swal({
            icon: 'success',
            msg: "The data has been updated"
        })
    }
    function incident(i,e){
        i++
        const ev = e.parent().siblings(),
        c = $(".changed")
        Swal.fire(e.val() > 1 ?
        {
            icon: 'question',
            title: ev.eq(1).html()+"'s "+ev.eq(0).html()+" has been extinguish?",
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }:{
            icon: 'error',
            title: 'The on working status cannot be changed to on going.'
        }).then((result)=>{
            if(result.isConfirmed){
                $.ajax({
                    url: 'route/updateInc',
                    type: 'POST',
                    data: {id: e.attr('id'), value: e.val()},
                    success: function(response){
                        console.log(response)
                    }
                })
            }
            c.length > i ? incident(i,c.eq(i)): getData('INCIDENT')
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