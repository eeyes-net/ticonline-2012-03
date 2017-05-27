<?php
include "PHPFetion.class.php";
$mysqli = new mysqli("127.0.0.1","ticonline","","ticonline");
//while(1){
    $str = file_get_contents('addUser.txt');
    if($str != '') {
        $messageArray = explode("]]]",$str);
        $PHPFetion = new PHPFetion("手机号","密码",4);
        foreach($messageArray as $key => $value) {
            $userInfo = explode(',',$messageArray[$key]);
            $userId = $userInfo[0];
            $userPhone = $userInfo[1];
            $return = $PHPFetion->addUser(0,$userPhone,'e瞳在线');
            if(strstr($result,"成功") || strstr($result,"已经是")) {
                $sql = "UPDATE `uinfo` SET uphonestate = 1 WHERE uid = ". $userId;
                if($mysqli->query($sql)) {
                    $handle = fopen("addUserPhoneOk.txt","a+b");
                    fwrite($handle,'添加飞信请求成功,数据库写入成功'.$return);
                    fclose($handle);
                }
                else {
                    $handle = fopen("addUserPhoneError.txt","a+b");
                    fwrite($handle,'添加飞信请求成功,数据库写入失败'.$return);
                    fclose($handle);
                }
            }
            else {
                $handle = fopen("addUserPhoneError.txt","a+b");
                fwrite($handle,'添加飞信失败'.$return);
                fclose($handle);
            }
        }
        $newFileName = 'addUser.txt'.time().'.txt';
        rename('addUser.txt',$newFileName);
        unlink('addUser.txt');
        $PHPFetion->__destruct();
    }
    //sleep(60);    //每五分钟执行一次
//}
?>
