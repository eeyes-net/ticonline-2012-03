<?php
class IndexAction extends Action {
    
    //初始化信息，获得基本信息
    public function index(){
		$AcinfoModel = D("Acinfo");
		$time = time();
		$acauthorid=1;
		if($_GET['typeid']&&$_GET['typeid']!=0) {
			$AcinfoList = $AcinfoModel->where("acallow = "."'".$acauthorid."'"." and "."typeid = "."'".$_GET['typeid']."'")->limit(4)->order('acid desc')->select();
			$MainText = $AcinfoModel->limit(1)->order('acid desc')->select();
			
			foreach($AcinfoList as $key => $value) {
				$AcinfoList[$key]['actext'] = strip_tags($AcinfoList[$key]['actext']);
				$AcinfoList[$key]['actext'] = str_replace('&nbsp;',"",$AcinfoList[$key]['actext']);
				$actime = explode('-',date("Y-M-d",$AcinfoList[$key]['actime']));
				$AcinfoList[$key]['year'] = $actime[0];
				$AcinfoList[$key]['acmonth'] = $actime[1];
				$AcinfoList[$key]['acday'] = $actime[2];
				if($AcinfoList[$key]['actic']==1) {
					$AcinfoList[$key]['actic']="是";
				}else{
					$AcinfoList[$key]['actic']="否";
				}
			$TypeModel = D("actype");
			$AcinfoList[$key]['type'] = $TypeModel->where("tid= "."'".$AcinfoList[$key]['typeid']."'")->getField("tname");
		}
		}else {
			$AcinfoList = $AcinfoModel->where("acallow = "."'".$acauthorid."'")->limit(20)->order('acid desc')->select();
			$MainText = $AcinfoModel->limit(1)->order('acid desc')->select();
			
			foreach($AcinfoList as $key => $value) {
				$AcinfoList[$key]['actext'] = strip_tags($AcinfoList[$key]['actext']);
				$AcinfoList[$key]['actext'] = str_replace('&nbsp;',"",$AcinfoList[$key]['actext']);
				$actime = explode('-',date("Y-M-d",$AcinfoList[$key]['actime']));
				$AcinfoList[$key]['year'] = $actime[0];
				$AcinfoList[$key]['acmonth'] = $actime[1];
				$AcinfoList[$key]['acday'] = $actime[2];
				if($AcinfoList[$key]['actic']==1) {
					$AcinfoList[$key]['actic']="是";
				}else{
					$AcinfoList[$key]['actic']="否";
				}
       		$TypeModel = D("actype");
       	   $AcinfoList[$key]['type'] = $TypeModel->where("tid= "."'".$AcinfoList[$key]['typeid']."'")->getField("tname");
		}
		}
			$TypeModel = D("actype");
			$Typeinfolist = $TypeModel->select();	
			$this->assign('Typeinfolist',$Typeinfolist);
        $this->assign("uinfoCss","display:none");
        $this->assign("isLogin",'<li><a id="login"  href="__APP__/Index/login">登录</a></li>');
        if(session('?unum')) {
            $this->assign('nowTime',date("Y年m月d日",time()));
            $this->assign('loginName',session('uname'));
            $this->assign("uinfoCss","display:block");
            $this->assign("isLogin",'<li><a href="__APP__/Index/logout">登出</a></li>');
			$this->assign("myhome",'<li class="current first"><a href="__APP__/Index/myhome">我的主页</a></li>');
        }
		$this->assign('Acinfolist',$AcinfoList);
		$MainText[0]['actime'] = date("Y年m月d日",$MainText[0]['actime']);
		$MainText[0]['tic'] = (int)($MainText[0]['aclimit']) - (int)($MainText[0]['acnow']);
		$this->assign('Mainfolist',$MainText);
		$this->display();
	}
    //获取活动信息，通过POST['id']获取
	public function myhome() {
			$TicModel = D("Ticinfo");
			$UinfoModel = M("uinfo");
			$myInfo = $UinfoModel->where("unum = '".session('unum')."'")->find();
			$this->assign("myInfo",$myInfo);
            $sql = "SELECT t.acid,t.uid,ac.actitle,ac.actime FROM ticonline.ticinfo AS t LEFT JOIN ticonline.acinfo AS ac ON t.acid = ac.acid WHERE t.unum = ".session('unum');
            $Ticinfo = $TicModel->query($sql);
            foreach($Ticinfo as $key => $value) {
				if($Ticinfo[$key]['actime'] >= time()) {
					$Ticinfo[$key]['action'] = '<a href="http://piao.eeyes.net/index.php/Index/return_tic/acid/'.$Ticinfo[$key]['acid'].'">有事需要退票...</a>';
				}
				else {
					$Ticinfo[$key]['action'] = '<a>活动已结束</a>';
					//$Ticinfo[$key]['action'] = '<a onClick = "return_tic('.$Ticinfo[$key]['acid'].')">退票正在做...</a>';
				}
                $Ticinfo[$key]['actime'] = date("Y年m月d日",$Ticinfo[$key]['actime']);
            }
			$this->assign('myTic',$Ticinfo);
			$this->assign('myInfo',$myInfo);
			
			$this->assign("isLogin",'<li><a href="__APP__/Index/logout">登出</a></li>');
			$this->assign("myhome",'<li class="current first"><a href="__APP__/Index/myhome">我的主页</a></li>');
			$this->display();
	}
	public function get_acinfo() {
		$id=(int)@$_POST["id"];
		if($id==null || $id<0 || $id> 1000000){
			$id=57;
		}
		$AcinfoModel = D("Acinfo");
		$Acinfo = $AcinfoModel->where("acid = "."'".$id."'")->find();
		$Acinfo['actime'] = date("Y年m月d日",$Acinfo['actime']);
		$Acinfo['acstart'] = date("Y年m月d日H时i分s秒",$Acinfo['acstart']);
		/*var_dump($Acinfo);
		exit;*/
		echo json_encode($Acinfo);
	}
    //获取用户订票信息，session_id获取
    public function get_mydata() {
        if(session('?unum')) {
            $TicModel = D("Ticinfo");
            $sql = "SELECT t.acid,t.uid,ac.actitle,ac.actime FROM ticonline.ticinfo AS t LEFT JOIN ticonline.acinfo AS ac ON t.acid = ac.acid AND t.uid = ".session('uid');
            $Ticinfo = $TicModel->query($sql);
            //$this->assign('nowTime',"ll");
            $this->assign('loginName',session('uname'));
			
            $this->assign('myTic',$Ticinfo);
        }
	}

	//登录处理

		public function login() {
		//统一身份认证
		import('CAS',APP_PATH.'Cas','.php');
		import('config',APP_PATH.'Cas','.php');
		$cas_host = casConfig::get_host();
		$cas_port = casConfig::get_port();
		$cas_context = casConfig::get_context();
		phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
		phpCAS::setNoCasServerValidation();
		phpCAS::forceAuthentication();
		$user = phpCAS::getUser();
        
        //到新版的跳转
        if($_GET['entry']==1){
            header('location:http://ticket.eeyes.net/index.php/Index/login?user='.$user);
            return ;
        }
        

		header("content-type:text/html;charset=utf-8");
        $url = ""; // 出于保密原因此处不提供具体内容
 		$client = new SoapClient($url); // 出于保密原因此处不提供具体内容
 		$auth = md5('cas_app_id' . $user . 'app_token'); // 出于保密原因此处不提供具体内容
		$param = array('auth'=>$auth, // 出于保密原因此处不提供具体内容
								'uid'=>$user);
		$result = $client->__soapCall('getInfoById',array('paramters'=>$param));
		
		//创建学生订票记录
		
		$UserModel = D('Uinfo');
		$userinfo = $UserModel->where("unum ="."'".$result->return->userno."'")->find();
		if(!$userinfo) {
			$data = $UserModel->create();
			$data['uname']=$result->return->username;
			//$data['major']=$result->return->speciality;
			$data['ucollege']=$result->return->dep;
			$data['unum']=$result->return->userno;
			//if($result->return->studenttype=="统考本科生") {
				//$data['ifstu']=1;
			//}else {
				//$data['ifstu']=0;
			//}
			$UserModel->add($data);
			$userinfo['uname']=$data['uname'];
			$userinfo['unum']=$data['unum'];
			$userinfo['uid']=$UserModel->where("unum ="."'".$data['unum']."'")->getField('uid');
				session('unum',$userinfo['unum']);
				session('uname',$userinfo['uname']);
				session('uid',$userinfo['uid']);
		}else {
			session('unum',$userinfo['unum']);
			session('uname',$userinfo['uname']);
			session('uid',$userinfo['uid']);
		}
		$this->redirect('Index/index',0,0,'');
	}
	

	public function logout() {
		import('CAS',APP_PATH.'Cas','.php');
		import('config',APP_PATH.'Cas','.php');
		$cas_host = casConfig::get_host();
		$cas_port = casConfig::get_port();
		$cas_context = casConfig::get_context();
		phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
		phpCAS::forceAuthentication();
		phpCAS::logout();
		session('umun',NULL);
		session('uname',NULL);
		session('uid',NULL);
		$this->redirect('Index/index',0,3,'Byebye');
	}

    //订票/拿票
	
	
	
		public function get_tic() {
			if(session('?unum')) {
				$AcinfoModel = D("Acinfo");
				$acid = $_POST['acid'];
				$Acinfo = $AcinfoModel->where("acid = "."'".$acid."'")->find();
                if($Acinfo['acstart'] < time() && $Acinfo['acend'] > time()) { //在放票时间内与否
                	if ((int)($Acinfo['acnow']) >= (int)($Acinfo['aclimit'])) {  //没票了
                		$returnData = array("returnmsg" => 0,"msg" => "木有票了...");
						echo json_encode($returnData);
						die();
                	}
					//如果还有票
					$ticData['acid'] = $acid;
					$ticData['uid'] = session('uid');
					$ticData['unum'] = session('unum');
					$ticData['actitle'] = $Acinfo['actitle'];
					$ticData['actime'] = $Acinfo['actime'];
					$TicinfoModel = D("Ticinfo");
					//是否已经得到票
					$isGet = $TicinfoModel->where("acid = "."'".$acid."'"." AND uid = "."'".session('uid')."'")->find();
					//已经有票
					if($isGet) {
						$returnData = array("returnmsg" => 0,"msg" => " 貌似你已经领过票了哦，亲~~~");
						echo json_encode($returnData);
						die();
					}
					$insertId = $TicinfoModel->data($ticData)->add();//有错,插不进数据库，能反回int				 
					if($insertId) {		 
						if($AcinfoModel->where("acid = "."'".$acid."'")->setInc("acnow")) {
						  	if ((int)($Acinfo['acnow']) < (int)($Acinfo['aclimit'])-1) {  //没票了
                				$returnData = array("returnmsg" => 0,"msg" => "票已拿到，请刷学生卡进入，谢谢~~~");
								echo json_encode($returnData);
								die();
                			}
                			else{
                				$data['acstate']=0;
                				$AcinfoModel->where("acid = "."'".$acid."'")->data($data)->save();
                				$returnData = array("returnmsg" => 1,"msg" => " 恭喜您拿到最后一张票，请凭学号进入，谢谢~~~");
								echo json_encode($returnData);	
								die();
						  	}
						}
					}
					else{
						$returnData = array("returnmsg" => 0,"msg" => " 真不好意思，系统出错了，没有抢票成功！");
						echo json_encode($returnData);
						die();
					}					
				}
                else {
                    if($Acinfo['acstart'] > time()) {
                        $returnData = array("returnmsg" => 0,"msg" => "放票时间尚未开始，请耐心等待~~~");
                        echo json_encode($returnData);
                        exit;
                    }
                    else {
                        $returnData = array("returnmsg" => 0,"msg" => "放票时间已经结束,谢谢关注,下次加油哦~~~");
                        echo json_encode($returnData);
                        exit;
                    }
                
                }
			}
			else {
				$returnData = array("returnmsg" => 0,"msg" => "亲，先登录哈~~~");
				echo json_encode($returnData);
			}
		}
			
		
	 //退票
		public function return_tic() {
			if(session('?unum')) {
				$AcinfoModel = D("Acinfo");
				$acid = $_GET['acid'];
				$Acinfo = $AcinfoModel->where("acid = "."'".$acid."'")->find();
                if($Acinfo['acstart'] <= time() && $Acinfo['acend'] >= time()) {
					$ticData['acid'] = $acid;
					$ticData['uid'] = session('uid');
					$TicinfoModel = D("Ticinfo");
					$isGet = $TicinfoModel->where("acid = "."'".$acid."'"." AND uid = "."'".session('uid')."'")->find();
					if($isGet) {
						$result = $TicinfoModel->table('ticinfo')->where($ticData)->limit('1')->delete();
						if($result) {
							$ticDec = $AcinfoModel->where("acid = "."'".$acid."'")->setDec("acnow");
							if($ticDec) {
								$returnData = array("returnmsg" => 1,"msg" => " 票已经退掉~~~");
								 $this->redirect('Index/index',0,2,'<h4 style="font-family:微软雅黑;font-size:18px;" align="center">退票成功</h4>'); 
							}
						}
					}
					else {
						$returnData = array("returnmsg" => 0,"msg" => " 貌似你木有领过票哦，亲~~~");
						echo json_encode($returnData);
					}	
				}
                else {
                    if($Acinfo['acstart'] > time()) {
                        $returnData = array("returnmsg" => 0,"msg" => "放票时间尚未开始,谢谢关注,下次加油哦");
                        echo json_encode($returnData);
                        exit;
                    }
                    else {
                        $returnData = array("returnmsg" => 0,"msg" => "退票成功");
                        $this->redirect('Index/index',0,2,'退票成功'); 
                        
                    }
                
                }
			}
			
			else {
				$returnData = array("returnmsg" => 0,"msg" => "先登录哈...");
				echo json_encode($returnData);
			}
		} 

    public function redirectUtf8($msg,$url,$delay) {
        header("Content-type: text/html; charset=utf-8");
        $this->redirect($url,0,$delay,'<script>alert("' . $msg . '");</script>');         
    }
    public function sendSuggest() {
        $this->assign("isLogin",'<li><a id="login" href="#">登录</a></li>');
        if(session('?unum')) {
            $this->assign("isLogin",'<li><a href="__APP__/Index/logout">登出</a></li>');
        }
        $this->display('sendSuggest');
    }
	
	public function changeMyInfo() {
		$data['uname'] = $_POST['uname'];
		$data['unum'] = $_POST['unum'];
		$data['uemail'] = $_POST['uemail'];
		$data['uphone'] = $_POST['uphone'];
		if(session('?unum')) {
			$Umodel = M("uinfo");
			$Umodel->create();
			$Umodel->where("unum = '".session('unum')."'")->save($data);
			echo "信息更新完成";
		}
		else {
			echo "请先登录再进行操作";
		}
	}
	public function suggestPost() {
		$suggestModel = M("suggest");
		$data['suggest'] = $_POST['usuggest'];
        $data['addtime'] = time();
        $this->assign("uinfoCss","display:block");
        $this->assign("isLogin",'<li><a id="login" onClick = "test()" href="#">登录</a></li>');
        if(session('?unum')) {
            $data['unum'] = session('unum');
            $uname = session('uname');
            $this->assign("isLogin",'<li><a href="__APP__/Index/logout">登出</a></li>');
        }
        else {
            $data['unum'] = '匿名';
        }
        
        if($suggestModel->add($data)) {
			//set_time_limit(0);
            //include("PHPFetion.class.php");
            //$PHPFetion = new PHPFetion("手机号","飞信密码",4);
            $message = "交大在线订票建议:来自"."'".$uname."',内容为'".$data['suggest']."',时间是".date("Y年m月d日H时i分s秒",$data['addtime']);
            //$result = $PHPFetion->send("目标手机号",$message);
            //if(strpos("成功",$result)) {
                $handle = fopen("sendMessage.txt","a+b");
                fwrite($handle,$message.'|');
                fclose($handle);
                $result = array("res"=>"信息提交成功,管理员已收到,谢谢");
                echo json_encode($result);
            //}
            //else {
                //$handle = fopen("addUserError.txt","a+b");
                //fwrite($handle,'发送建议'.$data['suggest'].'于'.time().'失败|');
                //fclose($handle);
                //$result = array("res"=>"信息提交成功,问题已经记录,谢谢");
                //echo json_encode($result);
            //}
            
                    
        }
        else {
            $handle = fopen("addUserError.txt","a+b");
            fwrite($handle,'发送建议'.$data['suggest'].'于'.time().'失败|');
            fclose($handle);
            $result = array("res"=>"信息提交失败,问题已记录,如还有问题,请Q190458588");
            echo json_encode($result);
        }

	}
	
	
	public function Type(){
		$tid = (int)@$_POST["tid"];
		if(!isset($tid) || $tid>1000000 || $tid < 0){
			$tid=2;
		}
		$AcinfoModel = D("Acinfo");
		$Acinfo = $AcinfoModel->where("typeid = "."'".$tid."'")->find();
		//var_dump($Acinfo);
		echo json_encode($Acinfo);
		
		
	
	}
	
}
?>
