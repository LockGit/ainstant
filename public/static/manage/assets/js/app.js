(function($) {
    'use strict';

    $(function() { 
        var $fullText = $('.admin-fullText');
        $('#admin-fullscreen').on('click', function() {
            $.AMUI.fullscreen.toggle();
        });

        $(document).on($.AMUI.fullscreen.raw.fullscreenchange, function() {
            $.AMUI.fullscreen.isFullscreen ? $fullText.text('关闭全屏') : $fullText.text('开启全屏');
        });
    });
  
})(jQuery);


$(function(){


    /* 类型 */

    typeListLoad(1);
    function typeListLoad(pages) {
        var typeListUrl = location.protocol+'//'+location.hostname +'/manage/types/typelist';
        $('#type-list').load(typeListUrl, {page : pages}, function(data) {
            
            typeListPage();
            typeItemUpdate();
            typeItemDelete();
        });
    }

    function typeListPage() {
        $('#type-index-page').on('click', function(e) {
            e.preventDefault();
            typeListLoad(1);
        });
        $('#type-prev-page').on('click', function(e) {
            e.preventDefault();
            typeListLoad($(this).attr('page'));
        });
        $('#type-next-page').on('click', function(e) {
            e.preventDefault();
            typeListLoad($(this).attr('page'));
        });
        $('#type-last-page').on('click', function(e) {
            e.preventDefault();
            typeListLoad($(this).attr('page'));
        });
    }

    function typeItemUpdate() {
        $('.type-update').on('click', function(e) {
            e.preventDefault();
            var typeId = $(this).attr('typeid');
            typeSubmitLoad(typeId);
        });
    }

    function typeItemDelete() {
        $('.type-delete').on('click', function(e) {
            e.preventDefault();
            var typeIdDelete = $(this).attr('typeid');
            swal({   
                title: "你确定?",   
                text: "删除这个类型!",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Yes, delete it!",   
                closeOnConfirm: false 
            }, function(){   

                    var typeDeleteUrl = location.protocol+'//'+location.hostname +'/manage/types/delete';
                    $.post(typeDeleteUrl, {typeId : typeIdDelete}, function(data) {
                        
                        if (data === 'errorDelete') {
                            swal("抱歉!", "删除失败!", "error");
                        } else if (data === 'successDelete') {
                            swal("OK!", "删除成功!", "success");
                            typeListLoad($('#type-current-page').attr('page'));
                            typeSubmitLoad();
                        } else if (data === 'noType') {
                            swal("抱歉!", "你要删除的类型可能不存在!", "error");
                        } else {
                            swal("NO!", "未知错误!", "error");
                        }
                    });
                });
        });
    }


    typeSubmitLoad();
    function typeSubmitLoad(typeIds) {
        var typeFormUrl = location.protocol+'//'+location.hostname +'/manage/types/typeform';
        $('#type-form').load(typeFormUrl, {typeId : typeIds}, function() {
            typeSubmitForm();
        });
    }


    //类型添加表单提交
    function typeSubmitForm() {
        $('#add-type-submitform').click(function(e){
            e.preventDefault();
            var submitUrl = location.protocol+'//'+location.hostname +'/manage/types/add';
            $.post(submitUrl, $("#add-type-form").serialize(), function(data) {
                                   
                    if (data === 'noTypeTitle') {
                        swal("NO!", "没有输入类型!", "error");
                    } else if (data === 'errorHaveType') {
                        swal("NO!", "类型已经存在!", "error");
                    } else if (data === 'errorAdd') {
                        swal("NO!", "添加失败!", "error");
                    } else if (data === 'successAdd') {
                        swal({title: "OK!", text: "添加成功!", timer: 5000, showConfirmButton: true ,type: "success"});
                        typeListLoad(1);
                        typeSubmitLoad();
                    } else if (data === 'errorUpdate') {
                        swal("NO!", "更新失败!", "error");
                    } else if (data === 'successUpdate') {
                        swal({title: "OK!", text: "更新成功!", timer: 5000, showConfirmButton: true ,type: "success"});
                        typeListLoad($('#type-current-page').attr('page'));
                    } else {
                        swal("NO!", "未知错误!", "error");
                    }
                
            });
        });
    }
    /* 类型 end */


    /* 分类 */

    catListLoad(1);
    function catListLoad(pages) {
        var catListUrl = location.protocol+'//'+location.hostname +'/manage/cats/catlist';
        $('#cat-list').load(catListUrl, {page : pages}, function(data) {
            
            catListPage();
            catItemUpdate();
            catItemDelete();
        });
    }

    function catListPage() {
        $('#cat-index-page').on('click', function(e) {
            e.preventDefault();
            catListLoad(1);
        });
        $('#cat-prev-page').on('click', function(e) {
            e.preventDefault();
            catListLoad($(this).attr('page'));
        });
        $('#cat-next-page').on('click', function(e) {
            e.preventDefault();
            catListLoad($(this).attr('page'));
        });
        $('#cat-last-page').on('click', function(e) {
            e.preventDefault();
            catListLoad($(this).attr('page'));
        });
    }

    function catItemUpdate() {
        $('.cat-update').on('click', function(e) {
            e.preventDefault();
            var catId = $(this).attr('catid');
            catSubmitLoad(catId);
        });
    }

    function catItemDelete() {
        $('.cat-delete').on('click', function(e) {
            e.preventDefault();
            var catIdDelete = $(this).attr('catid');
            swal({   
                title: "你确定?",   
                text: "删除这个分类!",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Yes, delete it!",   
                closeOnConfirm: false 
            }, function(){   
                    
                    var catDeleteUrl = location.protocol+'//'+location.hostname +'/manage/cats/delete';
                    $.post(catDeleteUrl, {catId : catIdDelete}, function(data) {
                        
                        if (data === 'errorDelete') {
                            swal("抱歉!", "删除失败!", "error");
                        } else if (data === 'successDelete') {
                            swal("OK!", "删除成功!", "success");
                            catListLoad($('#cat-current-page').attr('page'));
                            catSubmitLoad();
                        } else if (data === 'noCat') {
                            swal("抱歉!", "你要删除的分类可能不存在!", "error");
                        } else {
                            swal("NO!", "未知错误!", "error");
                        }
                    });
                });
        });
    }


    catSubmitLoad();
    function catSubmitLoad(catIds) {
        var catFormUrl = location.protocol+'//'+location.hostname +'/manage/cats/catform';
        $('#cat-form').load(catFormUrl, {catId : catIds}, function() {
            catSubmitForm();
        });
    }


    //标签添加表单提交
    function catSubmitForm() {
        $('#add-cat-submitform').click(function(e){
            e.preventDefault();
            var submitUrl = location.protocol+'//'+location.hostname +'/manage/cats/add';
            $.post(submitUrl, $("#add-cat-form").serialize(), function(data) {
                                   
                    if (data === 'noCatTitle') {
                        swal("NO!", "没有输入分类!", "error");
                    } else if (data === 'errorHaveCat') {
                        swal("NO!", "分类已经存在!", "error");
                    } else if (data === 'errorAdd') {
                        swal("NO!", "添加失败!", "error");
                    } else if (data === 'successAdd') {
                        swal({title: "OK!", text: "添加成功!", timer: 5000, showConfirmButton: true ,type: "success"});
                        catListLoad(1);
                        catSubmitLoad();
                    } else if (data === 'errorUpdate') {
                        swal("NO!", "更新失败!", "error");
                    } else if (data === 'successUpdate') {
                        swal({title: "OK!", text: "更新成功!", timer: 5000, showConfirmButton: true ,type: "success"});
                        catListLoad($('#cat-current-page').attr('page'));
                    } else {
                        swal("NO!", "未知错误!", "error");
                    }
                
            });
        });
    }
    /* 分类 end */

    /* 标签 */

    tagListLoad(1);
    function tagListLoad(pages) {
        var tagListUrl = location.protocol+'//'+location.hostname +'/manage/tags/taglist';
        $('#tag-list').load(tagListUrl, {page : pages}, function(data) {
            
            tagListPage();
            tagItemUpdate();
            tagItemDelete();
        });
    }

    function tagListPage() {
        $('#tag-index-page').on('click', function(e) {
            e.preventDefault();
            tagListLoad(1);
        });
        $('#tag-prev-page').on('click', function(e) {
            e.preventDefault();
            tagListLoad($(this).attr('page'));
        });
        $('#tag-next-page').on('click', function(e) {
            e.preventDefault();
            tagListLoad($(this).attr('page'));
        });
        $('#tag-last-page').on('click', function(e) {
            e.preventDefault();
            tagListLoad($(this).attr('page'));
        });
    }

    function tagItemUpdate() {
        $('.tag-update').on('click', function(e) {
            e.preventDefault();
            var tagId = $(this).attr('tagid');
            tagSubmitLoad(tagId);
        });
    }

    function tagItemDelete() {
        $('.tag-delete').on('click', function(e) {
            e.preventDefault();
            var tagIdDelete = $(this).attr('tagid');
            swal({   
                title: "你确定?",   
                text: "删除这个标签!",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Yes, delete it!",   
                closeOnConfirm: false 
            }, function(){   
                    
                    var tagDeleteUrl = location.protocol+'//'+location.hostname +'/manage/tags/delete';
                    $.post(tagDeleteUrl, {tagId : tagIdDelete}, function(data) {
                        
                        if (data === 'errorDelete') {
                            swal("抱歉!", "删除失败!", "error");
                        } else if (data === 'successDelete') {
                            swal("OK!", "删除成功!", "success");
                            tagListLoad($('#tag-current-page').attr('page'));
                            tagSubmitLoad();
                        } else if (data === 'noTag') {
                            swal("抱歉!", "你要删除的标签可能不存在!", "error");
                        } else {
                            swal("NO!", "未知错误!", "error");
                        }
                    });
                });
        });
    }


    tagSubmitLoad();
    function tagSubmitLoad(tagids) {
        var tagFormUrl = location.protocol+'//'+location.hostname +'/manage/tags/tagform';
        $('#tag-form').load(tagFormUrl, {tagId : tagids}, function() {
            tagSubmitForm();
        });
    }


    //标签添加表单提交
    function tagSubmitForm() {
        $('#add-tag-submitform').click(function(e){
            e.preventDefault();
            var submitUrl = location.protocol+'//'+location.hostname +'/manage/tags/add';
            $.post(submitUrl, $("#add-tag-form").serialize(), function(data) {
                                   
                    if (data === 'noTagTitle') {
                        swal("NO!", "没有输入标签!", "error");
                    } else if (data === 'errorHaveTag') {
                        swal("NO!", "标签已经存在!", "error");
                    } else if (data === 'errorAdd') {
                        swal("NO!", "添加失败!", "error");
                    } else if (data === 'successAdd') {
                        swal({title: "OK!", text: "添加成功!", timer: 5000, showConfirmButton: true ,type: "success"});
                        tagListLoad(1);
                        tagSubmitLoad();
                    } else if (data === 'errorUpdate') {
                        swal("NO!", "更新失败!", "error");
                    } else if (data === 'successUpdate') {
                        swal({title: "OK!", text: "更新成功!", timer: 5000, showConfirmButton: true ,type: "success"});
                        tagListLoad($('#tag-current-page').attr('page'));
                    } else {
                        swal("NO!", "未知错误!", "error");
                    }
                
            });
        });
    }
    /* 标签 end */
    

    //文章添加表单提交
    $('#create-post-submitform').click(function(e){
        e.preventDefault();
        var submitUrl = location.protocol+'//'+location.hostname +'/manage/posts/add';
        $.post(submitUrl, $("#post-form").serialize(), function(data) {
            //alert(data);
            if (data === 'noPostTitle') {
                swal("NO!", "没有输入标题!", "error");
            } else if (data === 'noPostContent') {
                swal("NO!", "没有输入正文内容!", "error");
            } else if (data === 'noPostType') {
                swal("NO!", "必须选择一个类型!", "error");
            } else if (data === 'noPostCat') {
                swal("NO!", "必须选择一个分类!", "error");
            } else if (data === 'noPostTag') {
                swal("NO!", "必须输入一个标签!", "error");
            } else if (data === 'errorPublish') {
                swal("NO!", "发布失败!", "error");
            } else if (/^[0-9]*$/g.test(data)) {
                $('#post-id').val(data);
                var postUrl = location.protocol+'//'+location.hostname +'/'+ data +'.html';
                var button = '<a href="'+ postUrl + '" class="am-btn am-btn-warning am-margin-bottom am-btn-sm" id="post-add-image" target="_black"><i class="am-icon-eye"></i>  查看文章</a>';
                $('#my-post-buttom').append(button);
                swal({   
                    title: "OK",   
                    text: "发布成功!",   
                    type: "success",   
                    showCancelButton: true,   
                    confirmButtonColor: "#5eb95e",   
                    cancelButtonText: "取消!",
                    confirmButtonText: "继续添加?",   
                    closeOnConfirm: false 
                }, function(){   
                    var newPostUrl = location.protocol+'//'+location.hostname +'/manage/posts/create';
                    window.location.href = newPostUrl;
                });
            } else if (data === 'errorUpdata') {
                swal("NO!", "更新失败!", "error");
            } else if (data === 'successUpdate') {
                swal("OK!", "更新成功!", "success");
            }

        });
    });

});

/*
*   编辑器-添加文章-添加图片
*/
$(function(){
    var toolbar,editor;
    toolbar = [
              'title',          // 标题文字
              'bold',           // 加粗文字
              'italic',         // 斜体文字
              'underline',      // 下划线文字
              'strikethrough',  // 删除线文字
              'color',          // 修改文字颜色
              '|',
              'ol',             // 有序列表
              'ul',             // 无序列表
              'blockquote',     // 引用
              'code',           // 代码
              'table',          // 表格
              '|',
              'link',           // 插入链接
              'image',          // 插入图片
              'hr',             // 分割线
              '|',
              'indent',         // 向右缩进
              'outdent',        // 向左缩进
              'source'          // 显示源代码
                ];

    if ($('#post-editor').length>0) {
        editor = new Simditor({
            textarea: $('#post-editor'),
            toolbar: toolbar,
            defaultImage: '/backend/simditor/images/image.png',
            autosave: 'editor-content',
            upload:  {
                url: '../medialibrary/upload', //上传途径
                fileKey: 'upload_file', //服务器端获取文件数据的参数名
                connectionCount: 10, //同时上传文件的最大数量
                leaveConfirm: '正在上传文件，如果离开上传会自动取消'
            }, 
            pasteImage: true
        });
        
    }

    //  文章列表 start
    $('.post-list-next a').on('click',function(e) {
        e.preventDefault();
        $(this).html('<i class="am-icon-spinner am-icon-spin"></i>  加载中……');
        //  ajax
        $.ajax({
            type: "GET",
            url: $(this).attr('href'),
            dataType: "html",
            success: function(out) {
                result = $(out).find('#post-list-box');
                nextlink = $(out).find('.post-list-next a').attr('href');
                        $("#post-list-content").append(result.fadeIn(500));
                        $('.post-list-next a').html('查看更多...');
                
                current = $(out).find('.post-list-next a').attr('current');
                last = $(out).find('.post-list-next a').attr('last');

                if (current === last) {
                    $('.post-list-next a').remove();
                    $('.post-list-next').append('<button type="button" class="am-btn am-btn-danger am-btn-block am-disabled">没有更多了！</button>');
                } else {
                    $('.post-list-next a').attr('href', nextlink);
                }
                
            }
        });
        
    });

    //  文章列表 End

    //	文章插入图片 start

    postAddPicture();
    
    function postAddPicture() {

        var addImageMainWidth = $(window).width() - 50,
        	addImageMainHeight = $(window).height() - 50,
         	addImageMainTop = 25,
         	addImageMainLeft = 25; 

     //    $(window).resize(function() {
     //  		addImageMainWidth = $(window).width() - 50;
     //    	addImageMainHeight = $(window).height() - 50;
     //    	addImageMainTop = 25;
     //    	addImageMainLeft = 25;
     //        $('.post-add-image-main').css({'width':addImageMainWidth,'height':addImageMainHeight,'top':addImageMainTop,'left':addImageMainLeft,'display':'block'});

    	// });
        
        //  正文图片
        $('#post-add-image').click(function(e){
            e.preventDefault();
            addImageMainOpen();

            $('#post-add-image-main').load('/manage/medialibrary/postaddpicture', function() {
                
                if ($(window).width() < 620) {
                    $('#post-picture-list-ul').css({'height':$(window).height() - 140});
                } else {
                    $('#post-picture-list-ul').css({'height':$(window).height() - 150});
                }
                
                $('#post-picture-close').click(function(e){
                    e.preventDefault();
                    addImageMainClose();
                });

                $('#post-picture-append').click(function(e){
                    e.preventDefault();
                    
                    $('#post-picture-list-ul li a').each(function(){
                        var picture_url = $(this).find('.add-thumbnail-border').attr('picture-url');
                        var picture_width = $(this).find('.add-thumbnail-border').attr('picture-width');
                        var picture_height = $(this).find('.add-thumbnail-border').attr('picture-height');
                        if (typeof(picture_url) !== "undefined") { 
                            var append_result = '<p><img src="'+picture_url+'" width="'+picture_width+'" height="'+picture_height+'" /></p>';
                            $('.simditor-body').append(append_result);
                            //console.log(append_result);
                        }                   

                    });

                    addImageMainClose();
                });

                addImageSelete();

                $('.post-picture-next a').on('click',function(e) {
                    e.preventDefault();

                    addImageSelete();

                    $(this).html('<i class="am-icon-spinner am-icon-spin"></i>  加载中……');
                    //  ajax
                    $.ajax({
                        type: "GET",
                        url: $(this).attr('href'),
                        dataType: "html",
                        success: function(out) {
                            result = $(out).find('#post-picture-list-ul li');
                            nextlink = $(out).find('.post-picture-next a').attr('href');
                                    $("#post-picture-list-ul").append(result.fadeIn(500));
                                    $('.post-picture-next a').html('查看更多...');
                            
                            current = $(out).find('.post-picture-next a').attr('current');
                            last = $(out).find('.post-picture-next a').attr('last');

                            if (current === last) {
                                $('.post-picture-next a').remove();
                                $('.post-picture-next').append('<button type="button" class="am-btn am-btn-danger am-btn-block am-disabled am-btn-sm">没有更多了！</button>');
                            } else {
                                $('.post-picture-next a').attr('href', nextlink);
                            }

                            addImageSelete();
                            
                        }
                    });
                    
                });

                
            });
        });

        //  缩略图
        $('#post-add-thumbnail').click(function(e){
            e.preventDefault();
            addImageMain2Open();

            $('#post-add-thumbnail-main').load('/manage/medialibrary/postaddthumbnail', function() {
                
                if ($(window).width() < 620) {
                    $('#post-thumbnail-list-ul').css({'height':$(window).height() - 145});
                } else {
                    $('#post-thumbnail-list-ul').css({'height':$(window).height() - 150});
                }
                
                $('#post-thumbnail-close').click(function(e){
                    e.preventDefault();
                    addImageMain2Close();
                });

                $('#post-thumbnail-append').click(function(e){
                    e.preventDefault();
                    
                    $('#post-thumbnail-list-ul li a').each(function(){
                        var picture_thumbnail = $(this).find('.add-thumbnail-border');
                        var picture_id = $(this).find('.add-thumbnail-border').attr('picture-id');

                        if (typeof(picture_id) !== "undefined") { 
                            
                            $('#post-thumbnail-box').html(picture_thumbnail);
                            $('#post-thumbnail-box img').removeClass('add-thumbnail-border')
                            $('#post-picture').val(picture_id);
                            //console.log(picture_thumbnail[0]);
                            //console.log(picture_id);
                        }                   

                    });

                    addImageMain2Close();
                });

                addImageRadio();

                $('.post-thumbnail-next a').on('click',function(e) {
                    e.preventDefault();

                    addImageRadio();

                    $(this).html('<i class="am-icon-spinner am-icon-spin"></i>  加载中……');
                    //  ajax
                    $.ajax({
                        type: "GET",
                        url: $(this).attr('href'),
                        dataType: "html",
                        success: function(out) {
                            result = $(out).find('#post-thumbnail-list-ul li');
                            nextlink = $(out).find('.post-thumbnail-next a').attr('href');
                                    $("#post-thumbnail-list-ul").append(result.fadeIn(500));
                                    $('.post-thumbnail-next a').html('查看更多...');
                            
                            current = $(out).find('.post-thumbnail-next a').attr('current');
                            last = $(out).find('.post-thumbnail-next a').attr('last');

                            if (current === last) {
                                $('.post-thumbnail-next a').remove();
                                $('.post-thumbnail-next').append('<button type="button" class="am-btn am-btn-danger am-btn-block am-disabled am-btn-sm">没有更多了！</button>');
                            } else {
                                $('.post-thumbnail-next a').attr('href', nextlink);
                            }

                            addImageRadio();
                            
                        }
                    });
                    
                });

                
            });
        });


        $('.post-add-image-shade').click(function(){
        	addImageMainClose();
        });


        function addImageMainOpen() {
            $('.post-add-image-shade').css({'height':$(window).height(),'display':'block'}).addClass('post-add-image-show');
            $('.post-add-image-main').css({'width':addImageMainWidth,'height':addImageMainHeight,'top':addImageMainTop,'left':addImageMainLeft,'display':'block'}).addClass('post-add-image-show');
        }

        function addImageMain2Open() {
            $('.post-add-image-shade2').css({'height':$(window).height(),'display':'block'}).addClass('post-add-image-show2');
            $('.post-add-image-main2').css({'width':addImageMainWidth,'height':addImageMainHeight,'top':addImageMainTop,'left':addImageMainLeft,'display':'block'}).addClass('post-add-image-show2');
        }

        function addImageMainClose() {
            $('.post-add-image-shade').css({'height':0,'display':'none'}).removeClass('post-add-image-show');
            $('.post-add-image-main').css({'height':0,'display':'none'}).removeClass('post-add-image-show');
        }

        function addImageMain2Close() {
            $('.post-add-image-shade2').css({'height':0,'display':'none'}).removeClass('post-add-image-show2');
            $('.post-add-image-main2').css({'height':0,'display':'none'}).removeClass('post-add-image-show2');
        }

        function addImageSelete() {
            $('.am-img-thumbnail').bind('click',function() {
                $(this).toggleClass('add-thumbnail-border');
            });
            //$('#post-picture-list-ul li a img').click(function(){
            //    $(this).toggleClass('add-thumbnail-border');
            //});
        }

        function addImageRadio() {
            $('.am-img-thumbnail').on('click',function() {
                if ($('.am-img-thumbnail').hasClass('add-thumbnail-border')) {
                    $('.am-img-thumbnail').removeClass('add-thumbnail-border');
                }
                $(this).toggleClass('add-thumbnail-border');
            });
        }


    }

    //  文章插入图片 end


    //  媒体库列表 ajax 加载内容
    $('.media-picture-next a').on('click',function(e) {
        e.preventDefault();
        $(this).html('<i class="am-icon-spinner am-icon-spin"></i>  加载中……');
        //  ajax
        $.ajax({
            type: "GET",
            url: $(this).attr('href'),
            dataType: "html",
            success: function(out) {
                result = $(out).find('#media-picture-list-ul li');
                nextlink = $(out).find('.media-picture-next a').attr('href');
                        $("#media-picture-list-ul").append(result.fadeIn(500));
                        $('.media-picture-next a').html('查看更多...');
                
                current = $(out).find('.media-picture-next a').attr('current');
                last = $(out).find('.media-picture-next a').attr('last');

                if (current === last) {
                    $('.media-picture-next a').remove();
                    $('.media-picture-next').append('<button type="button" class="am-btn am-btn-danger am-btn-block am-disabled">没有更多了！</button>');
                } else {
                    $('.media-picture-next a').attr('href', nextlink);
                }
                
            }
        });
        
    });
    
  
});


//  tagsinput

(function ($) {
    "use strict";

    var defaultOptions = {
        tagClass: function(item) {
            return 'label label-info';
        },
        itemValue: function(item) {
            return item ? item.toString() : item;
        },
        itemText: function(item) {
            return this.itemValue(item);
    },
        freeInput: true,
        addOnBlur: true,
        maxTags: undefined,
        maxChars: undefined,
        confirmKeys: [13, 44],
        onTagExists: function(item, $tag) {
            $tag.hide().fadeIn();
        },
        trimValue: false,
        allowDuplicates: false
    };

    /**
    * Constructor function
    */
    function TagsInput(element, options) {
        this.itemsArray = [];

        this.$element = $(element);
        this.$element.hide();

        this.isSelect = (element.tagName === 'SELECT');
        this.multiple = (this.isSelect && element.hasAttribute('multiple'));
        this.objectItems = options && options.itemValue;
        this.placeholderText = element.hasAttribute('placeholder') ? this.$element.attr('placeholder') : '';
        this.inputSize = Math.max(1, this.placeholderText.length);

        this.$container = $('<div class="bootstrap-tagsinput"></div>');
        this.$input = $('<input type="text" placeholder="' + this.placeholderText + '"/>').appendTo(this.$container);

        this.$element.after(this.$container);

        var inputWidth = (this.inputSize < 3 ? 3 : this.inputSize) + "em";
        this.$input.get(0).style.cssText = "width: " + inputWidth + " !important;";
        this.build(options);
    }

    TagsInput.prototype = {
        constructor: TagsInput,

        /**
         * Adds the given item as a new tag. Pass true to dontPushVal to prevent
         * updating the elements val()
         */
        add: function(item, dontPushVal) {
            var self = this;

            if (self.options.maxTags && self.itemsArray.length >= self.options.maxTags)
                return;

            // Ignore falsey values, except false
            if (item !== false && !item)
                return;

            // Trim value
            if (typeof item === "string" && self.options.trimValue) {
                item = $.trim(item);
            }

            // Throw an error when trying to add an object while the itemValue option was not set
            if (typeof item === "object" && !self.objectItems)
                throw("Can't add objects when itemValue option is not set");

            // Ignore strings only containg whitespace
            if (item.toString().match(/^\s*$/))
                return;

            // If SELECT but not multiple, remove current tag
            if (self.isSelect && !self.multiple && self.itemsArray.length > 0)
                self.remove(self.itemsArray[0]);

            if (typeof item === "string" && this.$element[0].tagName === 'INPUT') {
                var items = item.split(',');
                if (items.length > 1) {
                    for (var i = 0; i < items.length; i++) {
                        this.add(items[i], true);
                    }

                    if (!dontPushVal)
                        self.pushVal();
                    return;
                }
            }

            var itemValue = self.options.itemValue(item),
                itemText = self.options.itemText(item),
                tagClass = self.options.tagClass(item);

            // Ignore items allready added
            var existing = $.grep(self.itemsArray, function(item) { return self.options.itemValue(item) === itemValue; } )[0];
            if (existing && !self.options.allowDuplicates) {
                // Invoke onTagExists
                if (self.options.onTagExists) {
                    var $existingTag = $(".tag", self.$container).filter(function() { return $(this).data("item") === existing; });
                    self.options.onTagExists(item, $existingTag);
                }
                return;
            }

            // if length greater than limit
            if (self.items().toString().length + item.length + 1 > self.options.maxInputLength)
                return;

            // raise beforeItemAdd arg
            var beforeItemAddEvent = $.Event('beforeItemAdd', { item: item, cancel: false });
            self.$element.trigger(beforeItemAddEvent);
            if (beforeItemAddEvent.cancel)
                return;

            // register item in internal array and map
            self.itemsArray.push(item);

            // add a tag element
            var $tag = $('<span class="tag ' + htmlEncode(tagClass) + '">' + htmlEncode(itemText) + '<span data-role="remove"></span></span>');
            $tag.data('item', item);
            self.findInputWrapper().before($tag);
            $tag.after(' ');

            // add <option /> if item represents a value not present in one of the <select />'s options
            if (self.isSelect && !$('option[value="' + encodeURIComponent(itemValue) + '"]',self.$element)[0]) {
                var $option = $('<option selected>' + htmlEncode(itemText) + '</option>');
                $option.data('item', item);
                $option.attr('value', itemValue);
                self.$element.append($option);
            }

            if (!dontPushVal)
                self.pushVal();

            // Add class when reached maxTags
            if (self.options.maxTags === self.itemsArray.length || self.items().toString().length === self.options.maxInputLength)
                self.$container.addClass('bootstrap-tagsinput-max');

            self.$element.trigger($.Event('itemAdded', { item: item }));
        },

        /**
         * Removes the given item. Pass true to dontPushVal to prevent updating the
         * elements val()
         */
        remove: function(item, dontPushVal) {
            var self = this;

            if (self.objectItems) {
                if (typeof item === "object")
                    item = $.grep(self.itemsArray, function(other) { return self.options.itemValue(other) ==  self.options.itemValue(item); } );
                else
                    item = $.grep(self.itemsArray, function(other) { return self.options.itemValue(other) ==  item; } );

                item = item[item.length-1];
            }

            if (item) {
                var beforeItemRemoveEvent = $.Event('beforeItemRemove', { item: item, cancel: false });
                self.$element.trigger(beforeItemRemoveEvent);
                if (beforeItemRemoveEvent.cancel)
                    return;

                $('.tag', self.$container).filter(function() { return $(this).data('item') === item; }).remove();
                $('option', self.$element).filter(function() { return $(this).data('item') === item; }).remove();
                if($.inArray(item, self.itemsArray) !== -1)
                    self.itemsArray.splice($.inArray(item, self.itemsArray), 1);
            }

            if (!dontPushVal)
                self.pushVal();

            // Remove class when reached maxTags
            if (self.options.maxTags > self.itemsArray.length)
                self.$container.removeClass('bootstrap-tagsinput-max');

            self.$element.trigger($.Event('itemRemoved',  { item: item }));
        },

        /**
         * Removes all items
         */
        removeAll: function() {
            var self = this;

            $('.tag', self.$container).remove();
            $('option', self.$element).remove();

            while(self.itemsArray.length > 0)
                self.itemsArray.pop();

            self.pushVal();
        },

        /**
         * Refreshes the tags so they match the text/value of their corresponding
         * item.
         */
        refresh: function() {
            var self = this;
            $('.tag', self.$container).each(function() {
                var $tag = $(this),
                    item = $tag.data('item'),
                    itemValue = self.options.itemValue(item),
                    itemText = self.options.itemText(item),
                    tagClass = self.options.tagClass(item);

                // Update tag's class and inner text
                $tag.attr('class', null);
                $tag.addClass('tag ' + htmlEncode(tagClass));
                $tag.contents().filter(function() {
                    return this.nodeType == 3;
                })[0].nodeValue = htmlEncode(itemText);

                if (self.isSelect) {
                    var option = $('option', self.$element).filter(function() { return $(this).data('item') === item; });
                    option.attr('value', itemValue);
                }
            });
        },

        /**
         * Returns the items added as tags
         */
        items: function() {
            return this.itemsArray;
        },

        /**
         * Assembly value by retrieving the value of each item, and set it on the
         * element.
         */
        pushVal: function() {
            var self = this,
                val = $.map(self.items(), function(item) {
                    return self.options.itemValue(item).toString();
                });

            self.$element.val(val, true).trigger('change');
        },

        /**
         * Initializes the tags input behaviour on the element
         */
        build: function(options) {
            var self = this;

            self.options = $.extend({}, defaultOptions, options);
            // When itemValue is set, freeInput should always be false
            if (self.objectItems)
                self.options.freeInput = false;

            makeOptionItemFunction(self.options, 'itemValue');
            makeOptionItemFunction(self.options, 'itemText');
            makeOptionFunction(self.options, 'tagClass');
          
            // Typeahead Bootstrap version 2.3.2
            if (self.options.typeahead) {
                var typeahead = self.options.typeahead || {};

                makeOptionFunction(typeahead, 'source');

                self.$input.typeahead($.extend({}, typeahead, {
                    source: function (query, process) {
                        function processItems(items) {
                            var texts = [];

                            for (var i = 0; i < items.length; i++) {
                                var text = self.options.itemText(items[i]);
                                map[text] = items[i];
                                texts.push(text);
                            }
                            process(texts);
                        }

                        this.map = {};
                        var map = this.map,
                            data = typeahead.source(query);

                        if ($.isFunction(data.success)) {
                            // support for Angular callbacks
                            data.success(processItems);
                        } else if ($.isFunction(data.then)) {
                            // support for Angular promises
                            data.then(processItems);
                        } else {
                            // support for functions and jquery promises
                            $.when(data)
                            .then(processItems);
                        }
                    },
                    updater: function (text) {
                        self.add(this.map[text]);
                    },
                    matcher: function (text) {
                        return (text.toLowerCase().indexOf(this.query.trim().toLowerCase()) !== -1);
                    },
                    sorter: function (texts) {
                        return texts.sort();
                    },
                    highlighter: function (text) {
                        var regex = new RegExp( '(' + this.query + ')', 'gi' );
                        return text.replace( regex, "<strong>$1</strong>" );
                    }
                }));
            }

          // typeahead.js
          // if (self.options.typeaheadjs) {
          //     var typeaheadjs = self.options.typeaheadjs || {};
              
          //     self.$input.typeahead(null, typeaheadjs).on('typeahead:selected', $.proxy(function (obj, datum) {
          //       if (typeaheadjs.valueKey)
          //         self.add(datum[typeaheadjs.valueKey]);
          //       else
          //         self.add(datum);
          //       self.$input.typeahead('val', '');
          //     }, self));
          // }

            self.$container.on('click', $.proxy(function(event) {
                if (! self.$element.attr('disabled')) {
                    self.$input.removeAttr('disabled');
                }
                self.$input.focus();
            }, self));

            if (self.options.addOnBlur && self.options.freeInput) {
                self.$input.on('focusout', $.proxy(function(event) {
                    if ($('.typeahead, .twitter-typeahead', self.$container).length === 0) {
                        self.add(self.$input.val());
                        self.$input.val('');
                    }
                }, self));
            }
            

            self.$container.on('keydown', 'input', $.proxy(function(event) {
                var $input = $(event.target),
                $inputWrapper = self.findInputWrapper();

                if (self.$element.attr('disabled')) {
                    self.$input.attr('disabled', 'disabled');
                    return;
                }

                switch (event.which) {
                    // BACKSPACE
                    case 8:
                        if (doGetCaretPosition($input[0]) === 0) {
                            var prev = $inputWrapper.prev();
                            if (prev) {
                                self.remove(prev.data('item'));
                            }
                        }
                    break;

                    // DELETE
                    case 46:
                        if (doGetCaretPosition($input[0]) === 0) {
                            var next = $inputWrapper.next();
                            if (next) {
                                self.remove(next.data('item'));
                            }
                        }
                    break;

                    // LEFT ARROW
                    case 37:
                    // Try to move the input before the previous tag
                    var $prevTag = $inputWrapper.prev();
                    if ($input.val().length === 0 && $prevTag[0]) {
                        $prevTag.before($inputWrapper);
                        $input.focus();
                    }
                    break;
                    // RIGHT ARROW
                    case 39:
                    // Try to move the input after the next tag
                    var $nextTag = $inputWrapper.next();
                    if ($input.val().length === 0 && $nextTag[0]) {
                        $nextTag.after($inputWrapper);
                        $input.focus();
                    }
                    break;
                    default:
                    // ignore
                }

                // Reset internal input's size
                var textLength = $input.val().length,
                    wordSpace = Math.ceil(textLength / 5),
                    size = textLength + wordSpace + 1;
                $input.attr('size', Math.max(this.inputSize, $input.val().length));
            }, self));

            self.$container.on('keypress', 'input', $.proxy(function(event) {
                var $input = $(event.target);

                if (self.$element.attr('disabled')) {
                    self.$input.attr('disabled', 'disabled');
                    return;
                }

                var text = $input.val(),
                maxLengthReached = self.options.maxChars && text.length >= self.options.maxChars;
                if (self.options.freeInput && (keyCombinationInList(event, self.options.confirmKeys) || maxLengthReached)) {
                    self.add(maxLengthReached ? text.substr(0, self.options.maxChars) : text);
                    $input.val('');
                    event.preventDefault();
                }

                // Reset internal input's size
                var textLength = $input.val().length,
                    wordSpace = Math.ceil(textLength / 5),
                    size = textLength + wordSpace + 1;
                $input.attr('size', Math.max(this.inputSize, $input.val().length));
            }, self));

            // Remove icon clicked
            self.$container.on('click', '[data-role=remove]', $.proxy(function(event) {
                if (self.$element.attr('disabled')) {
                    return;
                }
                self.remove($(event.target).closest('.tag').data('item'));
            }, self));

            // Only add existing value as tags when using strings as tags
            if (self.options.itemValue === defaultOptions.itemValue) {
                if (self.$element[0].tagName === 'INPUT') {
                    self.add(self.$element.val());
                } else {
                    $('option', self.$element).each(function() {
                        self.add($(this).attr('value'), true);
                    });
                }
            }
        },

    /**
     * Removes all tagsinput behaviour and unregsiter all event handlers
     */
    destroy: function() {
        var self = this;

        // Unbind events
        self.$container.off('keypress', 'input');
        self.$container.off('click', '[role=remove]');

        self.$container.remove();
        self.$element.removeData('tagsinput');
        self.$element.show();
    },

    /**
     * Sets focus on the tagsinput
     */
    focus: function() {
        this.$input.focus();
    },

    /**
     * Returns the internal input element
     */
    input: function() {
        return this.$input;
    },

    /**
     * Returns the element which is wrapped around the internal input. This
     * is normally the $container, but typeahead.js moves the $input element.
     */
    findInputWrapper: function() {
        var elt = this.$input[0],
            container = this.$container[0];
        while(elt && elt.parentNode !== container)
            elt = elt.parentNode;

        return $(elt);
    }
};

    /**
     * Register JQuery plugin
     */
    $.fn.tagsinput = function(arg1, arg2) {
        var results = [];

        this.each(function() {
            var tagsinput = $(this).data('tagsinput');
            // Initialize a new tags input
            if (!tagsinput) {
                tagsinput = new TagsInput(this, arg1);
                $(this).data('tagsinput', tagsinput);
                results.push(tagsinput);

                if (this.tagName === 'SELECT') {
                    $('option', $(this)).attr('selected', 'selected');
                }

                // Init tags from $(this).val()
                $(this).val($(this).val());
            } else if (!arg1 && !arg2) {
                // tagsinput already exists
                // no function, trying to init
                results.push(tagsinput);
            } else if(tagsinput[arg1] !== undefined) {
                // Invoke function on existing tags input
                var retVal = tagsinput[arg1](arg2);
                if (retVal !== undefined)
                    results.push(retVal);
            }
        });

        if ( typeof arg1 == 'string') {
            // Return the results from the invoked function calls
            return results.length > 1 ? results : results[0];
        } else {
            return results;
        }
    };

    $.fn.tagsinput.Constructor = TagsInput;

    /**
     * Most options support both a string or number as well as a function as
     * option value. This function makes sure that the option with the given
     * key in the given options is wrapped in a function
     */
    function makeOptionItemFunction(options, key) {
        if (typeof options[key] !== 'function') {
            var propertyName = options[key];
            options[key] = function(item) { return item[propertyName]; };
        }
    }
    function makeOptionFunction(options, key) {
        if (typeof options[key] !== 'function') {
            var value = options[key];
            options[key] = function() { return value; };
        }
    }
    /**
     * HtmlEncodes the given value
     */
    var htmlEncodeContainer = $('<div />');
    function htmlEncode(value) {
        if (value) {
            return htmlEncodeContainer.text(value).html();
        } else {
            return '';
        }
    }

    /**
     * Returns the position of the caret in the given input field
     * http://flightschool.acylt.com/devnotes/caret-position-woes/
     */
    function doGetCaretPosition(oField) {
        var iCaretPos = 0;
        if (document.selection) {
            oField.focus ();
            var oSel = document.selection.createRange();
            oSel.moveStart ('character', -oField.value.length);
            iCaretPos = oSel.text.length;
        } else if (oField.selectionStart || oField.selectionStart == '0') {
            iCaretPos = oField.selectionStart;
        }
        return (iCaretPos);
    }

    /**
     * Returns boolean indicates whether user has pressed an expected key combination. 
     * @param object keyPressEvent: JavaScript event object, refer
     *     http://www.w3.org/TR/2003/WD-DOM-Level-3-Events-20030331/ecma-script-binding.html
     * @param object lookupList: expected key combinations, as in:
     *     [13, {which: 188, shiftKey: true}]
     */
    function keyCombinationInList(keyPressEvent, lookupList) {
            var found = false;
            $.each(lookupList, function (index, keyCombination) {
                if (typeof (keyCombination) === 'number' && keyPressEvent.which === keyCombination) {
                    found = true;
                    return false;
                }

                if (keyPressEvent.which === keyCombination.which) {
                    var alt = !keyCombination.hasOwnProperty('altKey') || keyPressEvent.altKey === keyCombination.altKey,
                        shift = !keyCombination.hasOwnProperty('shiftKey') || keyPressEvent.shiftKey === keyCombination.shiftKey,
                        ctrl = !keyCombination.hasOwnProperty('ctrlKey') || keyPressEvent.ctrlKey === keyCombination.ctrlKey;
                    if (alt && shift && ctrl) {
                        found = true;
                        return false;
                    }
                }
            });

            return found;
    }

    /**
     * Initialize tagsinput behaviour on inputs and selects which have
     * data-role=tagsinput
     */
    $(function() {
        $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
    });
})(window.jQuery);
