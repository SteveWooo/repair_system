<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>南苑计协维修系统</title>
		<link rel="stylesheet" type="text/css" href="/repair_system/Public/css/bootstrap.min.css">
		<link rel="stylesheet" href="/repair_system/Public/css/indexFrame.css">
		<style type="text/css">
			ul li {
				list-style: none;
			}
			.list-group-item {
				border:none;
				border-bottom:1px solid #eee;
				border-top:1px solid #eee;
			}
			.row{
				margin-left: 0;
				margin-right: 0;
			}
		</style>
	</head>
	<body>
		<div align="left" style="margin-left: 20px;margin-bottom:20px">
			<h3>订单查询列表</h3>
		</div>
		<div class="row">
			<div class="col-xs-3">
				<h5 style="padding-left: 16px">电话</h5>
			</div>
			<div class="col-xs-7">
				<h5 style="padding-left:5px">内容</h5>
			</div>
			<div class="col-xs-2">
				<h5>状态</h5>
			</div>
		</div>
		<ul class="list-group">
			<?php if(is_array($orderList)): $i = 0; $__LIST__ = $orderList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li class="list-group-item">
					<a style="display: block;" href="<?php echo U('BackgroundAdmin/CheckOrder/listOption',array('id'=>$item['id']));?>" class="row">
						<div class="col-xs-3">
							<?php echo ($item['mobile']); ?>
						</div>
						<div class="col-xs-7" style="word-break:break-all; word-wrap:break-all;">
							<?php echo ($item['content']); ?>
						</div>
						<?php if($item['stateCode'] == 0): ?><div class="col-xs-2" style="color:red">
								<?php echo ($item['state']); ?>
							</div>
						<?php else: ?>
							<div class="col-xs-2" style="color:#99e">
								<?php echo ($item['state']); ?>
							</div><?php endif; ?>
					</a>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
		<script type="text/javascript" src="/repair_system/Public/js/jquery-2.2.4.min.js"></script>
		<script type="text/javascript" src="/repair_system/Public/js/bootstrap.min.js"></script>
	</body>
</html>