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
				width:50%;
			}
			.add-content input {
				width:20%;
				height:35px;
				border-radius: 10px;
				border:1px #eee solid;
				margin-left: 16px;
				padding:16px 16px 16px 16px;
			}
			.row{
				margin-left: 0;
				margin-right: 0;
			}
		</style>
	</head>
	<body>
		<div>
			<h4>
				服务类型修改
			</h4>
		</div>
		<hr>
		<div class="add-content">
			<input type="text" id="type_name" placeholder="服务名字">
			<button class="btn btn-primary" onclick="addType()">
				提交
			</button>
		</div>
		<hr>
		<div class="content">
			<ul class="list-group">
				<?php if(is_array($types)): $i = 0; $__LIST__ = $types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li class="list-group-item row" style="border:none;border-bottom:1px #eee solid;">
						<div class="col-xs-10" style="line-height: 30px">
							<?php echo ($item['name']); ?>
						</div>
						<div class="ol-xs-2">
							<button onclick="delType(<?php echo ($item['id']); ?>)" class="btn btn-danger">
								删除
							</button>
						</div>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>

		<div style="display:none">
			<div id="delType">
				<?php echo U('BackgroundAdmin/OrderOption/delTypeAjax');?>
			</div>
			<div id="addType">
				<?php echo U('BackgroundAdmin/OrderOption/addTypeAjax');?>
			</div>
		</div>
		<script type="text/javascript" src="/repair_system/Public/js/jquery-2.2.4.min.js"></script>
		<script type="text/javascript" src="/repair_system/Public/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			
			var send = function(url,data){
				$.ajax({
					url:url,
					type:"post",
					data:data,
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

			var addType = function(){
				var data = {
					name:$('#type_name').val()
				}
				var url = $('#addType').html();
				send(url,data);
			}

			var delType = function(id){
				var data = {
					id:id
				}
				url = $('#delType').html();
				send(url,data);
			}
		</script>
	</body>
</html>