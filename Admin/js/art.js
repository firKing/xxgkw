function login(){
	var usernameVal = $("#username").val();
	var passwordVal = $("#password").val();
	$.post(
		"ajax/log.php",
		{logsubmit:1, username:usernameVal, password:passwordVal},
		function(back){
			if(back==null || back.login==0){
				alert("登录失败");
			}else if(back.login==1){
				eval(back.synloginCode);
				alert("登录成功");
			}else if(back.login==-1){
				alert("用户不存在,或者被删除");
			}else if(back.login==-2){
				alert("密码错误，请检查用户名和密码");
			}
		},
		'json'
	);
}