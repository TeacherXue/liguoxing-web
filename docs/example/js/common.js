$(function () {
    let $win = $(window);
    let $winWidth = $win.width();

    // wow初始化
    new WOW().init();

    // 搜索框toggle
    searchToggle()
    
    // 图片懒加载
    $("img.lazy").lazyload({
        effect: "fadeIn",
        threshold: 200,
        failure_limit: 0
    });

    window.lazyFunctions = {
        carters(element) {
            alert('carter')
        }
    };

    // var myLazyLoad = new LazyLoad({
    //     // Your custom settings go here
    //     // unobserve_entered: true, // 避免多次执行
    //     // callback_enter: executeLazyFunction,  




    //     // 图片错误时
    //     callback_error: (img) => {
    //         // img.setAttribute("srcset", "assets/app/banner/product.jpg");
    //         // img.setAttribute("src", "assets/app/banner/product.jpg");
    //     },
    // });

    inquireInfo('.mod-btn.inquire','.prodeta-quote')

    // 数字滚动
    if($.fn.appear){
        hc.numRoll(".home-data-item .number", false, 1000);
    }

    stopIncident(['.home-hot-link .cart-btn'])

    $('.product-nav-item').hover(function(){
        $(this).addClass('active').siblings().removeClass('active')
        $(this).find('.product-nav-second').stop().slideDown()
        $(this).siblings().find('.product-nav-second').stop().slideUp()
    },function(){})

    $('.gotop').click(function(){
        $('body,html').animate({
            scrollTop:0
        },500)
    })

    formLabel('.mod_form_item input')
    formLabel('.mod_form_item textarea')


    if($winWidth>1200){
        $('.hd_item').hover(function(){
            $(this).find('.hd_second').stop().slideDown()
        },function(){
            $(this).find('.hd_second').stop().slideUp()
        })
    }else{
        $('#burger').change(function(){
            $('nav').stop().slideToggle()
        })  

        $('.child').click(function(e){
            e.stopPropagation()
            $(this).children('ul').stop().slideToggle()
            $(this).siblings().children('ul').stop().slideUp()
            $(this).siblings().removeClass('open')
            $(this).toggleClass('open')
        })




    }   
});


$(function(){
    $('.home-hot-list').slick({
        rows:2,
        slidesPerRow:2,
        prevArrow:'.home-hot .carter_prev',
        nextArrow:'.home-hot .carter_next',
        responsive: [
            {
              breakpoint: 768,
              settings: {
                rows:2,
                slidesPerRow:1,
              }
            }
        ]
    })

    $(".zoom").zoom();



    $('.prodeta-blist').slick({
        asNavFor:'.prodeta-slist',
        prevArrow:'.prodeta-bslick .prevs',
        nextArrow:'.prodeta-bslick .nexts',
    })

    $('.prodeta-slist').slick({
        asNavFor:'.prodeta-blist',
        slidesToShow:4,
        focusOnSelect: true,
        responsive: [
            {
              breakpoint: 991,
              settings: {
                slidesToShow: 3
              }
            }
        ]

    })

    pauseIframe('.prodeta-blist')

    $('.product-other-list').slick({
        slidesToShow:4,
        prevArrow:'.product-other .carter_prev',
        nextArrow:'.product-other .carter_next',
        responsive: [
            {
              breakpoint: 1200,
              settings: {
                slidesToShow: 3
              }
            },
            {
              breakpoint: 991,
              settings: {
                slidesToShow: 2
              }
            },
            {
                breakpoint: 768,
                settings: {
                  slidesToShow: 1,
                  dots:true
                }
            }
        ]
    })
})

// 搜索框
function searchToggle(){
    $('.mod_header_right_search,.mod_header_pc_search').click(function(e){
        e.stopPropagation()
        $('.mod_header_search').toggleClass('active')
    })
    
    $('.mod_header_search_box').click(function(e){
        e.stopPropagation()
    })
    
    $('.mod_header_right_item').hover(function(){
        $('.mod_header_search').removeClass('active')
    })
    
    $('body').click(function(){
        $('.mod_header_search').removeClass('active')
    })    
}

// 首页banner
$(function(){
    // 第一屏
    var interleaveOffset = 0.5; //视差比值
    var swiperOptions = {
        loop: true,
        speed: 1400,
        // grabCursor: true, 抓手图标
        watchSlidesProgress: true,
        mousewheelControl: true,
        keyboardControl: true,
        pagination: {
            el: '.home-control .pages',
            type: 'fraction',
            renderFraction: function (currentClass, totalClass) {
                return '<span class="' + currentClass + '"></span>' +
                       ' <span>/</span>' +
                       '<span class="' + totalClass + '"></span>';
            },
            formatFractionCurrent: function (number) {
                return "0"+number; 
            },
            formatFractionTotal: function (number) {
                return "0"+number; 
            },
        },
        navigation: {
            nextEl: '.home-control-next',
            prevEl: '.home-control-prev',
        },
        lazy: {
            loadPrevNext: true,
        },
        on: {
            progress: function (swiper) {
                for (var i = 0; i < swiper.slides.length; i++) {
                    var slideProgress = swiper.slides[i].progress;
                    var innerOffset = swiper.width * interleaveOffset;
                    var innerTranslate = slideProgress * innerOffset;
                    swiper.slides[i].querySelector(".slide-inner").style.transform =
                        "translate3d(" + innerTranslate + "px, 0, 0)";
                }
            },
            touchStart: function (swiper) {
                for (var i = 0; i < swiper.slides.length; i++) {
                    swiper.slides[i].style.transition = "";
                }
            },
            setTransition: function (swiper, speed) {
                for (var i = 0; i < swiper.slides.length; i++) {
                    swiper.slides[i].style.transition = speed + "ms";
                    swiper.slides[i].querySelector(".slide-inner").style.transition =
                        speed + "ms";
                }
            },
            init(swiper){
                // 检测第一屏是否有视频
                if($('.home_banner .swiper-slide-active').find('video').length){
                    $('.home_banner .swiper-slide-active').find('video')[0].play()
                }else{
                    swiper.autoplay.start();
                }
            }
        }
    };
    if(window.Swiper){
        // // 视频播放完切换下一项
        $('.home_banner .swiper-slide').find('video').each(function(){
            this.addEventListener("ended",function(){
                swiper.slideNext();
            },false);
        })

        var swiper = new Swiper(".home_banner .swiper-container", swiperOptions);

        // // 检测下一项是否有视频
        swiper.on('slideChangeTransitionEnd', function(swiper,event) {
            // 暂停所有视频
            $('.home_banner .swiper-slide').find('video').each(function(){
                this.currentTime=0
                this.pause()
            })

            if($('.home_banner .swiper-slide-active').find('video').length){
                swiper.autoplay.stop();
                $('.home_banner .swiper-slide-active').find('video')[0].play()
                $('.home_banner .swiper-slide-active').find('video')[0].addEventListener("ended",function(){
                    swiper.slideNext();
                },false);

            }else{
                swiper.autoplay.start();
            }
        })
    }
})


// 表格
$(function () {
    var oTable = $("table");
    if (oTable.length !== 0) {
        var oTr = oTable.find("tr"),
        oTd = oTable.find("td");
        oTable.wrap("<div class='table-box'></div>");
        oTr.attr("style", "");
        oTd.each(function (index) {
        if (typeof $(this).attr("style") !== "undefined") {
            if ($(this).attr("style").indexOf("text-align: center") >= 0) {
            $(this).attr("style", "text-align: center");
            } else {
            $(this).attr("style", "");
            }
        }
        });
    }
});

$(function(){
    var nubVal = parseInt($('.shop_number_val').val()) 

    // $('.shop_number_minus').click(function(){
    //     if(nubVal > 0){
    //         nubVal--
    //     }
    //     $(this).parent().find('.shop_number_val').val(nubVal)
    // })

    // $('.shop_number_add').click(function(){
    //     nubVal++
    //     $(this).parent().find('.shop_number_val').val(nubVal)
    // })

    $('.shop_cheackitem').change(function(e){
        var sumlen = $('input[name="checkItem"]').length
        var actlen = $('input[name="checkItem"]:checked').length

        if(sumlen == actlen){
            $('.shop_cheackall input').prop('checked', true)
        }else{
            $('.shop_cheackall input').prop('checked', false)
        }
    })

    $('.shop_cheackall').change(function(e){
        $('input[name="checkItem"]').prop('checked', e.target.checked)
    })
})

$(function(){
            
    ctAside({
        type:"animateitem-rotate", // animateitem/animatelist/animateitem-rotate
        baseTime:0.1, // number
        trigger:"click" // click/hover
    })

    function ctAside(obj){
        if($(window).width()<768){
            $('.ct_aside1_list').show()
            if(!obj){
                obj = {
                    type:"animatelist", // animateitem/animatelist
                    baseTime:0.1, // number
                    trigger:"click" // click/hover
                }
            }
            $('.ct_aside1_list').addClass(obj.type).show()

            $('.ct_aside1_switch').click(function(){
                $('.ct_aside1_list').toggleClass("active")
                $(this).toggleClass("active")
            })

            $('.ct_aside1_item').each((index,item)=>{
                var length = $('.ct_aside1_item').length
                $(item).css('transition-delay',(length - index)*obj.baseTime + "s")
            })

            $('.ct_aside1_item').click(function(e){
                e.stopPropagation()
                $(this).addClass('active').siblings().removeClass('active')
            })

            $('body').click(function(){
                $('.ct_aside1_item').removeClass('active')
            })
        }
        
    }
})



$(".cart-btn").click(function(){
    var id = $(this).data('id');
    $.cart.add(id);
});


$(".icon-delete").click(function(){
    var id = $(this).data('id');
    $.cart.del(id);
});

$(function() {
    var iptNum = 0;
    $(".add1").on("click", function() {
        iptNum = parseInt($(this).siblings(".ipt-num").val());
        $(this).siblings(".ipt-num").val(iptNum + 1).trigger('input');
    })
    $(".del1").on("click", function() {
        iptNum = parseInt($(this).siblings(".ipt-num").val());
        iptNum--;
        if(iptNum < 1) {
            iptNum = 1;
        }
        $(this).siblings(".ipt-num").val(iptNum).trigger('input');
    })
});
