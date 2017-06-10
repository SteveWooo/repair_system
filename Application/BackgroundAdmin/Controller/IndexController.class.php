<?php
namespace backgroundAdmin\Controller;
use Think\Controller;
class IndexController extends Controller {
    private function setAdminMsg(){
        $data = M('admin')->where(array('student_number'=>cookie('admin')))->find();
        if($data == null){
            $data['auth'] = 0;
        }
        $this->assign('admin', $data);
    }
    public function index(){
        $this->setAdminMsg();
        $this->display();
    }
    public function welcome(){
    	if( cookie('admin') == null){
    		$this->assign('logined', 0);
    	}
    	else {
    		$this->assign('logined', 1);
    	}
    	$this->display();
    }
}