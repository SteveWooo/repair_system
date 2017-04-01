<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>南苑计协维修系统</title>
		<link rel="stylesheet" type="text/css" href="/repair_system/Public/css/bootstrap.min.css">
		<link rel="stylesheet" href="/repair_system/Public/css/indexFrame.css">
	</head>
	<body>
		<div align="center" style="width:85%;margin-top:20px">
			<form class="form-horizontal">
				<div class="form-group">
			    	<label for="inputEmail3" class="col-sm-2 control-label">学号</label>
			    	<div class="col-sm-10">
			      		<input type="text" id="student_number" class="form-control">
			    	</div>
			 	</div>
			 	<div class="form-group">
			    	<label for="inputEmail3" class="col-sm-2 control-label">密码</label>
			    	<div class="col-sm-10">
			      		<input type="text" id="password" class="form-control">
			    	</div>
			 	</div>
			</form>

			<div align="center">
				<button onclick="login()" class="btn btn-primary">
					登陆
				</button>
			</div>
		</div>
		<div style="visibility: hidden">
			<div id="loginAjax">
				<?php echo U('backgroundAdmin/User/loginAjax');?>
			</div>
			<div id="Home">
				<?php echo U('backgroundAdmin/Index/welcome');?>
			</div>
		</div>
		<script type="text/javascript" src="/repair_system/Public/js/jquery-2.2.4.min.js"></script>
		<script type="text/javascript" src="/repair_system/Public/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			var login = function(){
				var data = {};
				var getData = function(){
					data = {
						account:$('#student_number').val(),
						password:$('#password').val()
					}
					for(var i in data){
						if(data[i] == ''){
							alert('请填写完整');
							return false;
						}
						return true;
					}
				}
				if(!getData())return ;
				$.ajax({
					url:$('#loginAjax').html(),
					type:'post',
					data:data,
					success:function(res){
						if(res.success){
							alert(res.msg);
							// window.location.href = $('#Home').html();
							window.parent.window.location.reload();
						}
						else {
							alert(res.errmsg);
						}
					},
					error:function(err){
						alert('网络错误');
					}
				})
			}
		</script>
	</body>
</html>