<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){

    }
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

    private function getUser(){
    	$account = cookie('account');
    	//todo:login 验证登录超时
    	if($account == null || $account == ''){
    		$this->errorReturn('请先验证用户');
    	}
    	$data = M('user')->where(array('mobile'=>$account))->select();
    	if(count($data) == 0){
    		$this->errorReturn('不可预料的意外发生了！');
    	}
    	return $data[0];
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
    /*
    * 新增订单
    */
    private function getAddOrderData(){
    	$data['content'] = I('post.content');
    	$data['computer_type'] = I('post.computer_type');
    	$data['service_type'] = I('post.service_type');
        $data['student_number'] = I('post.student_number');
        $data['name'] = I('post.name');
    	foreach ($data as $key => $value) {
    		if($data[$key] == null){
    			$this->errorReturn('数据漏填啦！');
    		}
    	}

    	return $data;
    }
    private function updateUser($data,$user){
        $update['name'] = $data['name'];
        $update['student_number'] = $data['student_number'];
        M('user')->where(array('id'=>$user['id']))->setField($update);
    }
    private function addOrderList($data,$user){
    	$list['user_id'] = $user['id'];
    	$list['state'] = 0;
    	$list['time'] = time();
    	M('order_list')->add($list);
    }
    private function addOrderDetail($data,$user){
    	$detail['mobile'] = $user['mobile'];
    	$detail['content'] = $data['content'];
    	$detail['service_type'] = $data['service_type'];
    	$detail['computer_type'] = $data['computer_type'];

    	M('order_detail')->add($detail);
    }
    private function mentionService($type,$user_mobile){
        $admin = M('admin')->where('auth > 2')->select();
        foreach ($admin as $key => $value) {
            $this->mention($admin[$key]['mobile'],$type,$user_mobile);
        }
    }
    public function addOrderAjax(){
    	$user = $this->getUser();
    	$data = $this->getAddOrderData();
    	$this->addOrderList($data,$user);
    	$this->addOrderDetail($data,$user);
        $this->updateUser($data,$user);
        $this->mentionService($data['service_type'],$user['mobile']);
    	$this->successReturn('提交成功！');

    }
    private function getServiceType(){
        $types = M('service_types')->select();
        return $types;
    }
    private function getUserMsg(){
        $account = cookie('account');
        $user = M('user')->where(array('mobile'=>$account))->find();
        return $user;
    }
    public function addOrder(){
        $this->display('stop');
        // $this->checkLogin();
        // $types = $this->getServiceType();
        // $this->assign('types', $types);
        // $user = $this->getUserMsg();
        // $this->assign('user', $user);
    	  // $this->display();
    }

    /*
    *  通知维修人员 权限4,5的人
    */
    private function mention($admin_phone,$service,$user_phone){
    	$remote_server = "http://www.cybergear-cn.com/msg/mentionService.php?user_phone=".$user_phone."&service=".$service."&admin_phone=".$admin_phone;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remote_server);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "jb51.net's CURL Example beta");
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }


    /*
    *  查询订单
    */
}
