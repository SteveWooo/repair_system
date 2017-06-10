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
				width:100%;
				height:50px;
				line-height: 50px;
				background-color: #999;
				color:#fff;
			}
		</style>
	</head>
	<body>
		<div align="center" class="header">
			<?php if($data['state'] == 2): ?><div style="position: absolute;right:5px">
					<a href="<?php echo U('Home/CheckOrder/orderJudgeView',array('id'=>$data['id']));?>" class="btn btn-warning">
						评价
					</a>
				</div><?php endif; ?>
			<a href="javascript:history.back()" style="position:absolute;color:#fff;left:16px">
				<span class="glyphicon glyphicon-chevron-left"></span>
			</a>
			维修单详情
		</div>

		<div class="content">
			<ul class="list-group">
				<li class="list-group-item">
					订单：No.<?php echo ($data['id']); ?>
				</li>
				<li class="list-group-item">
					状态：
					<?php if($data['state'] == 0): ?><span style="color:red">
							<?php echo ($data['stateName']); ?>
						</span><?php endif; ?>
					<?php if($data['state'] == 1 or $data['state'] == 2): ?><span style="color:orange">
							<?php echo ($data['stateName']); ?>
						</span><?php endif; ?>
					<?php if($item['state'] >= 3): ?><span style="color:#44e">
							<?php echo ($data['stateName']); ?>
						</span><?php endif; ?>
				</li>
				<li class="list-group-item">
					干事：<?php echo ($data['name']); ?>
				</li>
				<li class="list-group-item">
					联系：<?php echo ($data['mobile']); ?>
				</li>
				<li class="list-group-item">
					维修日志：
					<?php if(is_array($atoMsg)): $i = 0; $__LIST__ = $atoMsg;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><div class="row" style="padding-left: 16px">
							<div class="col-xs-7" style="color:#999">
								<?php echo ($item['date']); ?>
							</div>
							<div class="col-xs-5">
								<?php echo ($item['msg']); ?>
							</div>
						</div><?php endforeach; endif; else: echo "" ;endif; ?>
				</li>
			</ul>
		</div>
		<script type="text/javascript" src="/repair_system/Public/js/jquery-2.2.4.min.js"></script>
		<script type="text/javascript" src="/repair_system/Public/js/bootstrap.min.js"></script>
	</body>
</html>