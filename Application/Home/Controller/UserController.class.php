<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
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
    private function checkData($data){
    	foreach ($data as $key => $value) {
    		if($data[$key] == null){
    			$this->errorReturn("信息不全");
    		}
    	}
    }
    private function checkAuth(){
    	//TODO:检查进来的用户权限是否可以新增或修改管理员
    }

    /*
    * 新增用户
    */
    private function addUser($mobile,$student_number,$name){
    	$data['mobile'] = $mobile;
    	$data['student_number'] = $student_number;
    	$data['name'] = $name;
    	M('user')->add($data);

    	$user = M('user')->where(array('mobile'=>$mobile))->find();

    	$userPassword['salt'] = rand(1001,9999);
    	$userPassword['password'] = "0";
    	$userPassword['account'] = $mobile;
    	$userPassword['id'] = $user['id'];
    	M('user_password')->add($userPassword);

    	$user_cookie['user_id'] = $user['id'];
    	$user_cookie['cookie'] = md5($mobile);
    	$user_cookie['account'] = $mobile;
    	$user_cookie['time'] = time();
    	M('user_cookie')->add($user_cookie);

    	cookie('login',$user_cookie['cookie'],2560000);
    	cookie('account',$mobile,2560000);
    }

    /*
    * 用户重新登录
    */
    private function loginSuccess($mobile){
    	cookie('login',md5($mobile),2560000);
    	cookie('account',$mobile,2560000);
    	$this->successReturn('验证成功');
    }

    /*
    * 用户获取验证码
    */
    private function getPhoneAuthData(){
    	$data['mobile'] = I('post.mobile');
    	if($data['mobile'] == null){
    		$this->errorReturn('请正确填写手机号');
    	}
    	return $data;
    }
    private function addNewAuth($mobile){
    	$this->addUser($mobile,"0","0");
    	$data['account'] = $mobile;
    	$data['time'] = time();
    	$data['auth_code'] = rand(1001,9999);
    	$result = M('user_auth')->add($data);
    	if($result!==false){
    		$this->sendAuthCode($data['account'],$data['auth_code']);
    	}else {
    		$this->errorReturn('新增用户数据失败');
    	}
    }
    private function checkAuthTime($data){
    	$time = time();
    	if($time - $data['time'] <= 5){
    		$this->errorReturn('请不要连续发送验证码');
    	}
    	if($time - $data['time'] >= 300){
    		$auth = rand(1001,9999);
    		$data['auth_code'] = $auth;
    		$result = M('user_auth')->where(array('account'=>$data['account']))->save($data);
    		if($result !== false){
				$this->sendAuthCode($data['account'],$data['auth_code']);
    		}else {
    			$this->errorReturn('数据库更新验证码失败');
    		}
    	}else {
    		$this->sendAuthCode($data['account'],$data['auth_code']);
    	}
    }
    private function getAuthData($mobile){
    	$data = M('user_auth')->where(array('account'=>$mobile))->select();
    	if(count($data) == 0 || $data == null){
    		$this->addNewAuth($mobile);
    	}else {
    		$this->checkAuthTime($data[0]);
    	}
    }
    public function getAuthCodeAjax(){
    	$data = $this->getPhoneAuthData();
    	$this->getAuthData($data['mobile']);
    }
    public function auth(){
    	$this->display();
    }

    /*
    * 检查验证码
    */
    private function isPhoneExist($mobile){
    	$user = M('user')->where(array('mobile'=>$mobile))->select();
    	if(count($user) != 0){
    		return true;
    	}
    	$this->errorReturn('不可预料的错误发生了');
    }
    private function checkAuthCode($account,$authCode){
    	$data = M('user_auth')->where(array('account'=>$account))->select();
    	if(count($data) == 0){
    		$this->errorReturn('不可预料的错误发生了');
    	}else {
    		return $data[0]['auth_code'] == $authCode;
    	}
    }
    private function getCheckAuthCodeData(){
    	$data['mobile'] = I('post.mobile');
    	$data['auth_code'] = I('post.auth_code');
    	foreach ($data as $key => $value) {
    		if($data[$key] == null || $data[$key] == ''){
    			$this->errorReturn('信息不全');
    		}
    	}
    	return $data;
    }
    public function checkAuthCodeAjax(){
    	$data = $this->getCheckAuthCodeData();
    	$this->isPhoneExist($data['mobile']);
    	if($this->checkAuthCode($data['mobile'],$data['auth_code'])){
    		$this->loginSuccess($data['mobile']);
    	}else {
    		$this->errorReturn('验证码错误');
    	}
    }

    /*
    * 发送验证码
    */
    private function sendAuthCode($phone,$code){
        $remote_server = "http://www.cybergear-cn.com/msg/send.php?phone=".$phone."&code=".$code;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remote_server);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "jb51.net's CURL Example beta");
        $data = curl_exec($ch);
        curl_close($ch);
        $result = M('user_auth')->where(array('account'=>$phone))->setField('time',time());
        if($result!==false){
        	$this->successReturn('发送成功');
        }else {
        	$this->errorReturn('数据更新失败');
        }
        
        return $data;
    }

}