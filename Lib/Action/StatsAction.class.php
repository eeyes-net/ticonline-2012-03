<?php
	class StatsAction extends Action{



		public function index(){
			$getacid = (int)$_POST["acid"];

			if(session('?admin')) {

				$Statistcs = array();
					$count = array();
					$ticinfo = D("ticinfo");
					$acinfo = D("acinfo");
					$uinfo = D("uinfo");
					if($getacid){
                	$acid = $acinfo->where("acid = ".$getacid)->field('acid,actitle')->select();
                }else{
                	$acid = $acinfo->field('acid,actitle')->select();
                }
					foreach ($acid as   $value) {
						$num = $ticinfo->where("acid=".$value['acid'])->count();
						$uuid = $ticinfo->where("acid=".$value['acid'])->field('uid')->select();

						//College Percentage/////////////////
					//the database if not designed very well ,so ...sacrifice the performace

					//$CollegePercentage = array("DZXX"=>0,"RJHJ"=>0,"NYDL"=>0,"RW"=>0,"JX"=>0,"DQ"=>0,"SXTJ"=>0,"RJHJ"=>0,"LXY"=>0,"SMXY"=>0,"HXGC"=>0,"GLXY"=>0,"RJXY"=>0,"HTHK"=>0,"YXY"=>0,"JJJR"=>0,"QYKX"=>0,"GGZCGL"=>0,"WYXY"=>0);
					$CollegePercentage = array('电子与信息工程学院'=>0,'人居环境与建筑工程学院'=>0,'能源与动力工程学院'=>0,'人文社会科学学院'=>0,'机械工程学院'=>0,'电气工程学院'=>0,'数学与统计学院'=>0,'理学院'=>0,'生命科学学院'=>0,'化学工程与技术学院'=>0,'软件学院'=>0,'航天航空学院'=>0,'医学院'=>0,'经济与金融学院'=>0,'管理学院'=>0,'前沿科学技术研究院'=>0,'公共政策与管理学院'=>0,'外国语学院'=>0);

					foreach ($uuid as  $values) {
						$college = $uinfo->where("uid = ".$values["uid"])->field("ucollege")->find();
						switch ($college["ucollege"]) {
							case '电子与信息工程学院':
								$CollegePercentage['电子与信息工程学院'] +=1;
								break;
							case '人居环境与建筑工程学院':
								$CollegePercentage['人居环境与建筑工程学院'] +=1;
								break;
							case '能源与动力工程学院':
								$CollegePercentage['能源与动力工程学院'] +=1;
								break;
							case '人文社会科学学院':
								$CollegePercentage['人文社会科学学院'] +=1;
								break;
							case '机械工程学院':
								$CollegePercentage['机械工程学院'] +=1;
								break;
							case '电气工程学院':
								$CollegePercentage['电气工程学院'] +=1;
								break;
							case '数学与统计学院':
								$CollegePercentage['数学与统计学院'] +=1;
								break;
							case '理学院':
								$CollegePercentage['理学院'] +=1;
								break;
							case '生命科学学院':
								$CollegePercentage['生命科学学院'] +=1;
								break;
							case '化学工程与技术学院':
								$CollegePercentage['化学工程与技术学院'] +=1;
								break;
							case '软件学院':
								$CollegePercentage['软件学院'] +=1;
								break;
							case '航天航空学院':
								$CollegePercentage['航天航空学院'] +=1;
								break;
							case '医学院':
								$CollegePercentage['医学院'] +=1;
								break;
							case '经济与金融学院':
								$CollegePercentage['经济与金融学院'] +=1;
								break;
							case '管理学院':
								$CollegePercentage['管理学院'] +=1;
								break;
							case '前沿科学技术研究院':
								$CollegePercentage['前沿科学技术研究院'] +=1;
								break;
							case '公共政策与管理学院':
								$CollegePercentage['公共政策与管理学院'] +=1;
								break;
							case '外国语学院':
								$CollegePercentage['外国语学院'] +=1;
								break;
			
							default:
								break;
						}
						
					}

						foreach ($CollegePercentage as $key => $valuess) {

							if($getacid){
							$temp = (round(((int)$valuess/1.0)/$num*100,2));
						}else{
							$temp = (round(((int)$valuess/1.0)/$num*100,2))."%";
						}

						$CollegePercentage["$key"] = $temp;
						
						}


						$present_num = $ticinfo->where("acid = ".$value['acid']." and present = 1")->count();
						$percentage = (round(((int)$present_num/1.0)/$num*100,2))."%";
						$count[$value['acid']] = array('acid'=>$value['acid'],'actitle'=>$value['actitle'],'num'=>$num,'percentage'=>$percentage,'college_percent'=>$CollegePercentage);

						
					}
					

					if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
						echo json_encode($count[$getacid]);
                    }else{
                   	   $this->assign('stats_total_count',$count);
					   $this->display();
					}
					
			}else{
				$this->login();
			}

		}


//个人统计信息查询函数///////////////////////////////

		public function person_stats(){
			if(session('?admin')) {
				$person_stats = array();
				$unum = $this->_post('unum');
				if(strlen($unum)<5 || strlen($unum)>15){
					$unum = "2110501082";
				}
				$ticinfo = D('ticinfo');
				$acinfo = D('acinfo');
				$uinfo = D('uinfo');
				$user_info = $uinfo->where('unum = "'.$unum."\"")->field('uid,uname,unum,ucollege')->find();
				if(!$user_info){
					$this->redirect('Stats/person_stats',0,3,'this user is not registered');
				}
				else{

				$u_tic_info = $ticinfo->where('uid = '.$user_info['uid'])->field('acid,present')->select();
				$total_notpresent_num = $ticinfo->where('uid = '.$user_info['uid'].' and present = 0')->count();
				$total_present_num = $ticinfo->where('uid = '.$user_info['uid'].' and present = 1')->count();
				$total = (int)$total_notpresent_num+(int)$total_present_num;
				foreach ($u_tic_info as $value) {
					$actitle = $acinfo->where('acid = '.$value['acid'])->field('actitle')->find();
					$person_stats[$value['acid']] = array('acid'=>$value['acid'],'actitle'=>$actitle["actitle"],'present'=>$value['present']);
				}


			
				$user_info['total'] = $total;
				$user_info['totalnotpresent'] = $total_notpresent_num;
				$user_info['totalpresent'] = $total_present_num;

				$this->assign('user_info',$user_info);
				$this->assign('person_stats',$person_stats);

				$this->display();
			}

			}else{

				$this->login();

			}

		}


	/////handle the post file data and update the database	

		public function import(){
			
			
			if(session('?admin')) {
				$file = $_FILES["filename"]["tmp_name"];
				$acid = (int)$_POST["acid"];
				if(!$acid || !$file){
					$this->redirect('Stats/index',0,3,'请选择文件！');
				}else{
					try{
						$uinfo = D('uinfo');
						$ticinfo = D('ticinfo');
						$rows = file($file);
						foreach ($rows as $key => $value) {
							$unum = rtrim($value);
							$uid = $uinfo->where('unum = "'.$unum."\"")->field('uid')->find();
							//var_dump($uid);
							$data["present"] = 1;
							$ticinfo->where('acid='.$acid.' and uid='.$uid["uid"])->save($data);

						}

					}catch(Exception $e){
						$this->redirect('Stats/index',0,3,'error2');
					}

					$this->redirect('Stats/index',0,3,'yes');
				}

			}else{
				$this->login();
			}


		}




		public function login(){
			$this->redirect('Admin/index',0,3,'请登录');
		}






	}