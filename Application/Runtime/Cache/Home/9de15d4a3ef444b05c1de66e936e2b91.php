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
			.content {
				width:90%;
				margin-left: 5%;
				margin-top:20px;
			}
			.content select {
				width:100%;
				border:1px #eee solid;
				padding:5px 5px 5px 5px;
				height:30px;
			}
			.content .title{
				height:30px;
				line-height: 30px;
			}
			.content textarea {
				width:100%;
				border:1px #eee solid;
				height:100px;
				padding:16px 16px 16px 16px;
				border-radius: 10px;
			}
			.footer {
				position:fixed;
				bottom:0;
				width:100%;
				height:40px;
				background-color: #999;
				color:#fff;
			}
			.footer .submit-btn{
				background-color: #f29f3f;
				position: absolute;
				right:0;
				width:100px;
				height:40px;
				line-height: 40px;
				text-align: center;
				font-size:20px;
			}
		</style>
	</head>
	<body>
		<div align="center" class="header">
			<a href="javascript:history.back()" style="position:absolute;color:#fff;left:16px">
				<span class="glyphicon glyphicon-chevron-left"></span>
			</a>
			维修单评价
		</div>

		<div class="content">
			<div class="row">
				<div class="col-xs-3 title">
					等级：
				</div>
				<div class="col-xs-9">
					<select name="" id="level">
						<option value="5">超棒的维修（5星）</option>
						<option value="4">一般的满意</option>
						<option value="3">满意的一般</option>
						<option value="2">差</option>
						<option value="1">妈的乱维修（1星）</option>
					</select>
				</div>
			</div>
			<div class="title">
				详细评价
			</div>
			<div>
				<textarea name="" id="content" placeholder="写下您的报修感受" cols="30" rows="10"></textarea>
			</div>
		</div>	

		<div class="footer">
			<div onclick="submit()" class="submit-btn">
				评价
			</div>
		</div>

		<div style="display: none">
			<input type="text" id="order_id" value="<?php echo ($order_id); ?>">
			<div id="orderJuege">
				<?php echo U('Home/CheckOrder/orderJudgeAjax');?>
			</div>
			<div id="checkOrder">
				<?php echo U('Home/CheckOrder/checkOrderView');?>
			</div>
		</div>
		<script type="text/javascript" src="/repair_system/Public/js/jquery-2.2.4.min.js"></script>
		<script type="text/javascript" src="/repair_system/Public/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			var submit = function (){
				var data = {
					content : $('#content').val(),
					level : $('#level').val(),
					order_id : $('#order_id').val()
				}
				console.log(data);

				for(var i in data ){
					if(data[i] == '' || data[i] == null){
						alert('漏填信息啦～');
						return ;
					}
				}

				$.ajax({
					url:$('#orderJuege').html(),
					type:'post',
					data:data,
					success:function(res){
						if(res.success){
							alert(res.msg);
							window.location.href = $('#checkOrder').html();
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