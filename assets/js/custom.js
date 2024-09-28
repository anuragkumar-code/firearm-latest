$(document).ready(function () {
    $('.loader-wrapper').fadeOut("slow");
    $("header .nav-link").click(function () {
        if (!$(this).hasClass('active')) {
            $("header .nav-link.active").removeClass("active");
            $(this).addClass("active");
        }
    });
    // Toggle Mobile Menu
    $('.navbar-toggler').on('click', function () {
        $('.nav-right').toggleClass('show');
        $('.toggle-menu-icon').toggleClass('open');
        $('body').toggleClass('open-menu');
    });
    $("#main-content").click(function () {
        $('.nav-right').removeClass('show');
        $('.navbar-collapse').removeClass('show');
        $('.toggle-menu-icon').removeClass('open');
        $('body').removeClass('open-menu');
    })
    $(function () {
        var pageScroll = 150;
        $(window).scroll(function () {
            var scroll = getCurrentScroll();
            if (scroll >= pageScroll) {
                $('header').addClass('fixed');
            }
            else {
                $('header').removeClass('fixed');
            }
        });
        function getCurrentScroll() {
            return window.pageYOffset || document.documentElement.scrollTop;
        }
    });
});

//------------------------product.php starts---------------------------
$(function () {
    $('#slider-container').slider({
        range: true,
        min: 0,
        max: 9999,
        values: [0, 9999],
        create: function () {
            $("#minAmount").val("$0");
            $("#maxAmount").val("$9999");
        },
        slide: function (event, ui) {
            $("#minAmount").val("$" + ui.values[0]);
            $("#maxAmount").val("$" + ui.values[1]);
            filterSystem(ui.values[0], ui.values[1]);
        }
    })
});

function filterSystem(minPrice, maxPrice) {
   $("#computers div.system").hide().filter(function () {
       var price = parseInt($(this).data("price"), 10);
       return price >= minPrice && price <= maxPrice;
   }).show();
}
//------------------------product.php ends---------------------------


//------------------------product-details.php starts---------------------------

var swiper = new Swiper(".gallery-thumbs", {
    centeredSlides: true,
    centeredSlidesBounds: true,
    spaceBetween: 10,
    watchOverflow: true,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
    breakpoints: {
        0: {
            direction: 'horizontal',
            slidesPerView: 3,
        },
        576: {
            slidesPerView: 3,
            direction: 'vertical',
        }
    }
});

var swiper2 = new Swiper(".gallery-slider", {
    loop: true,
    spaceBetween: 10,
    thumbs: {
        swiper: swiper,
    },
});

// Counter
$(document).on('click', '.number-minus', function () {
    quantity = $('#p_quantity').text();
    newQuantity = Number(quantity) - 1;
    console.log("newQuantity", newQuantity);
    if (newQuantity <= 0) {
        Toast('Product quantity must be positive number.', '3000', '0');
    } else {
        $('#p_quantity').text(newQuantity);
    }
});


$(document).on('click', '.number-plus', function () {
    quantity = $('#p_quantity').text();
    newQuantity = Number(quantity) + 1;
    console.log("newQuantity", newQuantity);
    $('#p_quantity').text(newQuantity);
});

//product-details.php end

