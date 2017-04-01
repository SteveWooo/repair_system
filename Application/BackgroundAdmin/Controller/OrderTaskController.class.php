<?php
namespace BackgroundAdmin\Controller;
use Think\Controller;
use Think\Model;
class OrderTaskCOntroller extends Controller{
	public function index(){

	}
	private function setAdminMsg(){
        $data = M('admin')->where(array('student_number'=>cookie('admin')))->find();
        $this->assign('admin', $data);
        return $data['id'];
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
        $adminId = $this->setAdminMsg();
        return $adminId;
    }

    /*
    * 获取维修任务数据
    */
    private function getTaskDetail($taskId){
    	$data = M('admin_to_order')->where(array('task_id'=>$taskId))->find();
    	if($data == NULL){
    		$this->error('参数错误');
    	}
    	return $data;
    }

    /*
    *  维修人员确定维修完毕
    */
    private function setFinishedState($orderId){
    	$result = M('order_list')->where(array('id'=>$orderId))->setField('state',2);
    	if($result === false){
    		$this->error('修改订单状态失败');
    	}
    }
    private function setTaskFinishedTable($taskId,$msg){
    	$result = M('admin_to_order')
    	->where(array('task_id'=>$taskId))
    	->setField(array('msg'=>$msg,'isend'=>1));

    	if($result === false){
    		$this->error('发生严重错误');
    	}
    }
    private function getFinishedInput(){
    	$data['task_id'] = I('post.task_id');
    	$data['msg'] = I('post.msg');
    	return $data;
    }
    public function adminFinishedOrder(){
    	$input = $this->getFinishedInput();
    	$task = $this->getTaskDetail($input['task_id']);
    	$this->setFinishedState($task['order_id']);
    	$this->setTaskFinishedTable($task['task_id'],$input['msg']);
    	$this->success('提交成功');
    }

    /*
    *  维修人员无法维修
    */
    private function setBackState($orderId,$msg){
    	$result = M('order_list')->where(array('id'=>$orderId))->setField(array('state'=>0,));
    	if($result === false){
    		$this->error('修改订单状态失败');
    	}
    }
    private function setTaskTable($taskId,$msg){
    	$result = M('admin_to_order')
    	->where(array('task_id'=>$taskId))
    	->setField(array('msg'=>$msg,'isend'=>1));

    	if($result === false){
    		$this->error('发生严重错误');
    	}
    }
    private function getBackOrderInput(){
    	$data['task_id'] = I('post.task_id');
    	$data['msg'] = I('post.msg');
    	return $data;
    }
    public function adminBackOrder(){
    	$input = $this->getBackOrderInput();
    	$task = $this->getTaskDetail($input['task_id']);
    	$this->setBackState($task['order_id']);
    	$this->setTaskTable($task['task_id'],$input['msg']);
    	$this->success('退单成功!');
    }

    /*
    * 查询所有订单
    */
	private function getMyOrder($adminId){
		$sql = "SELECT a.task_id,b.state,b.time,b.user_id,b.id,c.mobile,c.content,c.computer_type,c.service_type,d.name
		FROM admin_to_order as a,order_list as b,order_detail as c,user as d
		where a.admin_id=".$adminId." and a.order_id=b.id and a.order_id=c.id and b.user_id=d.id 
		order by a.task_id desc";
		$m = new Model();
		$data = $m->query($sql);
		foreach ($data as $key => $value) {
			$data[$key]['date'] = date('Y-m-d H:i:s',$data[$key]['time']);
			$data[$key]['progress'] = ($data[$key]['state'] + 1) * 25;
			switch($data[$key]['state']){
            	case 0:
	                $data[$key]['stateName'] = "待分配";
	            break;
	            case 1:
	                $data[$key]['stateName'] = "待维修";
	            break;
	            case 2:
	                $data[$key]['stateName'] = "待评价";
	            break;
	            case 3:
	                $data[$key]['stateName'] = "已完成";
	            break;
	        }
		}
		return $data;
	}
	private function selectOrderList($list){
		if(I('get.getAll') == 1){
            return $list;
		}
        $data = array();
        foreach ($list as $key => $value) {
            if($list[$key]['state'] == 1){
                array_push($data,$list[$key]);
            }
        }
        return $data;
	}
	public function orderTaskView(){
		$adminId = $this->checkLogin();
		$list = $this->getMyOrder($adminId);
		$list = $this->selectOrderList($list);
		$this->assign('tasks', $list);
		$this->display();
	}
}
