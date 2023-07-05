$(function(){
    var admin = ()=>{
        $.get("./templates/properties/adminlist.html",function(e){
            $("#container").html(e)
        })
    }
    admin()
    var staff = ()=>{
        $.get("./templates/properties/staff.html",function(e){
            $("#container").html(e)
        })
    }
    $(".menu").click(function(){
        $(".active").removeClass("active")
        $(this).addClass("active")
        $(this).text() == 'ADMIN' ? admin():staff()
    })
})