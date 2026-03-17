$(document).ready(function(){

    // =========================
    // 🔹 SELECTORS (TEXT STYLING)
    // =========================
    $("#styleBtn").click(function(){

        // Basic selectors
        $("p").css("color", "blue");         
        $("#title").css("color", "red");    
        $(".special").css("font-weight","bold");

        $("h1,p").css("border","1px solid gray");

        // Hierarchy selectors
        $("body p").css("background","#f9f9f9");
        $("body > h1").css("background","#ddd");

        $(".text + p").css("background","lightyellow");
        $(".text ~ p").css("font-style","italic");

        // Filter selectors
        $("p:first").css("font-size","22px");
        $("p:last").css("color","green");
        $("p:eq(1)").css("background","lightblue");

        $("p:even").css("opacity","0.7");
        $("p:odd").css("opacity","1");

        $("p:not(.special)").css("text-decoration","underline");

        // Attribute selectors (demo)
        $("p[class]").css("border-radius","5px");
        $("p[class='text']").css("padding","10px");
        $("p[class^='spe']").css("color","purple");
        $("p[class$='ial']").css("background","#ffe6f0");
        $("p[class*='ec']").css("font-style","italic");
    });


    // =========================
    // 🔹 ANIMATION (Lottie box)
    // =========================

    // Fade animation
    $("#fadeBtn").click(function(){
        $("#box").fadeToggle();
    });

    // Slide animation
    $("#slideBtn").click(function(){
        $("#box").slideToggle();
    });

    // Show/Hide toggle
    $("#toggleBtn").click(function(){
        $("#box").toggle();
    });

    // Zoom in
    $("#zoomInBtn").click(function(){
        $("#box").animate({
            width: "400px",
            height: "400px"
        }, 500);
    });

    // Zoom out
    $("#zoomOutBtn").click(function(){
        $("#box").animate({
            width: "300px",
            height: "300px"
        }, 500);
    });

    // Move animation
    $("#moveBtn").click(function(){
        $("#box").animate({marginLeft:"150px"},600)
                 .animate({marginLeft:"0px"},600);
    });


    // =========================
    // 🔹 EXTRA TEXT EFFECT
    // =========================
    $("#title").hover(function(){
        $(this).css({
            transform:"scale(1.2)",
            color:"purple"
        });
    }, function(){
        $(this).css({
            transform:"scale(1)",
            color:"#333"
        });
    });

});