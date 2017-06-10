<?php
namespace BackgroundAdmin\Controller;
use Think\Controller;
class OrderOptionController extends Controller{
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
    private function checkCookie($account,$cookie){
        $data = M('admin_cookie')->where(array('account'=>$account))->find();
        if($data == null){
            $this->errorReturn('登录状态出现不可预料的意外');
        }
        if($data['cookie'] != $cookie){
            cookie('login', null);
            cookie('admin', null);
            $this->errorReturn('登录超时');
        }
    }
    private function checkLogin(){
        if(cookie('admin') == null){
            $this->errorReturn('登录超时');
        }
        $this->checkCookie(cookie('admin'),cookie('login'));
        $adminId = $this->setAdminMsg();
        return $adminId;
    }

	private function getOptionTypeId(){
		$id = I('post.id');
		return $id;
	}
	public function delTypeAjax(){
		$id = $this->getOptionTypeId();
		$result = M('service_types')->where(array('id'=>$id))->delete();
		if($result !== false){
			$this->successReturn('删除成功');
		}else {
			$this->errorReturn('数据库修改失败');
		}
	}
	public function addTypeAjax(){
		$data['name'] = I('post.name');
		$result = M('service_types')->where(array('id'=>$id))->add($data);
		if($result !== false){
			$this->successReturn('新增成功');
		}else {
			$this->errorReturn('数据库修改失败');
		}
	}
	private function getAllServiceType(){
		$types = M('service_types')->select();
		return $types;
	}
	public function orderOptionView(){
		$types = $this->getAllServiceType();
		$this->assign('types', $types);
		$this->display();
	}
}