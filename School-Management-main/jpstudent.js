$(document).ready(function(){
    $(".input").click( function(){
        var age = $(this).val();
       var details={
           age:age
       }
        $.ajax({
            url : 'jpstudent.php',
            type : 'POST',
            data :details,
            success : function(info){
               $('.body').html(info);
            }
        });
    });
    $(".search_box").focusin(function(){
        $(".search_tool").css("display","none");
    });
    $(".search_box").focusout(function(){
        $(".search_tool").css("display","inline");
    });
});

        


    