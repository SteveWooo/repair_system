<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>南苑计协维修系统</title>
		<link rel="stylesheet" type="text/css" href="/repair_system/Public/css/bootstrap.min.css">
		<style type="text/css">
			.content {
				width:90%;
				margin-left: 5%;
				border:1px #999 solid;
				border-radius: 10px;
				padding:16px 16px 16px 16px;
				overflow: hidden;
			}

			.content ul li{
				border:none;
				border-bottom:1px #eee solid;
				border-top:1px #eee solid;
			}

			.content .msg-input{
				margin-left: 20px;
				width:70%;
				padding:10px 10px 10px 10px;
				margin-top:16px;
				height:30px;
				line-height: 30px;
				border-radius: 10px;
				border:1px #eee solid;
			}
		</style>
	</head>
	<body style="min-width: 800px">
		<header>
			<h3>
				我的订单任务：
			</h3>
			<div style="position:absolute;right:5%;margin-top:-35px">
				<a href="<?php echo U('BackgroundAdmin/OrderTask/orderTaskView');?>" class="btn btn-primary">
					只显示待维修单
				</a>
				<a href="<?php echo U('BackgroundAdmin/OrderTask/orderTaskView',array('getAll'=>1));?>" class="btn btn-default">
					显示所有
				</a>
			</div>
		</header>
		<hr>
		<div class="row" style="width:100%">
			<?php if(is_array($tasks)): $i = 0; $__LIST__ = $tasks;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><div class="col-xs-6" style="padding-top:20px;padding-bottom:20px">
					<div class="content">
						<ul class="list-group">
							<h5 style="margin-left: 20px">进度：
								<?php if($item['state'] == 1): ?><span style="color:red"><?php echo ($item['stateName']); ?></span>
								<?php else: ?>
									<span style="color:#99e"><?php echo ($item['stateName']); ?></span><?php endif; ?>
								<span style="position: absolute;right:20%">订单号：<?php echo ($item['id']); ?></span>
							</h5>
							<div class="progress" style="width:50%;margin-left: 20px">
			  					<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo ($item['progress']); ?>%;">
			  					</div>
							</div>
							<li class="list-group-item">
								用户姓名：<?php echo ($item['name']); ?>
							</li>
							<li class="list-group-item">
								用户联系电话：<?php echo ($item['mobile']); ?>
							</li>
							<li class="list-group-item">
								提交日期：<?php echo ($item['date']); ?>
							</li>
							<li class="list-group-item">
								服务类型：<?php echo ($item['service_type']); ?>
							</li>
							<li class="list-group-item">
								电脑类型：<?php echo ($item['computer_type']); ?>
							</li>
							<li class="list-group-item">
								详情：<?php echo ($item['content']); ?>
							</li>
							<div style="margin-top:20px" id="formBtn<?php echo ($item['id']); ?>" onclick="showFinishedPanel(<?php echo ($item['id']); ?>)" class="btn btn-primary">
								维修完成
							</div>
							<div style="margin-top:20px;margin-left: 10%;" id="formBtn<?php echo ($item['id']); ?>" onclick="showBackPanel(<?php echo ($item['id']); ?>)" class="btn btn-danger">
								无法维修
							</div>
							<form hidden id="finished<?php echo ($item['id']); ?>" action="<?php echo U('BackgroundAdmin/OrderTask/adminFinishedOrder');?>" method="post">
								<input type="text" name="task_id" value="<?php echo ($item['task_id']); ?>" style="display: none">
								<input type="text" class="msg-input" name="msg" placeholder="输入留言">
								<input style="display: block;margin-top:16px;margin-left:20px" type="submit" class="btn btn-primary" value="确认提交">
							</form>
							<form hidden id="form<?php echo ($item['id']); ?>" action="<?php echo U('BackgroundAdmin/OrderTask/adminBackOrder');?>" method="post">
								<input type="text" name="task_id" value="<?php echo ($item['task_id']); ?>" style="display: none">
								<input type="text" class="msg-input" name="msg" placeholder="输入原因">
								<input style="display: block;margin-top:16px;margin-left:20px" type="submit" class="btn btn-danger" value="提交无法维修理由(仅提交这个就可以)">
							</form>
						</ul>
					</div>
				</div><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
		<script type="text/javascript" src="/repair_system/Public/js/jquery-2.2.4.min.js"></script>
		<script type="text/javascript" src="/repair_system/Public/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			var showBackPanel = function(name){
				var backPanel = "#form" + name;
				$(backPanel).show();

				var finishedPanel = "#finished"+name;
				$(finishedPanel).hide();
			}

			var showFinishedPanel = function(name){
				var finishedPanel = "#finished" + name;
				$(finishedPanel).show();

				var backPanel = "#form" + name;
				$(backPanel).hide();
			}
		</script>
	</body>
</html>