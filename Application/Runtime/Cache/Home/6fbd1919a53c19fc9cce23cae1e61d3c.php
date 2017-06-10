<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
		<title>南苑计协维修系统</title>
		<link rel="stylesheet" type="text/css" href="/repair_system/Public/css/bootstrap.min.css">
		<style type="text/css">
			.content {
				margin-top:16px;
			}
			.header {
				width:100%;
				height:50px;
				line-height: 50px;
				background-color: #999;
				color:#fff;
			}
			.row{
			}

			.detail {
				height:50px;
				line-height: 50px;
			}
		</style>
	</head>
	<body>
		<div align="center" class="header">
			<div style="position: absolute;right:5px">
				<a href="<?php echo U('Home/Index/addOrder');?>" class="btn btn-warning">
					我要报修
				</a>
			</div>
			我的维修单
		</div>
		<div class="content">
			<div class="row" style="margin-left:0px;width:100%">
				<div class="col-xs-2">
					id
				</div>
				<div class="col-xs-6">
					提交时间
				</div>
				<div class="col-xs-4">
					状态
				</div>
			</div>
			<br>
			<ul class="list-group">
				<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Home/CheckOrder/checkDetail',array('id'=>$item['id']));?>" class="list-group-item row" style="width:100%;border-right:none;border-left: none;">
						<div class="col-xs-2 detail">
							<?php echo ($item['id']); ?>
						</div>
						<div class="col-xs-7 detail">
							<?php echo ($item['date']); ?>
						</div>
						<div class="col-xs-3 detail">
							<?php if($item['state'] == 0): ?><span style="color:red">
									<?php echo ($item['stateName']); ?>
								</span><?php endif; ?>
							<?php if($item['state'] == 1 or $item['state'] == 2): ?><span style="color:orange">
									<?php echo ($item['stateName']); ?>
								</span><?php endif; ?>
							<?php if($item['state'] >= 3): ?><span style="color:#44e">
									<?php echo ($item['stateName']); ?>
								</span><?php endif; ?>
						</div>
					</a><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>

		<script type="text/javascript" src="/repair_system/Public/js/jquery-2.2.4.min.js"></script>
		<script type="text/javascript" src="/repair_system/Public/js/bootstrap.min.js"></script>
	</body>
</html>