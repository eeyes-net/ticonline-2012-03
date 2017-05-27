<?php
include "PHPFetion.class.php";
//while(1){
    $str = file_get_contents('sendMessage.txt');
    if($str != '') {
        $messageArray = explode("|",$str);
        $PHPFetion = new PHPFetion("手机号","密码",4);
        foreach($messageArray as $key => $value) {
            $return = $PHPFetion->send("接收者手机号",$value);
            $handle = fopen("test.txt","a+b");
            fwrite($handle,$return);
            fclose($handle);
        }
        $newFileName = time().'.txt';
        rename('sendMessage.txt',$newFileName);
        unlink('sendMessage.txt');
        $PHPFetion->__destruct();
    }
    
    //sleep(60);    //每五分钟执行一次
//}
?>
