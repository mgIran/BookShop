var $window = $(window),
    $body = $("body");
    $sidebar = $(".sidebar");
$(document).ready(function() {
    $body.on('click','.pin',function () {
        $body.toggleClass('sidebar-mini');
    });
});