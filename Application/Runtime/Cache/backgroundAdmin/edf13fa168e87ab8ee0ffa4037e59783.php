<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>南苑计协维修系统</title>
		<link rel="stylesheet" type="text/css" href="/repair_system/Public/css/bootstrap.min.css">
		<style type="text/css">
			.list-group li{
				border:none;
				border-bottom:1px solid #eee;
				border-top:1px solid #eee;
			}
		</style>
	</head>
	<body>

		<button onclick="javascript:window.history.back()" class="btn btn-default">
			返回
		</button>
		<div align="left" style="margin-left: 10%">
			<h4>进度：</h4>
			<span style="color:red;float:right;margin-right:50%"><?php echo ($data['stateName']); ?></span>
			<div class="progress" style="width:50%">
			  	<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo ($data['progress']); ?>%;">
			  	</div>
			</div>
			<form action="<?php echo U('BackgroundAdmin/CheckOrder/chengeOrder');?>" method="post">
				<div class="content">
					<!-- <?php if($admin['auth'] >= 4): ?><h4>订单分配：</h4>
						<form action="<?php echo U('BackgroundAdmin/OrderDistribute/distributeOrder');?>" method="post">
							<input type="text" name="id" value="<?php echo ($data['id']); ?>" style="display: none">
							<select name="selectAdmin" id="selectAdmin">
								<?php if(is_array($admins)): $i = 0; $__LIST__ = $admins;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$admin): $mod = ($i % 2 );++$i;?><option value="<?php echo ($admin['id']); ?>"><?php echo ($admin['name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
							<input type="submit" style="border-radius: 10px;background-color: #fff;border:1px #eee solid;" value="提交">
						</form><?php endif; ?> -->
					<h4>用户信息：</h4>
					<ul class="list-group" style="width:60%;">
						<li class="list-group-item">
							手机号：<?php echo ($user['mobile']); ?>
						</li>
						<li class="list-group-item">
							姓名：<?php echo ($user['name']); ?>
						</li>
						<li class="list-group-item">
							学号：<?php echo ($user['student_number']); ?>
						</li>
					</ul>
					<h4>订单详情：</h4>
					<ul class="list-group" style="width:60%">
						<li class="list-group-item">
							服务类型：<?php echo ($data['service_type']); ?>
						</li>
						<li class="list-group-item">
							电脑类型：<?php echo ($data['computer_type']); ?>
						</li>
						<li class="list-group-item" style="word-break:break-all; word-wrap:break-all;">
							详情：<?php echo ($data['content']); ?>
						</li>
					</ul>
					<?php if($admin['auth'] >= 5): ?><h4>修改订单状态：</h4>
						<select name="state" id="">
							<option value="<?php echo ($data['stateCode']); ?>"><?php echo ($data['state']); ?></option>
							<option value="0">已提交</option>
							<option value="1">已分配</option>
							<option value="2">待评价</option>
							<option value="3">已完成</option>
						</select>
						<input style="margin-top:20px;" type="submit" class="btn btn-primary" value="提交"><?php endif; ?>
					<input type="text" value="<?php echo ($data['id']); ?>" name="id" style="display: none">
				</div>
			</form>
		</div>
		
		<script type="text/javascript" src="/repair_system/Public/js/jquery-2.2.4.min.js"></script>
		<script type="text/javascript" src="/repair_system/Public/js/bootstrap.min.js"></script>
	</body>
</html>