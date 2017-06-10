<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>南苑计协维修系统</title>
		<link rel="stylesheet" type="text/css" href="/repair_system/Public/css/bootstrap.min.css">
		<style type="text/css">
		.row {
			margin-left: 0;
			margin-right: 0;
		}
		</style>
	</head>
	<body>

		<header>
			<h3>
				管理用户：
			</h3>
		</header>
		<hr>
		
		<div class="content">
			<div class="row">
				<div class="col-xs-3">
					姓名
				</div>
				<div class="col-xs-3" style="color:red">
					职位
				</div>
				<div class="col-xs-3">
					手机号
				</div>
				<div class="col-xs-3">
					操作
				</div>
			</div>
			<ul class="list-group">
				<?php if(is_array($admins)): $i = 0; $__LIST__ = $admins;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$admin): $mod = ($i % 2 );++$i;?><li class="list-group-item">
						<div class="row">
							<div class="col-xs-3">
								<?php echo ($admin['name']); ?>
							</div>
							<div class="col-xs-3" style="color:red">
								<?php echo ($admin['job']); ?>
							</div>
							<div class="col-xs-3">
								<?php echo ($admin['mobile']); ?>
							</div>
							<div class="col-xs-3">
								<button class="btn btn-danger" onclick="delAdmin(<?php echo ($admin['id']); ?>)">
									开除
								</button>
							</div>	
						</div>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>	
			</ul>	
		</div>
		<div style="display:none">
			<div id="delAdmin">
				<?php echo U('BackgroundAdmin/User/deleteAdminAjax');?>
			</div>
		</div>
		<script type="text/javascript" src="/repair_system/Public/js/jquery-2.2.4.min.js"></script>
		<script type="text/javascript" src="/repair_system/Public/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			var delAdmin = function(id){
				if(!confirm('确定开除？'))return ;
				$.ajax({
					url:$('#delAdmin').html(),
					type:"post",
					data:{
						id:id
					},
					success:function(res){
						if(res.success){
							alert(res.msg);
							window.location.reload();
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