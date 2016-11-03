var $window = $(window),
    $body = $("body");
    $sidebar = $(".sidebar");
$(document).ready(function() {
    $body.on('click','.pin',function () {
        $body.toggleClass('sidebar-mini');
    });
    $("body").on("click",".navbar-toggle",function(){
        $("body").toggleClass("open-sidebar");
        $(".overlay").toggleClass("in");
    });

    $("body").on("click",function(event){
        // if($(event.target))
    });
});