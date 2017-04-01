<?php
namespace backgroundAdmin\Controller;
use Think\Controller;
class CheckOrderController extends Controller {
    public function index(){
        $this->display();
    }

    private function setAdminMsg(){
        $data = M('admin')->where(array('student_number'=>cookie('admin')))->find();
        $this->assign('admin', $data);
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

    //获取列表
    private function getOrderList(){
        $list = M('order_list')->order('id desc')->select();
        $detail = M('order_detail')->order('id desc')->select();
        //获取状态
        foreach ($list as $key => $value) {
            $detail[$key]['stateCode'] = $list[$key]['state'];
            switch($list[$key]['state']){
                case 0:
                    $detail[$key]['state'] = "待分配";
                break;
                case 1:
                    $detail[$key]['state'] = "已分配";
                break;
                case 2:
                    $detail[$key]['state'] = "待评价";
                break;
                case 3:
                    $detail[$key]['state'] = "已完成";
                break;
                case 4:
                    $detail[$key]['state'] = "已关闭";
                break;
            }
        }

        $this->assign('orderList', $detail);
    }
    public function checkOrderView(){
        $this->checkLogin();
        $this->getOrderList();
        $this->display();
    }

    /*
    * 查看订单详情和处理订单状态；
    */
    private function getOrder(){
        $id = I('get.id');
        $list = M('order_list')->where(array('id'=>$id))->find();
        $detail = M('order_detail')->where(array('id'=>$id))->find();
        switch($list['state']){
            case 0:
                $detail['state'] = "待分配";
            break;
            case 1:
                $detail['state'] = "已分配";
            break;
            case 2:
                $detail['state'] = "待评价";
            break;
            case 3:
                $detail['state'] = "已完成";
            break;
            case 4:
                $detail['state'] = "已关闭";
            break;
        }
        $data = array();
        foreach ($detail as $key => $value) {
            $data[$key] = $detail[$key];
        }
        $data['stateCode'] = $list['state'];
        $data['progress'] = ($data['stateCode'] + 1) * 25;
        return $data;
    }
    private function getUserByAccount($mobile){
        $data = M('user')->where(array('mobile'=>$mobile))->find();
        return $data;
    }
    private function getAdminById($id){
        $admin = M('admin')->where(array('id'=>$id))->find();
        return $admin;
    }
    private function getOrderAdmin(){
        $id = I('get.id');
        $ato = M('admin_to_order')->where(array('order_id'=>$id))->find();
        if($ato == null){
            return ;
        }
        $admin = $this->getAdminById($ato['admin_id']);
        return $admin;
    }
    public function listOption(){
        $this->checkLogin();
        $data = $this->getOrder();
        $admin = $this->getOrderAdmin();
        $user = $this->getUserByAccount($data['mobile']);
        $this->assign('orderAdmin',$admin);
        $this->assign('user',$user);
        $this->assign('data',$data);
        $this->display();
    }

    public function chengeOrder(){
        $state = I('post.state');
        $id = I('post.id');
        $result = M('order_list')->where(array('id'=>$id))->setField('state',$state);
        if($result !== false){
            $this->success('修改成功');
        }else {
            $this->error('数据库修改失败');
        }
    }
}
