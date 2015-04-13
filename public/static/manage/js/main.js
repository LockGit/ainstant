/*
*	登录页面
*/

//焦点获取
$(document).ready(function(){
	setTimeout(function(){
		$('#login-name').focus();
		//$('#login-name').select();
	},200);	
});

//提交表单
$(document).ready(function(){
	$('#login-submit').click(function(){
		//$(this).preventDefault();
		$("#login-form-submit").submit();
	});
});

//回车键提交表单
$(document).keypress(function(e) {
	if (e.which == 13)
	$("#login-form-submit").submit();
});

//调整登录页面高度
$(document).ready(function(){
	//获取窗口可视高度
	var windowHeight =  $(window).height();
	if (windowHeight < 600) {
		$('.login-screen-me').css('height','600');
	} else {
		$('.login-screen-me').css('height',windowHeight);
	}	
});

//调整主页高度
$(document).ready(function(){
	//获取窗口可视高度
	var windowHeight =  $(window).height();
	if (windowHeight < 600) {
		$('#my-main').css('height','550');
	} else {
		$('#my-main').css('height',windowHeight-50);
	}	
});

/*
*	主页
*/

//控制左侧二级菜单的显示与隐藏

$(function(){
	$('.sidebar-nav-ul-li').click(function(){
		if ($(this).hasClass('sidebar-nav-current') != true) {
			$('ul',this).slideToggle(400);
		}
	});
});
/*
*	编辑器-添加文章
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
				];

	if ($('#post-editor').length>0) {
	editor = new Simditor({
  		textarea: $('#post-editor'),
  		toolbar: toolbar,
  		defaultImage: '/backend/simditor/images/image.png',
  		autosave: 'editor-content',
  		upload:  {
        	url: '../medialibrary/postupload', //上传途径
        	fileKey: 'upload_file', //服务器端获取文件数据的参数名
        	connectionCount: 10, //同时上传文件的最大数量
        	leaveConfirm: '正在上传文件，如果离开上传会自动取消'
      	}, 
      	pasteImage: true
	});
	}

	
});

//提交表单
$(document).ready(function(){
	$('#post-submitform').click(function(){
		//$(this).preventDefault();
		$('#post-form').submit();
	});

	//$('#post-submitform-1').click(function(){
	//	$('.simditor-body').append('11111');
	//});

});

/*
*	分类
*/
//提交表单
$(document).ready(function(){
	$('#add-cat-submitform').click(function(){
		$('#add-category-form').submit();
	});

});

/*
*	标签
*/
//提交表单
$(document).ready(function(){
	$('#add-tag-submitform').click(function(){
		$('#add-tag-form').submit();
	});

});

/*
*	类型
*/
//提交表单
$(document).ready(function(){
	$('#add-type-submitform').click(function(){
		$('#add-type-form').submit();
	});

});
