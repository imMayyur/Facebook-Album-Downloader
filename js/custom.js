$(window).on("scroll", function() {
    $(window).scrollTop() >= 50 ? $(".sticky").addClass("stickyadd") : $(".sticky").removeClass("stickyadd")
}), $(".navbar-nav a").on("click", function(o) {
    var a = $(this);
    $("html, body").stop().animate({
        scrollTop: $(a.attr("href")).offset().top - 0
    }, 1500, "easeInOutExpo"), o.preventDefault()
}), $("#navbarCollapse").scrollspy({
    offset: 20
});
var scroll = $(window).scrollTop();
$(".navbar-toggle").on("click", function(o) {
    $(this).toggleClass("open"), $("#navi_mob_menu").slideToggle(400)
}), $(".nav_menu>li").slice(-2).addClass("last-elements"), $("#status").fadeOut(), $("#preloader").delay(350).fadeOut("slow"), $("body").delay(350).css({
    overflow: "visible"
}), $(document).ready(function() {
    $("#owl_clients").owlCarousel({
        autoPlay: 3e3,
        items: 1,
        itemsDesktop: [1199, 1],
        itemsDesktopSmall: [979, 1]
    })
}), $(window).on("scroll", function() {
    $(this).scrollTop() > 100 ? $(".back_top_angle_up").fadeIn() : $(".back_top_angle_up").fadeOut()
}), $(".back_top_angle_up").on("click", function() {
    return $("html, body").animate({
        scrollTop: 0
    }, 1e3), !1
}), 
$('.img-zoom').magnificPopup({
    type: 'image',
    closeOnContentClick: true,
    mainClass: 'mfp-fade',
    gallery: {
        enabled: true,
        navigateByImgClick: true,
        preload: [0, 1]
    }
});

 $(window).on('load', function () {
    var $container = $('.work-filter');
    var $filter = $('#menu-filter');
    $container.isotope({
        filter: '*',
        layoutMode: 'masonry',
        animationOptions: {
            duration: 750,
            easing: 'linear'
        }
    });

    $filter.find('a').on("click",function() {
        var selector = $(this).attr('data-filter');
        $filter.find('a').removeClass('active');
        $(this).addClass('active');
        $container.isotope({
            filter: selector,
            animationOptions: {
                animationDuration: 750,
                easing: 'linear',
                queue: false,
            }
        });
        return false;
    });
});