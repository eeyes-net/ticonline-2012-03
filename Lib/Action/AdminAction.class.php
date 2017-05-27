<?php
class AdminAction extends Action {
    public function index(){
		if(session('?admin')) {
			$AcinfoModel = D("Acinfo");
			//$AcinfoList = $AcinfoModel->order('acid desc')->select();
			
			
			//获取用户id
			$name=session('admin');
			$AdminModel = D("admin");
			$Admininfolist = $AdminModel->where("name = "."'".$name."'")->find();
			$acauthorid = $Admininfolist['id'];
			$num = 0;
			$OutinfoList = $AcinfoModel->order('acid desc')->select();
		//读取活动信息
			if($Admininfolist['mode']==1) {
					$AcinfoList_check = $AcinfoModel->where("acallow = "."'".$num."'")->order('acid desc')->select();
					if($AcinfoList_check) {
						session('ac_check',1);
					}
					foreach($AcinfoList_check as $key => $value) {
						if($AcinfoList_check[$key]['acaclow']==1) {
							$AcinfoList_check[$key]['acaclow']="已审核";
						}else{
							$AcinfoList_check[$key]['acaclow']="未审核";
						}
					
					}
					$this->assign('Acinfolist_check',$AcinfoList_check);
				}elseif($Admininfolist['mode']==2) {
					$AdminModel = D("admin");
					$AcinfoList_check = $AcinfoModel->where("acallow = "."'".$num."'")->order('acid desc')->select();
					if($AcinfoList_check) {
						session('ac_check',1);
					}
					foreach($AcinfoList_check as $key => $value) {
						if($AcinfoList_check[$key]['acaclow']==1) {
							$AcinfoList_check[$key]['acaclow']="已审核";
						}else{
							$AcinfoList_check[$key]['acaclow']="未审核";
						}
					}
					$Admin_check = $AdminModel->where("checked = "."'".$num."'")->order('id desc')->select();
					if($Admin_check) {
						session('ad_check',1);
					}
		
					$this->assign('Acinfolist_check',$AcinfoList_check);
					$this->assign('Admin_check',$AcinfoList_check);
				}else {
					//$AcinfoList = $AcinfoModel->where("ac = "."'".$acauthorid."'")->select();
					$AcinfoList = $AcinfoModel->select();
					foreach($AcinfoList as $key => $value) {
						if($AcinfoList[$key]['acaclow']==1) {
							$AcinfoList[$key]['acaclow']="已审核";
						}else{
							$AcinfoList[$key]['acaclow']="未审核";
						}
					}
				}
				
			$TypeModel = D("actype");
			$Typeinfolist = $TypeModel->select();
				
			$this->assign('Acinfolist',$AcinfoList);
			$this->assign('Typeinfolist',$Typeinfolist);
			$this->assign('Outinfolist',$OutinfoList);
			$this->display();
		}
		else {
			$this->login();
		}
	}
	
	public function login() {
		$this->display("login");
	}
	
	public function get_acinfo() {
		$AcinfoModel = D("Acinfo");
		$Acinfo = $AcinfoModel->where("acid = "."'".$_POST['id']."'")->find();
		$Acinfo['actime'] = date("Y-m-d",$Acinfo['actime']);
		$Acinfo['acstart'] = date("Y-m-d",$Acinfo['acstart']);
		$Acinfo['acend'] = date("Y-m-d",$Acinfo['acend']);
		//$Acinfo['actext'] = strip_tags($Acinfo['actext']);
		echo json_encode($Acinfo);
	}
	public function delete_acinfo() {
		$AcinfoModel = D("Acinfo");
		if($AcinfoModel->where("acid = "."'".$_POST['id']."'")->delete()) {
			$result = array("res" => "ok");
			echo json_encode($result);
		}
		else {
			$result = array("res" => "fail");
			$this->redirect('Admin/index',0,0,"");
		}
	}
	
	public function registe () {
		$this->display();
	}
	public function reg_process() {
		$AdminModel = D("admin");
		if(!($_POST['name']&&$_POST['pwd1']&&$_POST['checkinfo']&&$_POST['club']&&$_POST['phone'])) {
			$this->redirect('Admin/registe',0,3,'请补完注册信息！！');
		}
		$result = $AdminModel->where('name = '."'".$_POST['name']."'")->select();
		if($result) {
			$this->redirect('Admin/registe',0,3,'该用户已经存在，请重新注册！！');
		}
		if($_POST['pwd1']!=$_POST['pwd1']) {
			$this->redirect('Admin/registe',0,3,'两次密码不一致，请重新注册！！');
		}
		/*date_default_timezone_set('PRC');//中国时区
   	 $D=date("YmdHis");//时间戳
   	 $filetype=substr(strrchr($_FILES['img']['name'],"."),1);//获取文件后缀名
   	 $newname=$D.".".$filetype; //文件新名字
 
    	 move_uploaded_file($_FILES['img']['tmp_name'], "../../../Uploadfiles/".$newname);//移动文件到指定文件夹uploads；
		*/
		$data = $AdminModel->create();
		$data['name'] = $_POST['name'];
		$data['pwd'] = md5($_POST['pwd1']);
		$data['club'] = $_POST['club'];
		$data['checkinfo'] = $_POST['checkinfo'];
		$data['phone'] = $_POST['phone'];
		$data['checked'] = 0;
		$data['mode'] = 0;
		
		if($AdminModel->add($data)) {
			$result = "注册成功，等待审核成功后可发布活动，去熟悉下系统吧！！";
			session('admin',$data['name']);
			session("mode",$data['mode']);
			$this->redirect('Admin/index',0,4,"<script>alert("."'".$result."'".");</script>");
		}else {
			$this->redirect('Admin/registe',0,3,"亲，出了点问题，再试试吧");
		}
}
	

	public function login_post() {
		$AdminModel = D("admin");
		$name = $_POST['name'];
		$pwd = $_POST['pwd'];  
		$Admin = $AdminModel->where("name = "."'".$name."'")->find();
		if($Admin) {
			if($Admin['pwd'] == md5($_POST['pwd'])) {
				session("admin",$Admin['name']);
				session("mode",$Admin['mode']);
				
				$this->redirect('Admin/index',0,3,'<script>document.write("<p>登陆成功,欢迎您'.$Admin['name'].',页面正在跳转...</p>");</script>'); 
			}
            else {
                $this->redirect('Admin/login',0,1,'<script>alert("信息错误！！！");</script>'); 
            }
		
		}
        else {
                $this->redirect('Admin/login',0,1,'<script>alert("信息错误！！！");</script>'); 
        }
	}
	
	public function insert() {
		$AdminModel = D("admin");
		$name=session('admin');
		$Admin = $AdminModel->where("name = "."'".$name."'")->getField("checked");
		if($Admin==0) {
			$this->redirect('Admin/index',0,3,'你还没有通过审核，不能发布活动！！');
		}
	if(session('?admin')) {
		$name=session('admin');
		$AdminModel = D('admin');
		$Admininfolist = $AdminModel->where("name = "."'".$name."'")->find();
		$acauthorid = $Admininfolist['id'];
		$Acinfo = D("Acinfo");
		
		$data = $Acinfo->create();
		$data['acstart'] = strtotime($data['acstart']);
		$data['acend'] = strtotime($data['acend']);
		$data['actime'] = strtotime($data['actime']);
		$data['ac'] = $acauthorid;
		if($data['acid'] == '') {
				if($Acinfo->add($data)) {
                    $this->redirect('Admin/index',0,2,'发布成功，等待审核。');
                }
                else {
                    $result = array("res" => "bad");
                }
                //set_time_limit(18000);
                //include("PHPFetion.class.php");
                $UinfoModel = D("Uinfo");
                $UListWithPhone = $UinfoModel->where("uphone != ' '")->select();
                foreach($UListWithPhone as $key => $value) {
                    $phoneList .= $UListWithPhone[$key]['uphone'].',';
                }
                $phoneList = substr($phoneList,0,strlen($phoneList)-1);
                //$PHPFetion = new PHPFetion("手机号","飞信密码",4);
                $message = 'e瞳在线订票提醒您,'."'".$data['actitle']."'".'即将在'.date("Y年m月d日",$data['actime']).'举行,如有兴趣,请登录http://eeyes.net/ticonline 进行预定入场门票,祝您愉快.';
				//$PHPFetion->send($phoneList,$message);
                $fp  = fopen('ticNotice.txt',"a+");
                fwrite($fp,$phoneList.']]]]]'.$message.'}}}}}');
                fclose($fp);
                echo json_encode($result);
		}
		else {
			$Acinfo->save($data);
			$this->redirect('Admin/index',0,3,'修改成功');
		
		}
		}
		else {
		$this->login();
		}
	}
    
    public function insert_() {
        
        $result = array("res" => $_POST['actitle']);
        echo json_encode($result);
    
    }
	/*private function download_file($fileName){
        if (file_exists($fileName)){ 
        header('Content-Description: File Transfer'); 
        header('Content-Type: application/octet-stream'); 
        header('Content-Disposition: attachment; filename='.basename($fileName)); 
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0'); 
        header('Pragma: public'); 
        header('Content-Length:'. filesize($fileName)); 
        //ob_clean(); 
        //flush();
        //readfile($fileName);
        $content = file_get_contents($fileName);
        echo $content;
        exit;
        }
    }*/
    
    public function export(){
        $acId = $_POST['dataName'];
        $AcinfoModel = D("Acinfo");
		$Acinfo = $AcinfoModel->where("acid = "."'".$acId."'")->find();
		$Acinfo['actime'] = date("Y-m-d",$Acinfo['actime']);
		$nowTime = date("Y-m-d",time());
        $sql = "SELECT t.acid,t.uid,u.unum,u.uname FROM `ticinfo` as t LEFT JOIN `uinfo` as u ON t.uid = u.uid WHERE t.acid = ". $Acinfo['acid'];
        $ticInfo = $AcinfoModel->query($sql);
        //$handle = fopen("http://piao.eeyes.net/file.txt", "wb");
        //$str = $Acinfo['acid'] . " " . $Acinfo['actitle'] . " " . $Acinfo['actime'] . " " . 
        //$nowTime . " " . $Acinfo['aclimit'] . " " . $Acinfo['acnow'] . " " . "0\r\n";
        //$str = mb_convert_encoding($str,"GB2312","utf-8");
        //echo $str;
        //fwrite($handle,$str);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=file.txt');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public'); 
        foreach($ticInfo as $key => $value){
            $str =$value['uname']." ".$value['unum']  . "\r\n";
            $str = mb_convert_encoding($str,"GB2312","utf-8");
            //$str = iconv('utf-8','gb2312',$str);
            echo $str;
            //fwrite($handle,$str);
        }
        //fclose($handle);
        //$this->download_file("http://piao.eeyes.net/file.txt");
        
    }
   /* public function download_exe(){
        $this->download_file(APP_PATH . "/xbsura.exe");
    }*/
	public function logout() {
		session('admin',NULL);
		$this->redirect('Admin/index',0,3,'<script>document.write("<p>您已成功退出</p>");</script>'); 
	}
}
?>
