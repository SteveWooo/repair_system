<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class CheckOrderController extends Controller {
	private function successReturn($msg){
    	$res['msg'] = $msg;
    	$res['success'] = true;
    	$this->ajaxReturn($res);
    }
    private function errorReturn($errmsg){
    	$res['success'] = false;
    	$res['errmsg'] = $errmsg;
    	$this->ajaxReturn($res);
    }
    private function checkLogin(){
    	$data['account'] = cookie('account');
    	$cookie = cookie('login');
    	$user_cookie = M('user_cookie')->where($data)->find();
    	if($user_cookie == NULL){
    		$this->redirect('Home/Index/auth');
    	}
    	if($user_cookie['cookie'] !== $cookie){
    		$this->redirect('Index/auth',1);
    	}
    	return true;
    }
    private function getUser(){
		$data['mobile'] = cookie('account');
		$user = M('user')->where($data)->find();
		if($user == NULL){
			$this->error('发生了意料意外的错误');
		}
		return $user;
	}

	/*
	* 查询订单列表页面
	*/
	private function getAllOrderByUserId($userId){
		$lists = M('order_list')->where(array('user_id'=>$userId))->order('id desc')->select();
		foreach ($lists as $key => $value) {
			$lists[$key]['date'] = date('Y-m-d H:i:s',$lists[$key]['time']);
			switch($lists[$key]['state']){
				case 0:
					$lists[$key]['stateName'] = "已提交";
				break;
				case 1:
					$lists[$key]['stateName'] = "已分配";
				break;
				case 2:
					$lists[$key]['stateName'] = "待评价";
				break;
				case 3:
					$lists[$key]['stateName'] = "已完成";
				break;
				case 4:
					$lists[$key]['stateName'] = "已废弃";
				break;
			}
		}
		return $lists;
	}
	public function checkOrderView(){
		$this->checkLogin();
		$user = $this->getUser();
		$list = $this->getAllOrderByUserId($user['id']);
		$this->assign('list', $list);
		$this->display();
	}

	/*
	* 查询订单详情
	*/
	private function getOrderDetail($id){
		$db = new Model();
		$sql =
			"SELECT list.state,list.time,list.id,detail.content,detail.service_type,detail.computer_type,admin.mobile,admin.name
			FROM order_list as list,order_detail as detail,admin_to_order as ato,admin as admin
			WHERE list.id=".$id." and list.id=detail.id and admin.id=ato.admin_id and ato.order_id=list.id";
		$data = $db->query($sql);
		switch ($data[0]['state']) {
			case 0:
				$data[0]['stateName'] = "已提交";
				break;
			case 1:
				$data[0]['stateName'] = "已分配";
			break;
			case 2:
				$data[0]['stateName'] = "待评价";
			break;
			case 3:
				$data[0]['stateName'] = "已完成";
			break;
			case 4:
				$data[0]['stateName'] = "异常结束";
			break;
			default:
				# code...
				break;
		}
		$atoMsg = M('admin_to_order')->where(array('order_id'=>$id))->select();
		foreach ($atoMsg as $key => $value) {
			$atoMsg[$key]['date'] = date("Y-m-d H:i:s",$atoMsg[$key]['time']);
		}
		$data[0]['id'] = intval($data[0]['id']);
		$this->assign('atoMsg', $atoMsg);
		return $data[0];
	}
	private function getDetailInput(){
		$id = I('get.id');
		return $id;
	}
	public function checkDetail(){
		$this->checkLogin();
		$id = $this->getDetailInput();
		$data = $this->getOrderDetail($id);
		$this->assign("data", $data);
		$this->display();
	}

	/*
	* 评价
	*/
	private function setOrderState($id){
		$result = M('order_list')->where(array('id'=>$id))->setField('state', 3);
	}
	private function addOrderJudgeDb($data){
		echo $data['content'];
		M('order_judge')->add($data);
	}
	private function getOrderJudgeInput(){
		$data['order_id'] = I('post.order_id');
		$data['content'] = I('post.content');
		$data['level'] = I('post.level');
		$data['time'] = time();
		return $data;
	}
	private function checkIsAbleToJudge($id){
		$data = M('admin_to_order')->where(array('order_id'=>$id))->select();
		foreach ($data as $key => $value) {
			if($data[$key]['isend'] == 0){
				$this->errorReturn('维修尚未完成');
				return false;
			}
		}
		$list = M('order_judge')->where(array('order_id'=>$id))->select();
		if(count($list)!==0){
			$this->errorReturn('此维修单已被评价');
			return false;
		}
	}
	public function orderJudgeAjax(){
		$input = $this->getOrderJudgeInput();
		$this->checkIsAbleToJudge($input['order_id']);
		$this->addOrderJudgeDb($input);
		$this->setOrderState($input['order_id']);
		// $this->successReturn('评价成功');
	}

	private function getOrderJudgePageInput(){
		$data['id'] = I('get.id');
		return $data['id'];
	}
	public function orderJudgeView(){
		$this->checkLogin();
		$id = $this->getOrderJudgePageInput();
		$this->assign('order_id', $id);
		$this->display();
	}
}
