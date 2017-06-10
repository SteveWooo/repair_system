<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>南苑计协维修系统</title>
		<link rel="stylesheet" type="text/css" href="/repair_system/Public/css/bootstrap.min.css">
		<style type="text/css">
		.row{
			margin-left: 0;
			margin-right: 0;
		}
		</style>
	</head>
	<body>
		<div class="header">
			<h4>订单列表</h4>
		</div>
		
		<div class="content">
			<div class="row">
				<div class="col-xs-3">
					<h5 style="padding-left: 16px">用户</h5>
				</div>
				<div class="col-xs-7">
					<h5 style="padding-left:5px">内容</h5>
				</div>
				<div class="col-xs-2">
					<h5>快捷分配</h5>
				</div>
			</div>
			<ul class="list-group">
				<?php if(is_array($orders)): $i = 0; $__LIST__ = $orders;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><div class="list-group-item">
						<div class="row">
							<a href="<?php echo U('BackgroundAdmin/OrderDistribute/checkDetail',array('id'=>$item['id']));?>">
								<div class="col-xs-3">
								<?php echo ($item['mobile']); ?>
								</div>
								<div class="col-xs-6">
									<?php echo ($item['content']); ?>
								</div>
							</a>
							<div align="right" class="col-xs-3">
								<form action="<?php echo U('BackgroundAdmin/OrderDistribute/distributeOrder');?>" method="post">
									<input type="text" name="id" value="<?php echo ($item['id']); ?>" style="visibility: hidden;display: none">
									<select name="selectAdmin" id="selectAdmin">
										<?php if(is_array($admins)): $i = 0; $__LIST__ = $admins;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$admin): $mod = ($i % 2 );++$i;?><option value="<?php echo ($admin['id']); ?>"><?php echo ($admin['name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
									</select>
									<input type="submit" style="border-radius: 10px;background-color: #fff;border:1px #eee solid;" value="提交">
								</form>
							</div>
						</div>
					</div><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
		<script type="text/javascript" src="/repair_system/Public/js/jquery-2.2.4.min.js"></script>
		<script type="text/javascript" src="/repair_system/Public/js/bootstrap.min.js"></script>
	</body>
</html>