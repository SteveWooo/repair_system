<?php
namespace backgroundAdmin\Controller;
use Think\Controller;
use Think\Model;
class OrderDIstributeController extends Controller{
	public function index(){

	}
	private function getAllAdmin(){
		$admin = M('admin')->where('auth < 5 and auth >0')->select();
		return $admin;
	}
	private function setAdminMsg(){
        $data = M('admin')->where(array('student_number'=>cookie('admin')))->find();
        $this->assign('admin', $data);
    }
	private function setThisAdmin(){
		$account = cookie('admin');
		$admin = M('admin')->where(array('student_number'))->find();
		$this->assign('admin', $admin);
	}
	private function checkCookie($account,$cookie){
        $data = M('admin_cookie')->where(array('account'=>$account))->find();
        if($data == null){
            $this->error('登录状态出现不可预料的意外');
        }
        if($data['cookie'] != $cookie){
            cookie('login', null);
            cookie('admin', null);
            $this->error('登录超时');
        }
    }
    private function checkLogin(){
        if(cookie('admin') == null){
            $this->error('登录超时');
        }
        $this->checkCookie(cookie('admin'),cookie('login'));
        $this->setAdminMsg();
    }

	/*
	* 分配订单操作
	*/
	private function getAdminById($id){
		$admin = M('admin')->where(array('id'=>$id))->find();
		if($admin == null){
			$this->error('出现了奇怪的错误');
		}
		return $admin;
	}
	private function getDistributeOrderInputs(){
		$data['id'] = I('post.id');
		$data['adminId'] = I('post.selectAdmin');
		if($data['adminId'] == NULL || $data['adminId'] == ""){
			$this->error('请选择维修人员');
		}
		return $data;
	}
	private function setAdminToOrder($orderId,$adminId){
		$data['admin_id'] = $adminId;
		$data['order_id'] = $orderId;
		$data['time'] = time();
		$data['msg'] = "";
		$data['isend'] = 0;
		M('admin_to_order')->add($data);
	}
	private function getUserPhoneByOrderId($orderId){
		$order = M('order_detail')->where(array('id'=>$orderId))->find();
		return $order['mobile'];
	}
	private function getOrderByOrderId($orderId){
		$order = M('order_detail')->where(array('id'=>$orderId))->find();
		return $order;
	}
	private function successDistribute($adminId,$orderId){
		$admin = $this->getAdminById($adminId);
		$userPhone = $this->getUserPhoneByOrderId($orderId);
		$this->mentionUser($userPhone,$admin['mobile'],$admin['name']);
		$order = $this->getOrderByOrderId($orderId);
		$this->mentionAdmin($order['service_type'],$userPhone,$admin['mobile']);
		$this->success('分配成功');
	}
	private function setOrderList($orderId,$adminId){
		$result = M('order_list')->where(array('id'=>$orderId))->setField('state',1);
		if($result !== false){
			$this->successDistribute($adminId,$orderId);
		}else {
			$this->error('分配失败，修改状态失败');
		}
	}
	public function distributeOrder(){
		$this->checkLogin();
		$input = $this->getDistributeOrderInputs();
		$this->setAdminToOrder($input['id'],$input['adminId']);
		$this->setOrderList($input['id'],$input['adminId']);
	}

	/*
	* 分配订单首页列表
	*/
	private function getPreDistributeOrders(){
		$data = M('order_list')->where(array('state'=>0))->select();
		$detail = M('order_detail')->select();
		foreach ($data as $key => $value) {
			foreach ($detail as $j => $value) {
				if($data[$key]['id'] == $detail[$j]['id']){
					$data[$key]['mobile'] = $detail[$j]['mobile'];
					$data[$key]['content'] = $detail[$j]['content'];
				}
			}
		}
		return $data;
	}
	public function orderDistributeView(){
		$this->checkLogin();
		$orders = $this->getPreDistributeOrders();
		$admins = $this->getAllAdmin();
		$this->assign('admins', $admins);
		$this->assign("orders", $orders);
		$this->display();
	}

	/*
	* 修改订单状态为3（关闭订单）
	*/
	public function closeOrder(){
		$id = I('get.id');
		if($id == null){
			$this->error('参数错误');
			return ;
		}
		$result = M('order_list')->where(array('id'=>$id))->setField('state',4);
		if($result !== false){
			$this->success('关闭成功');
		}else{
			$this->error('操作失败');
		}
	}

	/*
	* 分配订单前查看详情
	*/
	private function getUserByUserId($userId){
		$user = M('user')->where(array('id'=>$userId))->find();
		if($user == NULL){
			$this->error('参数错误');
		}
		return $user;
	}
	private function getDetailById($id){
		$detail = M('order_detail')->where(array('id'=>$id))->find();
		$list = M('order_list')->where(array('id'=>$id))->find();
		$detail['state'] = $list['state'];
		$detail['date'] = date('Y-m-d H:i:s',$list['time']);
		$user = $this->getUserByUserId($list['user_id']);
		$detail['userName'] = $user['name'];
		$detail['studentNumber'] = $user['student_number'];
		$detail['progress'] = ($detail['state'] + 1) * 25;
		switch($detail['state']){
			case 0:
				$detail['stateName'] = "待分配";
			break;
			case 1:
				$detail['stateName'] = "已分配";
			break;
			case 2:
				$detail['stateName'] = "待评价";
			break;
			case 3:
				$detail['stateName'] = "已完成";
			break;
		}
		$this->assign('user', $user);
		return $detail;
	}
	private function getCheckDetailInput(){
		$id = I('get.id');
		return $id;
	}
	public function checkDetail(){
		$this->checkLogin();
		$input['id'] = $this->getCheckDetailInput();
		$detail = $this->getDetailById($input['id']);
		$admins = $this->getAllAdmin();
		$this->assign('admins', $admins);
		$this->assign('data', $detail);
		$this->display();
	}

	public function mentionAdmin($service,$user_phone,$admin_phone){
		$remote_server = "http://www.cybergear-cn.com/msg/acmRepair/mentionAdmin.php?user_phone=".$user_phone."&service=".$service."&admin_phone=".$admin_phone."&time=待定";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remote_server);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "jb51.net's CURL Example beta");
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
	}

	public function mentionUser($user_phone,$admin_phone,$name){
		$remote_server = "http://www.cybergear-cn.com/msg/acmRepair/mentionUser.php?user_phone=".$user_phone."&name=".$name."&admin_phone=".$admin_phone."&time=待定";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remote_server);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "jb51.net's CURL Example beta");
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
	}

}
