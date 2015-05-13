$(document).ready(function(){
    //pjax 开始
    $.pjax({
        selector: 'a[href^="'+pjaxHomeUrl+'"]',
        //selector: 'a',
        container: '#main',
        show: '',  //展现的动画，支持默认和fade, 可以自定义动画方式，这里为自定义的function即可。
        cache: false,  //是否使用缓存
        storage: false,  //是否使用本地存储
        titleSuffix: pjaxTitleSuffix,
        filter: function(href){
            if(href.indexOf('feed')> -1 || href.indexOf('manage')> -1 ||href.indexOf('wp-content/') > -1 || href.indexOf('wp-admin/') > -1|| href.indexOf('/lab/') > -1){
                return true;
            }
        },
        callback: function(){

            //多说
            //pajx_loadDuodsuo();

        }
    });

    //向上滚动
    function animate(line, next){
        var top = next.position().top;
        line.animate({
            top: top,
            height: next.height()
        });
        $('html,body').animate({
            scrollTop: top
        });
    };
    
    var endPjaxTimer = 0;
    $('#main').bind('pjax.start', function(cache){
        endPjaxTimer = setTimeout(function(){
            endPjaxTimer = 0;
            $('#main').trigger('pjax.end');
        }, 3000);

        loading_show();
    });
    
    var li = $('.nav_header li');
    $('#main').bind('pjax.end', function(cache){
        if(endPjaxTimer){
            clearTimeout(endPjaxTimer);
            endPjaxTimer = 0;
        }
        
        li.removeClass('current-menu-item');
        li.each(function(){
            var href = $(this).find('a').attr('href'), h;
            href = $.pjax.util.getRealUrl(href);
            h = $.pjax.util.getRealUrl(location.href);
            if(href == h || (href+'/') == h || href == (h+'/')){
                $(this).addClass('current-menu-item');
                return false;
            }
        });


        if(!location.hash){
            $("html, body").animate({ scrollTop: 0 }, 300);
        }

        //fancybox
        //$(".fancybox").fancybox();
        
        loading_hide();
       
    });

    //移除缓存
    function removeStorageCache(){
        //remove current href cache when a comment added.
        $('#commentform').submit(function(){
            var href = location.href.replace(/\/comment\-page.*?/, '');
            $.pjax.util.removeCache(href);
        })
    }
    removeStorageCache();
});


$(document).ready(function(){
	//fancybox
        //$(".fancybox").fancybox();
});


function loading_show(){
    if ( !$( '#loading-wrap .loading' )[0] ){
        $('#loading-wrap').append(_loading);
    }
    $( '#loading-wrap' ).css({'height':$(window).height()}).addClass('show');
    $( '#loading-wrap .loading' ).show().css({'margin-top':( $(window).height() - 120 ) / 2});
}
function loading_hide(){
    	$( '#loading-wrap' ).removeClass('show');
    //setTimeout(function(){//等待css animation动画缓冲完
        $( '#loading-wrap' ).css({'height':0});
        $( '#loading-wrap .loading' ).css({'margin-top':0}).hide();
    //},100);
}


//返回顶部
$(document).ready(function(){      
    $("#go-top").hide();
    //当滚动条的位置处于距顶部100像素以下时，跳转链接出现，否则消失
    $(function () {
        $(window).scroll(function(){
        if ($(window).scrollTop()>200){
            $("#go-top").fadeIn(500);
        }
        else
        {
            $("#go-top").fadeOut(500);
        }
        });
        //当点击跳转链接后，回到页面顶部位置
        $("#go-top").click(function(){
            $('body,html').animate({scrollTop:0},500);
            return false;
        });
    });
});

$(function(){
    $('.nav-content .submenu').click(function(e){
        e.preventDefault();
        
        if ($('.nav-explor').not($(this).next()).hasClass('nav-explor-block')) {
            $('.nav-explor').removeClass('nav-explor-block');
        }

        $(this).next().toggleClass('nav-explor-block');

    });
});


$(document).ready(function(){
    $('.logo h1 a,.logo h6 a').jrumble();
});

(function($) {
    $.fn.jrumble = function(s) {
        var t = {
            rangeX: 2,
            rangeY: 2,
            rangeRot: 1,
            rumbleSpeed: 10,
            rumbleEvent: 'hover',
            posX: 'left',
            posY: 'top'
        };
        var u = $.extend(t, s);
        return this.each(function() {
            $obj = $(this);
            var f;
            var g = u.rangeX;
            var h = u.rangeY;
            var i = u.rangeRot;
            g = g * 2;
            h = h * 2;
            i = i * 2;
            var j = u.rumbleSpeed;
            var k = $obj.css('position');
            var l = u.posX;
            var m = u.posY;
            var n;
            var o;
            var p;
            if (l === 'left') {
                n = parseInt($obj.css('left'), 10)
            }
            if (l === 'right') {
                n = parseInt($obj.css('right'), 10)
            }
            if (m === 'top') {
                o = parseInt($obj.css('top'), 10)
            }
            if (m === 'bottom') {
                o = parseInt($obj.css('bottom'), 10)
            }
            function rumbler(a) {
                var b = Math.random();
                var c = Math.floor(Math.random() * (g + 1)) - g / 2;
                var d = Math.floor(Math.random() * (h + 1)) - h / 2;
                var e = Math.floor(Math.random() * (i + 1)) - i / 2;
                if (a.css('display') === 'inline') {
                    p = true;
                    a.css('display', 'inline-block')
                }
                if (c === 0 && g !== 0) {
                    if (b < .5) {
                        c = 1
                    } else {
                        c = -1
                    }
                }
                if (d === 0 && h !== 0) {
                    if (b < .5) {
                        d = 1
                    } else {
                        d = -1
                    }
                }
                if (k === 'absolute') {
                    a.css({
                        'position': 'absolute',
                        '-webkit-transform': 'rotate(' + e + 'deg)',
                        '-moz-transform': 'rotate(' + e + 'deg)',
                        '-o-transform': 'rotate(' + e + 'deg)',
                        'transform': 'rotate(' + e + 'deg)'
                    });
                    a.css(l, n + c + 'px');
                    a.css(m, o + d + 'px')
                }
                if (k === 'fixed') {
                    a.css({
                        'position': 'fixed',
                        '-webkit-transform': 'rotate(' + e + 'deg)',
                        '-moz-transform': 'rotate(' + e + 'deg)',
                        '-o-transform': 'rotate(' + e + 'deg)',
                        'transform': 'rotate(' + e + 'deg)'
                    });
                    a.css(l, n + c + 'px');
                    a.css(m, o + d + 'px')
                }
                if (k === 'static' || k === 'relative') {
                    a.css({
                        'position': 'relative',
                        '-webkit-transform': 'rotate(' + e + 'deg)',
                        '-moz-transform': 'rotate(' + e + 'deg)',
                        '-o-transform': 'rotate(' + e + 'deg)',
                        'transform': 'rotate(' + e + 'deg)'
                    });
                    a.css(l, c + 'px');
                    a.css(m, d + 'px')
                }
            }
            var q = {
                'position': k,
                '-webkit-transform': 'rotate(0deg)',
                '-moz-transform': 'rotate(0deg)',
                '-o-transform': 'rotate(0deg)',
                'transform': 'rotate(0deg)'
            };
            if (u.rumbleEvent === 'hover') {
                $obj.hover(function() {
                    var a = $(this);
                    f = setInterval(function() {
                        rumbler(a)
                    },
                    j)
                },
                function() {
                    var a = $(this);
                    clearInterval(f);
                    a.css(q);
                    a.css(l, n + 'px');
                    a.css(m, o + 'px');
                    if (p === true) {
                        a.css('display', 'inline')
                    }
                })
            }
            if (u.rumbleEvent === 'click') {
                $obj.toggle(function() {
                    var a = $(this);
                    f = setInterval(function() {
                        rumbler(a)
                    },
                    j)
                },
                function() {
                    var a = $(this);
                    clearInterval(f);
                    a.css(q);
                    a.css(l, n + 'px');
                    a.css(m, o + 'px');
                    if (p === true) {
                        a.css('display', 'inline')
                    }
                })
            }
            if (u.rumbleEvent === 'mousedown') {
                $obj.bind({
                    mousedown: function() {
                        var a = $(this);
                        f = setInterval(function() {
                            rumbler(a)
                        },
                        j)
                    },
                    mouseup: function() {
                        var a = $(this);
                        clearInterval(f);
                        a.css(q);
                        a.css(l, n + 'px');
                        a.css(m, o + 'px');
                        if (p === true) {
                            a.css('display', 'inline')
                        }
                    },
                    mouseout: function() {
                        var a = $(this);
                        clearInterval(f);
                        a.css(q);
                        a.css(l, n + 'px');
                        a.css(m, o + 'px');
                        if (p === true) {
                            a.css('display', 'inline')
                        }
                    }
                })
            }
            if (u.rumbleEvent === 'constant') {
                var r = $(this);
                f = setInterval(function() {
                    rumbler(r)
                },
                j)
            }
        })
    }
})(jQuery);