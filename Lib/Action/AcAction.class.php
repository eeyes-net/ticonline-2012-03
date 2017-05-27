<?php
class AcAction extends Action {
    public function index(){
		if(session('?admin')) {
			$AcinfoModel = D("Acinfo");
			$num0=0;
			$num1=1;
         $name=session('admin');
			$AcinfoList = $AcinfoModel->where("acallow = "."'".$num1."'")->order('acid desc')->select();
			$AcinfoList_check = $AcinfoModel->where("acallow = "."'".$num0."'")->order('acid desc')->select();
			foreach($AcinfoList as $key => $value) {
				$AcinfoList[$key]['actime']=date("Y-M-d",$AcinfoList[$key]['actime']);
				$Actype = D("Actype");
				$AcinfoList[$key]['actype']=$Actype->where("tid = "."'".$AcinfoList[$key]['typeid']."'")->getField("tname");
				if($AcinfoList[$key]['acallow']==1) {
					$AcinfoList[$key]['acallow']="已审核";
				}
				else{
					$AcinfoList[$key]['acallow']="未审核";
				}
				if($AcinfoList[$key]['actic']==1) {
					$AcinfoList[$key]['actic']="要";
				}
				else{
					$AcinfoList[$key]['actic']="不要";
				}
			}
		foreach($AcinfoList_check as $key => $value) {
				$AcinfoList_check[$key]['actime']=date("Y-M-d",$AcinfoList_check[$key]['actime']);
				$Actype = D("Actype");
				$AcinfoList_check[$key]['actype']=$Actype->where("tid = "."'".$AcinfoList_check[$key]['typeid']."'")->getField("tname");
				if($AcinfoList_check[$key]['acallow']==1) {
					$AcinfoList_check[$key]['acallow']="已审核";
				}
				else{
					$AcinfoList_check[$key]['acallow']="未审核";
				}
				if($AcinfoList_check[$key]['actic']==1) {
					$AcinfoList_check[$key]['actic']="要";
				}
				else{
					$AcinfoList_check[$key]['actic']="不要";
				}
			}
			$this->assign('Acinfolist',$AcinfoList);
			$this->assign('Acinfolist_check',$AcinfoList_check);
			$this->display();
		}
		else {
			$this->redirect('Admin/index',0,3,'请登录');
		}
	}
	
	
	
	public function delete() {
		$AcinfoModel = D("Acinfo");
		if($AcinfoModel->where("acid = "."'".$_GET['uid']."'")->delete()) {
			$this->redirect('Ac/index',0,3,'修改成功');
		}
		else {
			$result = array("res" => "fail");
			echo json_encode($result);
		}
	}
	

	public function check() {
		$id = $_GET['uid'];
		$Acinfo = D("Acinfo");
		$data['acallow']=1;
		$Acinfo->where("acid = "."'".$id."'")->data($data)->save();
		$this->redirect('Ac/index',0,3,'修改成功');
	}
	

}
?>
