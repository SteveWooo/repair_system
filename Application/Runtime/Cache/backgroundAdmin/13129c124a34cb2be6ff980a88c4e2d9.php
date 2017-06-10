<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>南苑计协维修系统</title>
		<link rel="stylesheet" type="text/css" href="/github/repair_system/Public/css/bootstrap.min.css">
		<style type="text/css">
			.row{
				margin:0 0 0 0;
			}
		</style>
	</head>
	<body>
		<div align="center" style="margin-top:100px">
			<h3>欢迎使用计协管理系统</h3>
			<?php if($logined == 0): ?><a href="<?php echo U('backgroundAdmin/User/login');?>" class="btn btn-primary">
					登陆 
				</a>
				<?php else: ?>
				<a onclick="logout()" class="btn btn-warning">
					注销
				</a><?php endif; ?>
		</div>
		<div style="visibility: hidden">
			<div id="logoutAjax">
				<?php echo U('backgroundAdmin/User/logoutAjax');?>
			</div>
		</div>
		<script type="text/javascript" src="/github/repair_system/Public/js/jquery-2.2.4.min.js"></script>
		<script type="text/javascript">
			var logout = function(){
				if(!confirm('是否确定登出？'))return ;
				$.ajax({
					url:$('#logoutAjax').html(),
					type:"get",
					success:function(res){
						if(res.success){
							alert(res.msg);
							window.parent.window.location.reload();
						}else {
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