<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
		<title>南苑计协维修系统</title>
		<link rel="stylesheet" type="text/css" href="/repair_system/Public/css/bootstrap.min.css">
		<style type="text/css">
			.header {
				margin-left: 0;
				margin-right: 0;
				height:50px;
				line-height: 50px;
				background-color: #999;
				color:#fff;
			}
			.content {
				margin-top:100px;
				/*width:90%;*/
				margin-left: 5%;
				margin-right: 5%;
				margin-left: 5%;
			}
			.content input {
				width:60%;
				border:1px #eee solid;
				height:30px;
				line-height: 30px;
				padding:16px 16px 16px 16px ;
			}
		</style>
	</head>
	<body>
		<div align="center" class="header">
			验证手机号
		</div>
	
		<div class="content">
			<div>
				<input type="text" placeholder="手机号" id="mobile">
				<button onclick="getAuthCode()" id="getAuthBtn" class="btn btn-primary">
					获取验证码
				</button>
				<div id="getAuthdefaultBtn" class="btn btn-gray" style="display: none">
					60s后重新获取
				</div>
			</div>
			<input style="width:80%;margin-top:16px" type="text" placeholder="输入验证码" id="auth">
			<div align="center">
				<button style="width:70%;margin-top:16px" onclick="checkAuthCode()" class="btn btn-warning">
					提交
				</button>
			</div>
		</div>

		<div style="visibility: hidden;display: none">
			<div id="getAuthCodeAjax">
				<?php echo U('Home/User/getAuthCodeAjax');?>
			</div>
			<div id="checkAuthCodeAjax">
				<?php echo U('Home/User/checkAuthCodeAjax');?>
			</div>
			<div id="addOrder">
				<?php echo U('Home/Index/addOrder');?>
			</div>
		</div>
		<script type="text/javascript" src="/repair_system/Public/js/jquery-2.2.4.min.js"></script>
		<script type="text/javascript" src="/repair_system/Public/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			var disableBtn = function(){
				var btn = $('#getAuthBtn');
				var defaultBtn = $('#getAuthdefaultBtn');
				btn.hide();
				defaultBtn.show();
				var number = 60;
				defaultBtn.html(number + "s后重新获取");
				var intervalFun = function(){
					if(number == 0){
						btn.show();
						defaultBtn.hide();
						clearInterval(interval);
					}else {
						number -- ;
						defaultBtn.html(number + "s后重新获取");
					}
				}
				var interval = setInterval(function(){
					intervalFun();
				},1000);
			}
			var getAuthCode = function(){
				var data = {
					mobile:$('#mobile').val()
				}
				$.ajax({
					url:$('#getAuthCodeAjax').html(),
					type:'post',
					data:data,
					success:function(res){
						if(res.success){
							disableBtn();
						}else {
							alert(res.errmsg);
						}
					},
					error:function(){
						alert('网络错误');
					}
				})
			}

			var checkAuthCode = function(){
				var data = {
					mobile:$('#mobile').val(),
					auth_code:$('#auth').val()
				}
				$.ajax({
					url:$('#checkAuthCodeAjax').html(),
					type:'post',
					data:data,
					success:function(res){
						if(res.success){
							alert(res.msg);
							window.location.href = $('#addOrder').html();
						}else {
							alert(res.errmsg);
						}
					},
					error:function(){
						alert('网络错误');
					}
				})
			}
		</script>
	</body>
</html>