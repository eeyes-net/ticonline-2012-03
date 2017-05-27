<?php
class UserAction extends Action {
    public function index(){
		if(session('?admin')) {
			$UserinfoModel = D("admin");
			$num0=0;
			$num1=1;
         $name=session('admin');
			$UserinfoList = $UserinfoModel->where("checked = "."'".$num1."'")->order('id desc')->select();
			$UserinfoList_check = $UserinfoModel->where("checked = "."'".$num0."'")->order('id desc')->select();
			foreach($UserinfoList as $key => $value) {
				if($UserinfoList[$key]['mode']==2) {
					$UserinfoList[$key]['mode']="超级管理员";
				}elseif($UserinfoList[$key]['mode']==1) {
					$UserinfoList[$key]['mode']="活动管理";
				}else {
					$UserinfoList[$key]['mode']="活动发布";
				}
			}
			$this->assign('Userinfolist',$UserinfoList);
			$this->assign('Userinfolist_check',$UserinfoList_check);
			$this->display();
		}
		else {
			$this->redirect('Admin/index',0,3,'请登录');
		}
	}
	
	
	
	public function delete_userinfo() {
		if(session('?admin')) {
		$UserinfoModel = D("admin");
		if($UserinfoModel->where("id = "."'".$_POST['id']."'")->delete()) {
			$this->redirect('User/index',0,3,'修改成功');
		}
		else {
			$result = array("res" => "fail");
			echo json_encode($result);
		}
	}else {
			$this->redirect('Admin/index',0,3,'请登录');
		}
	}

	public function get_userinfo() {
		if(session('?admin')) {
		$UserinfoModel = D("admin");
		$Userinfolist = $UserinfoModel->where("id = "."'".$_POST['id']."'")->find();
		echo json_encode($Userinfolist);
	}else {
			$this->redirect('Admin/index',0,3,'请登录');
		}
	}
	

	public function up_one() {
		if(session('?admin')) {
		$id = $_GET['uid'];
		$Userinfo = D("admin");
		$Userinfolist = $Userinfo->where("id = "."'".$id."'")->find();
		if($Userinfolist['mode']<2) {
			$Userinfolist['mode']+=1;
			$data['mode']=$Userinfolist['mode'];
		 	$Userinfo->where("id = "."'".$id."'")->data($data)->save();
		 	$this->redirect('User/index',0,3,'修改成功');
		 }else {
		 	$this->redirect('User/index',0,3,'已是最高权限');
		 	}
		 }else {
			$this->redirect('Admin/index',0,3,'请登录');
		}
	}

	public function down_one() {
		if(session('?admin')) {
		$id = $_GET['uid'];
		$Userinfo = D("admin");
		$Userinfolist = $Userinfo->where("id = "."'".$id."'")->find();
		if($Userinfolist['mode']>0) {
			$Userinfolist['mode']-=1;
			$data['mode']=$Userinfolist['mode'];
		 	$Userinfo->where("id = "."'".$id."'")->data($data)->save();
		 	$this->redirect('User/index',0,3,'修改成功');
		 }else {
		 	$this->redirect('User/index',0,3,'已是最低权限');
		 	}
		 }else {
			$this->redirect('Admin/index',0,3,'请登录');
		}
	}

	public function check() {
		$id = $_GET['uid'];
		$Userinfo = D("admin");
		$data['checked']=1;
		$Userinfo->where("id = "."'".$id."'")->data($data)->save();
		$this->redirect('User/index',0,3,'修改成功');
	}
	
	public function insert() {
	if(session('?admin')) {
		$Userinfo = D("admin");
		$data = $Userinfo->create();
		$data['pwd'] = md5($_POST['pwd1']);
		if($_POST['pwd1']==$_POST['pwd2']){
		if($data['id'] == '') {
		if($Userinfo->add($data)) {
                    $result = array("res" => "ok");
			echo json_encode($result);
                }
                else {
                    $result = array("res" => "bad");
			echo json_encode($result);
                }
		}
		else {
		
			$Userinfo->save($data);
			$this->redirect('Admin/index',0,3,'修改成功');
		
		}
		}
		else{
		$result = array("res" => "bad");
			echo json_encode($result);
		}
		}
		
		else {
		$this->login();
		}
	}
}
?>
