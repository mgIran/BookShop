$(document).ready(function() {
    $(window).scroll(function() {
        if($(window).scrollTop() > 85)
            $(".navbar.navbar-default").addClass('scroll-mode');
        else
            $(".navbar.navbar-default").removeClass('scroll-mode');
    });

    if ($('.slider').length != 0) {
        $('.slider').owlCarousel({
            items: 1,
            dots: false,
            nav: true,
            navText: ["<i class='arrow-icon'></i>", "<i class='arrow-icon'></i>"],
            autoplay: true,
            autoplayTimeout: 8000,
            autoplayHoverPause: true,
            rtl: true,
            autoHeight: true,
            loop: true
        });

        $('.slider-overlay-nav').click(function () {
            if ($(this).hasClass('slider-next'))
                $('.slider .owl-controls .owl-nav .owl-next').trigger('click');
            else if ($(this).hasClass('slider-prev'))
                $('.slider .owl-controls .owl-nav .owl-prev').trigger('click');
            return false;
        });
    }

    $('.is-carousel').each(function () {
        var items = $(this).data('items'),
            dots = ($(this).data('dots') == 1) ? true : false,
            nav = ($(this).data('nav') == 1) ? true : false,
            margin = $(this).data('margin'),
            responsive = $(this).data('responsive'),
            loop=($(this).data('loop') == 1) ? true : false,
            autoPlay=($(this).data('autoplay') == 1) ? true : false,
            autoPlayHoverPause=($(this).data('autoplay-hover-pause') == 1) ? true : false,
            mouseDrag=($(this).data('mouse-drag') == 1) ? true : false;

        if ($(this).hasClass('auto-width')) {
            var carousel=$(this);
            $(this).on('refresh.owl.carousel', function(){
                setCarouselItemsWidth(carousel, items, margin);
            });

            $(this).owlCarousel({
                autoWidth: true,
                dots: dots,
                nav: nav,
                navText: ["<i class='arrow-icon'></i>", "<i class='arrow-icon'></i>"],
                rtl: true
            });
        } else if ($(this).hasClass('vertical')) {
            $(this).owlCarousel({
                loop: loop,
                autoplay: autoPlay,
                items: items,
                dots:dots,
                nav: nav,
                autoplayHoverPause: autoPlayHoverPause,
                mouseDrag: mouseDrag,
                animateOut: 'slideOutUp',
                animateIn: 'slideInUp',
                rtl: true
            });
        } else {
            $(this).owlCarousel({
                loop: loop,
                autoplay: autoPlay,
                items: items,
                dots:dots,
                nav: nav,
                autoplayHoverPause: autoPlayHoverPause,
                mouseDrag: mouseDrag,
                navText: ["<i class='arrow-icon'></i>", "<i class='arrow-icon'></i>"],
                responsive: responsive,
                rtl: true
            });
        }
    });

    $('.news .arrow-icon').click(function () {
        if ($(this).hasClass('next'))
            $('.news .owl-controls .owl-nav .owl-next').trigger('click');
        else if ($(this).hasClass('prev'))
            $('.news .owl-controls .owl-nav .owl-prev').trigger('click');
        return false;
    });

    $('.tabs .nav a').on('shown.bs.tab', function () {
        var thisTag = $(this);
        var thisTabId = thisTag.attr('href');
        var owlClasses = $(thisTabId).find('.is-carousel');
        owlClasses.trigger('destroy.owl.carousel');
        owlClasses.html(owlClasses.find('.owl-stage-outer').html()).removeClass('owl-loaded');

        owlClasses.on('refresh.owl.carousel', function(){
            var items=owlClasses.data('items'),
                margin=owlClasses.data('margin');
            setCarouselItemsWidth(owlClasses, items, margin);
        });

        owlClasses.owlCarousel({
            autoWidth: true,
            dots: true,
            nav: false,
            rtl: true
        });
    });

    $('.back-to-top').click(function(){
        $('html').animate({scrollTop:0}, 1000);
        return false;
    });

    //paralax
    var $window = $(window);
    $('.paralax .content').each(function(){
        var $bgobj = $(this);
        var yPos = -( ($window.scrollTop()-$bgobj.offset().top + 30) / 5);
        var ycss = 'background-position: 50% '+ yPos + 'px !important; transition: none;';
        $bgobj.attr('style', ycss);

        $(window).scroll(function() {
            var yPos = -( ($window.scrollTop()-$bgobj.offset().top + 30) / 5);
            var ycss = 'background-position: 50% '+ yPos + 'px !important; transition: none;';
            $bgobj.attr('style', ycss);
        });
    });
});

function setCarouselItemsWidth(carousel, items, margin) {
    var objKeys = Object.keys(items),
        itemsCount,
        itemsMargin,
        sumMargin,
        width;

    // Get count of items
    objKeys.reverse();
    for (var i = 0; i < objKeys.length; i++) {
        if ($(window).width() >= objKeys[i]) {
            itemsCount = items[objKeys[i]];
            break;
        }
    }

    // Get margin
    objKeys=Object.keys(margin);
    objKeys.reverse();
    for (i = 0; i < objKeys.length; i++) {
        if ($(window).width() >= objKeys[i]) {
            itemsMargin = margin[objKeys[i]];
            break;
        }
    }

    sumMargin = (itemsCount - 1) * itemsMargin;
    width = (carousel.width() - sumMargin) / itemsCount;

    carousel.find('.thumbnail-container').width(width).css('margin-left', parseInt(itemsMargin));
}