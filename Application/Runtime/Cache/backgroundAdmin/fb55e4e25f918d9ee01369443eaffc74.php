<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>南苑计协维修系统</title>
		<link rel="stylesheet" type="text/css" href="/github/repair_system/Public/css/bootstrap.min.css">
		<link rel="stylesheet" href="/github/repair_system/Public/css/indexFrame.css">
	</head>
	<body>

		<div class="navbar navbar-duomi navbar-static-top" role="navigation">
	        <div class="container-fluid">
	            <div class="navbar-header">
	                <a class="navbar-brand" href="<?php echo U('BackgroundAdmin/Index/index');?>" id="logo">南苑计协维修系统后台管理
	                </a>
	            </div>
	        </div>
	    </div>
	    <div class="container-fluid">
	        <div class="row">
	            <div class="col-md-2">
	                <ul id="main-nav" class="nav nav-tabs nav-stacked" style="">
	                    <li class="nav-list active" name="welcome">
	                        <a href="javascript:void(0)" onclick="router.action('welcome')">
	                            <i class="glyphicon glyphicon-th-large"></i>
	                            首页
	                        </a>
	                    </li>
	                    <?php if($admin['auth'] >= 4): ?><li class="nav-list" name="system">
		                        <a href="#systemSetting" class="nav-header collapsed" data-toggle="collapse">
		                            <i class="glyphicon glyphicon-cog"></i>
		                            管理员用户管理
		                               <span class="pull-right glyphicon glyphicon-chevron-down"></span>
		                        </a>
		                        <ul id="systemSetting" class="nav nav-list collapse secondmenu" style="height: 0px;">
		                            <li name="./User/addAdmin"><a href="javascript:void(0)" onclick="router.action('addAdmin')"><i class="glyphicon glyphicon-user"></i>新增用户</a></li>
		                            <li><a href="javascript:void(0)" ><i class="glyphicon glyphicon-th-list"></i>修改密码</a></li>
		                            <li name="manageAdmin"><a href="javascript:void(0)" onclick="router.action('manageAdmin')"><i class="glyphicon glyphicon-asterisk"></i>修改用户</a></li>
		                        </ul>
		                    </li><?php endif; ?>

						<?php if($admin['auth'] >= 3): ?><li class="nav-list" name="orderDistribute">
		                        <a href="javascript:void(0)" onclick="router.action('orderDistribute')">
		                            <i class="glyphicon glyphicon-credit-card"></i>
		                            干事订单分配
		                        </a>
		                    </li><?php endif; ?>

	                    <?php if($admin['auth'] >= 2): ?><li class="nav-list" name="orderOption">
		                        <a href="#orderOptionList" class="nav-header collapsed" data-toggle="collapse">
		                            <i class="glyphicon glyphicon-cog"></i>
		                            订单前台管理
		                               <span class="pull-right glyphicon glyphicon-chevron-down"></span>
		                        </a>
		                        <ul id="orderOptionList" class="nav nav-list collapse secondmenu" style="height: 0px;">
		                            <li name="serviceType"><a href="javascript:void(0)" onclick="router.action('serviceType')"><i class="glyphicon glyphicon-user"></i>服务类型管理</a></li>
		                        </ul>
		                    </li><?php endif; ?>

						<?php if($admin['auth'] >= 1): ?><li class="nav-list" name="orderTask">
		                        <a href="javascript:void(0)" onclick="router.action('orderTask')">
		                            <i class="glyphicon glyphicon-credit-card"></i>
		                            个人订单任务
		                        </a>
		                    </li><?php endif; ?>

	 					<?php if($admin['auth'] >= 1): ?><li class="nav-list" name="checkOrder">
		                        <a href="javascript:void(0)" onclick="router.action('checkOrder')">
		                            <i class="glyphicon glyphicon-credit-card"></i>
		                            订单查询
		                        </a>
		                    </li><?php endif; ?>
	                    <!-- <li class="nav-list" name="../SchoolmateOrganize">
	                        <a href="javascript:void(0);" onclick="router.action('../SchoolmateOrganize')">
	                            <i class="glyphicon glyphicon-globe"></i>
	                            校友组织模块
	                        </a>
	                    </li>

	                    <li class="nav-list" name="../SchoolmateActivity">
	                        <a href="javascript:void(0);" onclick="router.action('../SchoolmateActivity')">
	                            <i class="glyphicon glyphicon-calendar"></i>
	                            校友活动模块
	                        </a>
	                    </li>

	                    <li class="nav-list" name="../SchoolmateRes">
	                        <a href="javascript:void(0);" onclick="router.action('../SchoolmateRes')">
	                            <i class="glyphicon glyphicon-calendar"></i>
	                            校友资源共享模块
	                        </a>
	                    </li>
	                    <li class="nav-list" name="../SchoolmateMien">
	                        <a href="javascript:void(0);" onclick="router.action('../SchoolmateMien')">
	                            <i class="glyphicon glyphicon-calendar"></i>
	                            校友风采模块
	                        </a>
	                    </li>

	                    <li class="nav-list" name="../SchoolmateServer">
	                        <a href="javascript:void(0);" onclick="router.action('../SchoolmateServer')">
	                            <i class="glyphicon glyphicon-fire"></i>
	                             校友服务模块
	                        </a>
	                    </li>

	                    <li class="nav-list" name="SchoolmateServer">
	                        <a href="<?php echo U('BackgroundAdmin/Index/clearCookie');?>" >
	                            <i class="glyphicon glyphicon-fire"></i>
	                             登出
	                        </a>
	                    </li> -->
	                </ul>
	            </div>
	            <div class="col-md-10" >
	                <iframe id="mainPage" src="/github/repair_system/index.php/BackgroundAdmin/Index/welcome.html" frameBorder="0" width="100%" scrolling="yes" height="800"></iframe>
	            </div>
	        </div>
	    </div>
	    <div class="footer">
	    	<div class="title">
	    		code by SteveWoo. version:1.1.1 name:跟上我的节拍
	    		<br>
	    		birthday:2017-3-7
	    	</div>
	    </div>

		<div style="visibility: hidden" hidden>
			<div id="checkOrder">
				<?php echo U('BackgroundAdmin/CheckOrder/checkOrderView');?>
			</div>
			<div id="welcome">
				<?php echo U('BackgroundAdmin/Index/welcome');?>
			</div>
			<div id="addAdmin">
				<?php echo U('BackgroundAdmin/User/addAdmin');?>
			</div>
			<div id="orderTask">
				<?php echo U('BackgroundAdmin/OrderTask/orderTaskView');?>
			</div>
			<div id="orderDistribute">
				<?php echo U('BackgroundAdmin/OrderDistribute/orderDistributeView');?>
			</div>
			<div id="serviceType">
				<?php echo U('BackgroundAdmin/OrderOption/orderOptionView');?>
			</div>
			<div id="manageAdmin">
				<?php echo U('BackgroundAdmin/User/manageAdmin');?>
			</div>
		</div>

		<script type="text/javascript" src="/github/repair_system/Public/js/jquery-2.2.4.min.js"></script>
		<script type="text/javascript" src="/github/repair_system/Public/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			var router = {
				action:function(controller){
					var name = '#' + controller;
					$('#mainPage')[0].src=$(name).html();

					var lists = $('.nav-list');

					for(var i=0;i<lists.length;i++){
						if(lists[i].getAttribute('name') === controller){
							lists[i].setAttribute('class','active nav-list')
						}
						else if(lists[i].getAttribute('name')!=null){
							lists[i].setAttribute('class','nav-list')
						}
					}

				}
			}
		</script>
	</body>
</html>