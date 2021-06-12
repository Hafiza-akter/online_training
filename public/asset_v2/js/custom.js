  function ajax_request(action,method,dataArray,div){
    
        $("#"+div).html('<div id="loading"> <i class="fas fa-spinner fa-spin"></i></div>');
       
      $.ajax({
          type: method,
          url: action,
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },

          data: dataArray,
          cache: false,
          success: function(res) {
                // $('#loading').hide();
                $("#"+div).html(res.html);


          },
          error:function(request, status, error) {
                $('#loading').hide();

             alert('エラーが発生しました。');
              console.log("ajax call went wrong:" + request.responseText);
          }
      });
  }
// (function ($) {
//     "use strict";
//     $("#datepicker").datepicker();
//     var review = $(".player_info_item");
//     if (review.length) {
//         review.owlCarousel({
//             items: 1,
//             loop: true,
//             dots: false,
//             autoplay: true,
//             margin: 40,
//             autoplayHoverPause: true,
//             autoplayTimeout: 5000,
//             nav: true,
//             navText: ['<img src="img/icon/left.svg" alt="">', '<img src="img/icon/right.svg" alt="">'],
//             responsive: { 0: { margin: 15 }, 600: { margin: 10 }, 1000: { margin: 10 } },
//         });
//     }
//     $(".popup-youtube, .popup-vimeo").magnificPopup({ type: "iframe", mainClass: "mfp-fade", removalDelay: 160, preloader: false, fixedContentPos: false });
//     $(document).ready(function () {
//         // $("select").niceSelect();
//     });
//     var review = $(".client_review_part");
//     if (review.length) {
//         review.owlCarousel({ items: 1, loop: true, dots: true, autoplay: true, autoplayHoverPause: true, autoplayTimeout: 5000, nav: false });
//     }
//     $(window).scroll(function () {
//         var window_top = $(window).scrollTop() + 1;
//         if (window_top > 50) {
//             $(".main_menu").addClass("menu_fixed animated fadeInDown");
//         } else {
//             $(".main_menu").removeClass("menu_fixed animated fadeInDown");
//         }
//     });
//     if (document.getElementById("default-select")) {
//         // $("select").niceSelect();
//     }
//     $(".slider").slick({ slidesToShow: 1, slidesToScroll: 1, arrows: false, speed: 300, infinite: true, asNavFor: ".slider-nav-thumbnails", pauseOnFocus: true, dots: true });
//     $(".slider-nav-thumbnails").slick({
//         slidesToShow: 3,
//         slidesToScroll: 1,
//         asNavFor: ".slider",
//         focusOnSelect: true,
//         infinite: true,
//         prevArrow: false,
//         nextArrow: false,
//         centerMode: true,
//         responsive: [{ breakpoint: 480, settings: { centerMode: false } }],
//     });
//     $(".slider-nav-thumbnails .slick-slide").removeClass("slick-active");
//     $(".slider-nav-thumbnails .slick-slide").eq(0).addClass("slick-active");
//     $(".slider").on("beforeChange", function (event, slick, currentSlide, nextSlide) {
//         var mySlideNumber = nextSlide;
//         $(".slider-nav-thumbnails .slick-slide").removeClass("slick-active");
//         $(".slider-nav-thumbnails .slick-slide").eq(mySlideNumber).addClass("slick-active");
//     });
//     $(".slider").on("afterChange", function (event, slick, currentSlide) {
//         $(".content").hide();
//         $(".content[data-id=" + (currentSlide + 1) + "]").show();
//     });
//     $(".gallery_img").magnificPopup({ type: "image", gallery: { enabled: true } });
// })(jQuery);
