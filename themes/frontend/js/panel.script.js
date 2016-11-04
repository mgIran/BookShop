var $window = $(window),
    $body = $("body");
    $sidebar = $(".sidebar");
$(document).ready(function() {
    var $panel_cookie=1;
    if ($.cookie('p-s-mode'))
    {
        $panel_cookie = $.cookie('p-s-mode');
        if($panel_cookie == 1)
            $body.addClass('sidebar-mini');
        else
            $body.removeClass('sidebar-mini');
    }
    $body.on('click','.pin',function () {
        $body.toggleClass('sidebar-mini');
        if($body.hasClass('sidebar-mini'))
            $panel_cookie=1;
        else
            $panel_cookie=0;
        var time = 10 * 365 ;
        $.cookie('p-s-mode', $panel_cookie,{expires: time ,path:'/'});
    });

    $("body").on("click",".navbar-toggle",function(){
        $("body").toggleClass("open-sidebar");
        $(".overlay").toggleClass("in");
    });

    $("body").on("click",function(event){
        var close = true;
        if($(event.target).is('.navbar-toggle'))
            close = false;
        if($body.hasClass('open-sidebar') && $(event.target).is('.sidebar , .sidebar *'))
           close = false;
        if(close) {
            $("body").removeClass("open-sidebar");
            $(".overlay").removeClass("in");
        }
    });
    $window.resize(function () {
        if($window.width() > 768)
        {
            $("body").removeClass("open-sidebar");
            $(".overlay").removeClass("in");
        }
    });
});

$window.load(function() {
    if ($('.sidebar').length != 0) {
        var height,
            navHeight;
        if($window.width()>=768)
            navHeight= 140;
        else if($window.width() < 768)
            navHeight= 120;
        if (typeof CKEDITOR == 'undefined') {
            height = ($('body').height() < $(window).height()) ? $(window).height() : $('body').height();
            $('.sidebar').height(height - navHeight);
        }else
            CKEDITOR.on('instanceReady', function () {
                height = ($('body').height() < $(window).height()) ? $(window).height() : $('body').height();
                $('.sidebar').height(height - navHeight);
            });
    }
});