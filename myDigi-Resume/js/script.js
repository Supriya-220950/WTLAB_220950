// Navigation
$(".menu-link").click(function(e){
    e.preventDefault();

    let target = $(this).data("target");

    $(".content-section").addClass("d-none");
    $("#" + target).removeClass("d-none");

    $(".menu-link").removeClass("active");
    $(this).addClass("active");

    // Animate skills
    if(target === "skills"){
        $(".progress-bar").each(function(){
            let val = $(this).data("width");
            $(this).css("width", val);
        });
    }
});

// Dynamic modal
$(".view-project").click(function(){
    $("#modalTitle").text($(this).data("title"));
    $("#modalBody").text($(this).data("desc"));
});