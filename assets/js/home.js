$(function(){
    const loc = sessionStorage.getItem('location'),
    badge = sessionStorage.getItem('badge')
    console.log(loc)
    $("#badge").text(badge+', '+loc+' Fire')
    $(".welcome p").append(" OF "+loc.toUpperCase())

    $("#logout").click(function(){
        sessionStorage.setItem('auth','none')
        location.href = "/"
    })
    const card = (data, side,ht,h)=>{
        return ('<div id="'+data.name+
        '" class="card h-card '+side+
        '"><img src="./../assets/img/'+data.img+
        '"/><'+h+'>'+data.name+
        '</'+h+'>'+ht+'</div>')
    }


    $.ajax({
        url: "route/getAllMun",
        dataType: 'JSON',
        success: function(data){
            console.log(data)
            for(var i = 0; i < data.all.length ;i++){
                if(i < 5){
                    $("#left").append(card(data.all[i],"side","","h4"))
                }else{
                    $("#right").append(card(data.all[i],"side","","h4"))
                }
            }
            hometown = '<h4 style="margin: 10px 0 0 0; color: #333">Hometown</h4>'
            $("#mid").append(card(data.hometown,"mid",hometown,"h1"))
            $(".card").click(function(e){
                e.preventDefault()
                $.ajax({
                    url: "route/getMun",
                    type: "POST",
                    data: {city: $(this).attr('id')},
                    dataType: "json",
                    success: function(result){
                        sessionStorage.setItem("city", result.name)
                        sessionStorage.setItem("img", result.img)
                        window.location.href = "/municipality"
                    }
                })
            })
        },
        error: function (request, status, error) {
            console.log(request.responseText);
        }
    })
})