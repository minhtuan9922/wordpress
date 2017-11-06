
jQuery(document).ready(function ($) {

    /** Variables from Customizer for Slider settings */
    if( bakes_and_cakes_data.auto == '1' ){
        var slider_auto = true;
    }else{
        var slider_auto = false;
    }
    
    if( bakes_and_cakes_data.loop == '1' ){
        var slider_loop = true;
    }else{
        var slider_loop = false;
    }
    
    if( bakes_and_cakes_data.pager == '1' ){
        var slider_control = true;
    }else{
        var slider_control = false;
    }

    if( bakes_and_cakes_data.rtl == '1' ){
        var rtl = true;
    }else{
        var rtl = false;
    }
            
   /** Home Page Slider */
    $('#slider').lightSlider({
       item: 1,
       slideMargin: 0,
       mode: bakes_and_cakes_data.animation, //fade, slide//
       speed: bakes_and_cakes_data.a_speed, //ms'
       auto: slider_auto,
       loop: slider_loop,
       pause: bakes_and_cakes_data.speed,  
       pager: slider_control,
       rtl: rtl,
       gallery: false,
       galleryMargin: 5,
       thumbMargin: 5,
       enableDrag:false,
       swipeThreshold: 40,
       
          responsive : [
              {
               breakpoint:767,
               settings: {
                     adaptiveHeight:true,
                     auto: slider_auto,
                        }
              }
          ],
         
    });

     $('.btn-top').click(function () {
         $("html, body").animate({
             scrollTop: 0
         }, 600);
         return false;
     });

    
    $('#responsive-menu-button').sidr({
       name: 'sidr-main',
       source: '#site-navigation',
       side: 'right'
     });

  $('.map').click(function () {
    $('.map iframe').css("pointer-events", "auto");
  });

  $( ".map" ).mouseleave(function() {
    $('.map iframe').css("pointer-events", "none"); 
  });
     

        $("#carousel").owlCarousel({
            margin: 15,
            nav: true,
            dots: false,
            rtl: rtl,
            mouseDrag: false,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 4
                },
                1200: {
                    items: 5
                }
            }
        });

        $(".featured-slider").lightSlider({
                item: 4,
                slideMargin: 0,
                speed: 600, //ms'
                pause: 6000,
                pager: false,
                rtl: rtl,
                gallery: false,
                thumbMargin: 5,
                enableDrag:false,
                swipeThreshold: 40,
                responsive : [
                    {
                        breakpoint:991,
                        settings: {
                            item:3,
                            adaptiveHeight:true,
                        }
                    },
                    {
                        breakpoint:767,
                        settings: {
                            item:1,
                            adaptiveHeight:true,
                        }
                    }
                ],
        });

        $(".tabset").lightSlider({
                        item: 5,
                        slideMargin: 20,
                        speed: 600, //ms'
                        pause: 6000,
                        rtl: rtl,
                        adaptiveHeight:true,
                        pager: false,
                        gallery: false,
                        thumbMargin: 5,
                        swipeThreshold: 40,
                        responsive : [
                            {
                                breakpoint:768,
                                settings: {
                                    item:3,
                                    adaptiveHeight:true,
                                }
                            }
                        ],
                });

    $('.img-btn').click(function(e){
       
        id = $(this).attr('id');
        console.log( id );
        $('.img-btn').removeClass('current');
        $(this).addClass('current');
       
        $.ajax({
            type:'post',
            url : bakes_and_cakes_data.url, 
            data: {  'action' : 'bakes_and_cakes_team_ajax', 'id' : id },          
            beforeSend: function(){
                $('#loader').fadeIn(500);
            },
            success: function(response){
                $('.our-staff .holder').html(response);
            },
            complete: function(){
                $('#loader').fadeOut(500);             
            }            
        });
      
        
    }); 

    // Script for back to top
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.btn-top').fadeIn();
        } else {
            $('.btn-top').fadeOut();
        }
    });

    $('.btn-top').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });


});