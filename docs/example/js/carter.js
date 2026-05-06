
// 回到顶部
function goTop() {
    $('body,html').animate({
        scrollTop: 0
    }, 400)
}

/**
 * @description iframe视频暂停
 * @param {class} domeclass - css选择器
 */
function pauseIframe(domeclass){
    // 暂停视频
    let sliderFor = $(domeclass) //将带有iframe的轮播 赋给sliderFor
    var items_for = sliderFor.find(".slick-slide:not('.slick-cloned')"),
        video_item = [];

    items_for.each(function (index, el) {
        var tath = $(this);
        if (tath.find('iframe').length) {
            video_item.push(index);
        }
    });

    var video_on = false, 
        video_on_index = null; 

    function changeVideo(nextSlide) {
        if (video_item.indexOf(nextSlide) >= 0) {
            var El_video = items_for.eq(nextSlide);

            var iframe = El_video.find('.iframe'),
                src = iframe.attr('data-src');

            iframe.attr('src', src);

            video_on = true;
            video_on_index = nextSlide;
        } else {
            if (video_on) {
                items_for.eq(video_on_index).find('.iframe').removeAttr('src');
                video_on = false;
            }
        }
    }
    changeVideo(0);
    sliderFor.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
        changeVideo(nextSlide);
    });
}

/**
 * @description 阻止事件冒泡
 * @param {Array} domearr - css选择器数组 ['.class',·····] 
 * @param {String} type - 事件类型 默认:click
 */
function stopIncident(domearr,type='click'){
        
    if(!(domearr instanceof Array)){
        console.error('function stopIncident 参数类型不是Array');
        return
    }

    domearr.forEach(function(item,index){
        $(item)[type](function(e){
            e.preventDefault()
            e.stopPropagation()
        })
    })
}

/**
 * @description slick激活自定义进度条
 * @param {String} domeclass - slick容器 css选择器
 * @param {String} pgclass - 进度条 css选择器
 */
function progress_slick(slickclass,pgclass){
    $(slickclass).slick({
        slidesToShow:3,
        infinite:false
    })

    let slideCount = $(slickclass)[0].slick.slideCount
    let slideShow = $(slickclass)[0].slick.options.slidesToShow
    let progress = 0

    init()

    $(slickclass).on('beforeChange', function(event, slick, currentSlide, nextSlide){
        progress = (nextSlide + 1 ) / ( slideCount + 1 - slideShow)
        setprogress(progress)
    });

    function init(){
        progress = 1 / ( slideCount + 1 - slideShow)
        setprogress(progress)
    }

    function setprogress(progress){
        $(pgclass).css('width',progress * 100 + "%")
    }
}

/**
 * @description 表单 获取焦点 lable变化
 * @param {String} domeclass - 输入框容器
 */
function formLabel(textinput){
    $(textinput).focus(function(){
        $(this).parent().addClass('active')
    })

    $(textinput).blur(function(){
        if($(this)[0].value.length == 0){
            $(this).parent().removeClass('active')
        }
    })

    $(textinput).each(function(index,value){
        // if($(value)[0].value.length == 0){
        //     $(this).parent('.conts').removeClass('active')
        // }else{
        //     $(this).parent('.conts').addClass('active')
        // }

        if($(value)[0].value.length == 0){
            $(this).parent().removeClass('active')
        }else{
            $(this).parent().addClass('active')
        }
    })
}


/**
 * @description inquire info
 * @param {Class} btnClick -inquire按钮
 * @param {Class} form - 表单
 * @param {Number} setTop - 顶部预留值
 */
function inquireInfo(btnClick,form,setTop=85){
    $(btnClick).click(function(){
        let offsetTop = $(form).offset().top
        $('body,html').animate({
            scrollTop:offsetTop - $('.header').height() - setTop +"px"
        })
    })
}

// 谷歌翻译
function googleTranslateElementInit() {
    new google.translate.TranslateElement(
        {
            pageLanguage: 'en',
            includedLanguages: 'de,en,es,fr,ja,ru,zh-CN,ar,de,th,id,vi',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
        },
        'google_translate_element'
    );
}


/**
* @description: 页内锚点链接
* @param {className} entry 条目元素类名
* @param {className} anchor 锚点链接类名
* @param {Number} top 顶部预留距离，默认值100
* 
*/
function anchorScroll(entry,anchor,top = 100){

    var entry = $(entry)
    var anchor = $(anchor)

    let headerHeight = $('.header').length !== 0 ? $('.header').innerHeight() : 123

    let entryTop = [];
    
    function _init(){
        entry.each(function(index,item){
            entryTop[index] = $(item).offset().top
        })
    }

    anchor.click(function(){
        _init()
        let index = $(this).index()
        $('body,html').animate({
            scrollTop: entryTop[index] - headerHeight - top + "px"
        },500)
    })
}


class Carter {
    // options:Object
    constructor(options = {}, placeholder1) {
        this.options = options
        this.placeholder1 = placeholder1
    }

    getScrollTop() {
        var scrollTop = 0, bodyScrollTop = 0, documentScrollTop = 0;
        if (document.body) bodyScrollTop = document.body.scrollTop;
        if (document.documentElement) documentScrollTop = document.documentElement.scrollTop;
        scrollTop = (bodyScrollTop - documentScrollTop > 0) ? bodyScrollTop : documentScrollTop;
        return scrollTop;
    }

    headerActive(target, toggleClass = 'active', distance = 300) {

        // 获取dome节点
        target = document.querySelector(target)

        // 滚动掉到顶部距离
        let scrollTop = 0

        // 监听页面滚动
        window.addEventListener("scroll", () => {

            // 检测滚动方向
            // if(scrollTop < this.getScrollTop()){
            //     // 下
            //     if(scrollTop>distance){
            //         target.classList.add(toggleClass)
            //     }
            // }else{
            //     // 上
            //     target.classList.remove(toggleClass)
            // }   

            // 检测滚动距离
            if(scrollTop>distance){
                target.classList.add(toggleClass)
            }else{
                target.classList.remove(toggleClass)
            }

            // 更新位置
            scrollTop = this.getScrollTop()
        })
    }

    getUrlParame(){
        const obj = {}
        let arrs = []
        const url = window.location.search.replace("?","")
        arrs = url.split("&")
        arrs.forEach((item)=>{
            obj[item.split("=")[0]] = item.split("=")[1]
        })
        return obj
    }
}

const cb = new Carter()
