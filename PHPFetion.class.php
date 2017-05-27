<?php
/**
 * PHP飞信发送类,PHP飞信添加好友类,php批量发送飞信类
 @author quanhengzhuang <blog.quanhz.com>
 @author Baby <QQ:190458588>
*/ 
class PHPFetion 
{

	/**
	 * 发送者手机号
	 * @param string
	 */
	protected $_mobile;

	/**
	 * 飞信密码
	 * @param string
	 */
	protected $_password;
	
	/**
	 * Cookie字符串
	 * @var string
	 */
	protected $_cookie = '';
	
	/**
	 * 登陆状态
	 * @param string  1,2,3,4分别对应在线,忙碌,离开,隐身.
	 */
	protected $_loginState = '1';
	
	/**
	 * 构造函数
	 * @param string $mobile 手机号(登录者)
	 * @param string $password 飞信密码
	 * @param string $loginState 登录状态,1,2,3,4分别对应在线,忙碌,离开,隐身.
	 */
	public function __construct($mobile, $password, $loginState = 4)
	{
		if($mobile === '' || $password === '' || $loginState === '')
		{
			if( ! ($loginState > 1 && $loginState < 4) )
			{
				return false;
			}
		}
		
		$this->_mobile = $mobile;
		$this->_password = $password;
		$this->_loginState = $loginState;
		
		$this->_login();
	}
	
	/**
	 * 析构函数
	 */
	public function __destruct()
	{
		$this->_logout();
	}
	
	/**
	 * 登录
	 * @return string
	 */
	protected function _login()
	{
		$uri = '/im/login/inputpasssubmit1.action';
		
		//在以下参数中,loginstatus代表登陆状态,1-4分别为在线,忙碌,离开,隐身
		$data = 'm='.$this->_mobile.'&pass='.urlencode($this->_password).'&loginstatus='.$this->_loginState;

		$result = $this->_postWithCookie($uri, $data);
		
		// 解析Cookie
		preg_match_all('/.*?\r\nSet-Cookie: (.*?);.*?/si', $result, $matches);
		if(isset($matches[1]))
		{
			$this->_cookie = implode('; ', $matches[1]);
		}

		return $result;
	}

	/**
	 * 向指定的手机号发送飞信
	 * @param string $mobile 手机号(接收者)
	 * @param string $message 短信内容
	 * 群发时号码用逗号分隔
	 * @return string
	 */
	public function send($recipient, $message)
	{
		if($message === '')
		{
			return '';
		}

		// 判断是给自己发还是给好友发,发给自己的方法特殊处理
		if($recipient == $this->_mobile)
		{
			return $this->_toMyself($message);
		}
		
		else
		{
			//判断是否存在多个收信人,同样需要处理是否发给自己的情况
			if(strstr($recipient,','))
			{
				$recipientArray = explode(',',$recipient);
				$recipientArray = array_unique($recipientArray);
				if(in_array($this->_mobile,$recipientArray))
				{
					$myKeyArray = array_keys($recipientArray,$this->_mobile);
					$myKey = $myKeyArray[0];
					unset($recipientArray[$myKey]);
					array_values($recipient);
					$this->_toMyself($message);
				}
				
				
				foreach($recipientArray as $key => $value)
				{
					$uid = $this->_getUid($value);
					$this->_toUid($uid, $message);
				}
			}
			
			else
			{
				$uid = $this->_getUid($recipient);
				$this->_toUid($uid, $message);
			}
		}
	}
	/**
	 * 获取飞信ID
	 * @param string $recipient 手机号
	 * @return string
	 */
	protected function _getUid($recipient) 
	{
		$uri = '/im/index/searchOtherInfoList.action';
		$data = 'searchText='.$recipient;
		
		$result = $this->_postWithCookie($uri, $data);
		
		// 匹配
		preg_match('/toinputMsg\.action\?touserid=(\d+)/si', $result, $matches);
		
		return isset($matches[1]) ? $matches[1] : '';
	}
	/**
	 * 向好友发送飞信
	 * @param string $uid 飞信ID
	 * @param string $message 短信内容
	 * @return string
	 */
	protected function _toUid($uid, $message)
	{
		$uri = '/im/chat/sendMsg.action?touserid='.$uid;
		$data = 'msg='.urlencode($message);
		
		$result = $this->_postWithCookie($uri, $data);
		
		return $result;
	}
	
	/**
	 * 添加好友
	 * @param string $type 添加方式,0对应手机号,1对应飞信号
	 * @param string $userAdd 添加人号码
	 * @param string $nickname 我是***,显示我的身份,不要超过5个字符
	 * @return string
	 */
	public function addUser($type = 0,$userAdd = '',$nickName = '')
	{
		if( !($type == 1 || $type == 0) || $userAdd == '' || $nickName== '')
		return false;
		
		$uri = '/im/user/insertfriendsubmit.action';
		$data = 'number='.$userAdd.'&type='.$type.'&buddylist=1'.'&nickname='.$nickName;
		$result = $this->_postWithCookie($uri, $data);
		return $result;
	}
	
	/**
	 * 给自己发飞信
	 * @param string $message
	 * @return string
	 */
	protected function _toMyself($message)
	{
		$uri = '/im/user/sendMsgToMyselfs.action';
		$result = $this->_postWithCookie($uri, 'msg='.urlencode($message));
		
		return $result;
	}
	
	/**
	 * 退出飞信
	 * @return string
	 */
	protected function _logout()
	{
		$uri = '/im/index/logoutsubmit.action';
		$result = $this->_postWithCookie($uri, '');
		
		return $result;
	}
	
	/**
	 * 携带Cookie向f.10086.cn发送POST请求
	 * @param string $uri
	 * @param string $data
	 */
	protected function _postWithCookie($uri, $data)
	{
		$fp = fsockopen('f.10086.cn', 80);
		fputs($fp, "POST $uri HTTP/1.1\r\n");
		fputs($fp, "Host: f.10086.cn\r\n");
		fputs($fp, "Cookie: {$this->_cookie}\r\n");
		fputs($fp, "Content-Type: application/x-www-form-urlencoded\r\n");
		fputs($fp, "Content-Length: ".strlen($data)."\r\n");
		fputs($fp, "Connection: close\r\n\r\n");
		fputs($fp, $data);

		$result = '';
		while(!feof($fp))
		{
			$result .= fgets($fp);
		}

		fclose($fp);

		return $result;
	}

}
