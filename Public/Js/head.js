/**
 * 
 * @authors Your Name (you@example.org)
 * @date    2013-10-07 10:26:54
 * @version $Id$
 */
var b=0;
function a(temp){
    var oclass = $(temp).attr("class");
    var n=oclass.split(" ");
    for(var i=0; i< n.length;i++)
    {
        if(n[i]=="hover"){
            b=1;
        }

    }
}
$(document).ready(function(){

    $(".num2").hover(
        function () {
            a(this);
            $(this).addClass("hover");
            $("#num2").css("display","block")
        },
        function () {
            if(b!=1){
                $(this).removeClass("hover");
            }
            $("#num2").css("display","none");
            b=0;
        }
    )

    $(".num3").hover(
        function () {
            a(this)
            $(this).addClass("hover");
            $("#num3").css("display","block")
        },
        function () {
            if(b!=1){
                $(this).removeClass("hover");
            }
            $("#num3").css("display","none");
            b=0;
        }
    )

    $(".num5").hover(
        function () {
            a(this);
            $(this).addClass("hover");
            $("#num5").css("display","block")
        },
        function () {
            if(b!=1){
                $(this).removeClass("hover");
            }
            $("#num5").css("display","none");
            b=0;
        }
    )
})

