function login(){
	var usernameVal = $("#username").val();
	var passwordVal = $("#password").val();
	$.post(
		"ajax/log.php",
		{logsubmit:1, username:usernameVal, password:passwordVal},
		function(back){
			if(back==null || back.login==0){
				alert("��¼ʧ��");
			}else if(back.login==1){
				eval(back.synloginCode);
				alert("��¼�ɹ�");
			}else if(back.login==-1){
				alert("�û�������,���߱�ɾ��");
			}else if(back.login==-2){
				alert("������������û���������");
			}
		},
		'json'
	);
}