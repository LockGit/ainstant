$(function(){
	setTimeout(function(){
		$('#username').focus();
		//$('#login-name').select();
	},200);

	//回车键提交表单
	$(document).keypress(function(e) {
		if (e.which == 13) {
			loginFormSubmit();
		}		
	});

	//提交表单
	$('#login-form-submit').click(function(e){
		e.preventDefault();
		loginFormSubmit();
	});

	function loginFormSubmit() {
		//$.post("session/login", { username: "admin", password: "dangcheng" });
		$.post("session/login", $("#login-form").serialize(), function(data) {

				if (data === 'success') {
					swal("OK!", "登陆成功!", "success");
					setTimeout(function(){
						window.location.href = location.protocol+'//'+location.hostname +'/manage';
					}, 3000);
				} else if (data === 'noPassword') {
					swal("NO!", "密码错误!", "error");
				} else if (data === 'noEmptyUsername') {
					swal("NO!", "没有输入用户名!", "error");
				} else if (data === 'noUsername') {
					swal("NO!", "用户不存在!", "error");
				} else if (data === 'NO') {
					swal("NO!", "你没有权限!", "error");
				} else {
					swal("NO!", "不明原因,过会儿再来吧!", "info");
				}


		});
	}
});