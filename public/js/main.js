$(document).ready(function() {

    $('.go-top').click(function(event) {
      event.preventDefault();
      var target = $(this).find('>a').prop('hash');
      $('html, body').animate({
        scrollTop: $(target).offset().top
      }, 500);
    });

    $('.my-slider').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        adaptiveHeight: true,
        autoplay: true,
        mobileFirst: true,
        arrows: false,
        centerMode: true,
        centerPadding: '0px'
        // variableWidth: true
    });


    $('#search').on('click',function () {
        if(word=='') {
            alert('Заполните поле поиска информации');
        }
        else {
            $( "#form_search" ).submit();
        }
    });

    $('.link').on('click', function () {
        $('.link').toggleClass('selected');
        let type = $(this).attr('rel');
        $('.card').hide();
        $('.type'+type).show();
    });


    $('.submit-button').click(function() {

        let send = true;
        let id = $(this).attr('rel');
        let empty_field = '';
        $('.field').each(function () {
           if ($(this).val()==='' || $(this).val()===' ') {
               empty_field = $(this).attr('rel');
               send  = false;
               return false;
           }
        });
        if (($('#message'+id).val()==='' || $('#message'+id).val()===' ') && send===true) {
            empty_field = 'message';
            send = false;
        }


        if (send) {
            $.ajax({
                url: "/send_form/" + id,
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "Post",
                data: $('#sendform'+id).serialize(),
                success: function (data) {
                    $('.form-area' + id).html('<h2>'+data.result+'</h2>');
                },
                error: function (data) {
                    $('.form-area' + id).html('<h2>Сообщение не отправлено</h2>');
                },
                complete: function (data) {
                }
            });
        }
        else {
            console.log('Заполните поле ', empty_field, id);
            $('#'+empty_field+id).toggleClass('empty-field');
        }
        console.log('send data form ', $(this).attr('rel'));
        return false;
    });

    $('.submit-quest').click(function() {

        let send = true;
        let id = $(this).attr('rel');
        let empty_field = '';
        $('.field').each(function () {
            if ($(this).val()==='' || $(this).val()===' ') {
                empty_field = $(this).attr('rel');
                send  = false;
                return false;
            }
        });
        if (($('#message'+id).val()==='' || $('#message'+id).val()===' ') && send===true) {
            empty_field = 'message';
            send = false;
        }


        if (send) {
            $.ajax({
                url: "/send_quest/" + id,
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "Post",
                data: $('#sendquest'+id).serialize(),
                beforeSend: function() {
                    $('.form-area' + id).html('<h2>Вопрос отправляется</h2>');
                },
                success: function (data) {
                    $('.form-area' + id).html('<h2>'+data.result+'</h2>');
                },
                error: function (data) {
                    $('.form-area' + id).html('<h2>Сообщение не отправлено</h2>');
                },
                complete: function (data) {
                }
            });
        }
        else {
            console.log('Заполните поле ', empty_field, id);
            $('#'+empty_field+id).toggleClass('empty-field');
        }
        console.log('send data form ', $(this).attr('rel'));
        return false;
    });


    $('.field').blur(function() {
        if ($(this).val !== '' && $(this).val !== ' ') {
            $(this).removeClass('empty-field');
        }
    });

     $(function() {

      $(window).scroll(function() {

      if($(this).scrollTop() != 0) {

      $('.go-top').fadeIn();
      $('.go-top-top').fadeIn();

      } else {

      $('.go-top').fadeOut();
      $('.go-top-top').fadeOut();

      }

      });

      $('.go-top').click(function() {

      $('body,html').animate({scrollTop:0},800);

      });

      });

  $( ".reviews-button" ).click(function(e) {
    $(this).prev().slideToggle('slow', function(){
        if($(this).is(':visible')){
            $(this).next().html('Свернуть');
        }else{
           $(this).next().html('Читать весь отзыв');
        }

  });
        e.preventDefault();
  });

  $('#histories-tabs').tabs({
    heightStyle: "auto"
  });

  $( ".accordion" ).accordion();
  //   $('.accordion').collapse({
  //       toggle: false
  //   });

  $( ".select-date" ).selectmenu();


  $('.modalbox').fancybox();
  $('.anchor').bind("click", function(e){
      var anchor = $(this);
      $('html, body').stop().animate({
      scrollTop: $(anchor.attr('href')).offset().top-90
      }, 1000);
      e.preventDefault();
    });

    $('.partners-slider').slick({
    slidesToShow: 4,
    dots:true,
    arrows:false,
    slidesToScroll: 1,
      responsive: [
    {
      breakpoint: 1199,
      settings: {
        slidesToShow: 3
      }
    },
    {
      breakpoint: 991,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
        arrows:false,
        dots:true
      }
    },
    {
      breakpoint: 767,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows:false,
        dots:true
      }
    }
  ]
  });

  $('.portfolio-home-slider').slick({
    slidesToShow: 1,
    dots:true,
    arrows:false,
    slidesToScroll: 1,
      responsive: [
    {
      breakpoint: 1300,
      settings: {

      }
    },
    {
      breakpoint: 767,
      settings: {

      }
    }
  ]
  });

$(document).ready(function ($) {
    $.fn.menumaker = function (options) {
        var flexmenu = $(this), settings = $.extend({
                format: 'dropdown',
                sticky: false
            }, options);
        return this.each(function () {
            $(this).find('.button').on('click', function () {
                $(this).toggleClass('menu-opened');
                var mainmenu = $(this).next('ul');
                if (mainmenu.hasClass('open')) {
                    mainmenu.slideToggle().removeClass('open');
                } else {
                    mainmenu.slideToggle().addClass('open');
                    if (settings.format === 'dropdown') {
                        mainmenu.find('ul').show();
                    }
                }
            });
            flexmenu.find('li ul').parent().addClass('has-sub');
            subToggle = function () {
                flexmenu.find('.has-sub').prepend('<span class="submenu-button"></span>');
                flexmenu.find('.submenu-button').on('click', function () {
                    $(this).toggleClass('submenu-opened');
                    if ($(this).siblings('ul').hasClass('open')) {
                        $(this).siblings('ul').removeClass('open').slideToggle();
                    } else {
                        $(this).siblings('ul').addClass('open').slideToggle();
                    }
                });
            };
            if (settings.format === 'multitoggle')
                subToggle();
            else
                flexmenu.addClass('dropdown');
            if (settings.sticky === true)
                flexmenu.css('position', 'fixed');
            resizeFix = function () {
                var mediasize = 768;
                if ($(window).width() > mediasize) {
                    flexmenu.find('ul').show();
                }
                if ($(window).width() <= mediasize) {
                    flexmenu.find('ul').hide().removeClass('open');
                }
            };
            resizeFix();
            return $(window).on('resize', resizeFix);
        });
    };

   $('#flexmenu').menumaker({ format: 'multitoggle' });

}(jQuery));

         var $menu = $("#menu");
            $(window).scroll(function(){
                if ( $(this).scrollTop() > 0 && $menu.hasClass("default-menu") ){
                    $menu.fadeOut(0,function(){
                        $(this).removeClass("default-menu")
                            .addClass("fixed-menu")
                            .fadeIn(0)

                    });
                } else if($(this).scrollTop() <= 0 && $menu.hasClass("fixed-menu")) {
                    $menu.fadeOut(0,function(){
                        $(this).removeClass("fixed-menu")
                            .addClass("default-menu")
                            .fadeIn(0);
                    });
                }
            });

        var number = document.querySelector('.number1'),
            numberTop = number.getBoundingClientRect().top,
            start = 0, end = number1_value;

        window.addEventListener('scroll', function onScroll() {
            if(window.pageYOffset > numberTop - window.innerHeight / 2) {
                this.removeEventListener('scroll', onScroll);
                var interval = setInterval(function() {
                    number.innerHTML = ++start;
                    if(start == end) {
                        clearInterval(interval);
                    }
                }, 5);
            }
        });


       var number2 = document.querySelector('.number2'),
            numberTop2 = number2.getBoundingClientRect().top,
            start2 = 0, end2 = number2_value;

        window.addEventListener('scroll', function onScroll2() {
            if(window.pageYOffset > numberTop2 - window.innerHeight / 2) {
                this.removeEventListener('scroll', onScroll2);
                var interval2 = setInterval(function() {
                    number2.innerHTML = ++start2;
                    if(start2 == end2) {
                        clearInterval(interval2);
                    }
                }, 20);
            }
        });

        var number3 = document.querySelector('.number3'),
            numberTop3 = number3.getBoundingClientRect().top,
            start3 = 0, end3 = number3_value;

        window.addEventListener('scroll', function onScroll3() {
            if(window.pageYOffset > numberTop3 - window.innerHeight / 2) {
                this.removeEventListener('scroll', onScroll3);
                var interval3 = setInterval(function() {
                    number3.innerHTML = ++start3;
                    if(start3 == end3) {
                        clearInterval(interval3);
                    }
                }, 1);
            }
        });

        var number4 = document.querySelector('.number4'),
            numberTop4 = number4.getBoundingClientRect().top,
            start4 = 0, end4 = number4_value;

        window.addEventListener('scroll', function onScroll4() {
            if(window.pageYOffset > numberTop4 - window.innerHeight / 2) {
                this.removeEventListener('scroll', onScroll4);
                var interval4 = setInterval(function() {
                    number4.innerHTML = ++start4;
                    if(start4 == end4) {
                        clearInterval(interval4);
                    }
                }, 20);
            }
        });





});
