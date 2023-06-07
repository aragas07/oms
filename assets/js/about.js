$(function(){
    $.ajax({
        url: 'route/getAbout',
        dataType: 'json',
        success: function(data){
            $("#texts").html(data.text)
            $("#aboutimg").attr('src',data.img)
        }
    })
    $("#custom-btn-about").click(function(){
        $("#default-btn").click()
    })
    $("#default-btn").change(function(){
        const file = this.files[0]
        if(file){
            const reader = new FileReader()
            reader.onload = function(){
                const result = reader.result
                $("#aboutimg").attr("src",result)
                $("#img").val(result)
            }
            reader.readAsDataURL(file)
        }
    })
    var bool = 1

    $("#update-about").attr('hidden',sessionStorage.getItem('city') != sessionStorage.getItem('location'))
    const onEdit=(data)=>{
        $("#texts").attr('contenteditable',data.bool)
        $("#custom-btn-about").attr('hidden',!data.bool)
        $("#update-about").text(data.text).css({'background-color':data.color})
    },
    submit=()=>{
        $.ajax({
            url: 'route/updateAbout',
            type: 'post',
            data: {details: $("#texts").html(), img: $("#img").val()},
            success: function(data){
            }
        })
        onEdit({'bool':false,'color':'#01a5f1', 'text':'Update'})
    }
    $("#update-about").click(()=>{
        bool == 1 ? onEdit({'bool':true,'color':'#044ea1','text':'Submit'}):
        submit()
        onEdit(bool == 1 ? {'bool':true,'color':'#044ea1','text':'Submit'}:
        {'bool':false,'color':'#01a5f1', 'text':'Update'})
        bool == 1 ?
        $("#texts").text($("#texts").html()):
        $("#texts").html($("#texts").text())
        bool = -bool
    })
})