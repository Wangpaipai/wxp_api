<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2018/11/13
 * Time: 10:41
 */

if(!function_exists('returnCode')){
	/**
	 * 自定义返回参数
	 * Created by：Mp_Lxj
	 * @date 2018/11/13 10:49
	 * @param $code
	 * @param string $msg
	 * @param array $data
	 * @return mixed
	 */
	function returnCode($code,$msg = '',$data = [])
	{
		$arr = [
			0 => ['status' => 0,'msg' => $msg,'data' => $data],
			1 => ['status' => 1,'msg' => $msg,'data' => $data]
		];

		return $arr[$code];
	}
}

if(!function_exists('verifyEmail')){
	/**
	 * 验证字符串是否是邮箱
	 * Created by：Mp_Lxj
	 * @date 2018/11/13 13:43
	 * @param $str
	 * @return bool
	 */
	function verifyEmail($str){
		//@前面的字符可以是英文字母和._- ，._-不能放在开头和结尾，且不能连续出现
		$pattern = '/^[a-z0-9]+([._-][a-z0-9]+)*@([0-9a-z]+\.[a-z]{2,14}(\.[a-z]{2})?)$/i';
		if(preg_match($pattern,$str)){
			return true;
		}else{
			return false;
		}
	}
}

if(!function_exists('active')){
	/**
	 * 检测当前路由和输入路由是否一致，返回默认值
	 * Created by：Mp_Lxj
	 * @date 2018/11/15 16:18
	 * @param $name
	 * @param string $active
	 * @return string
	 */
	function active($name,$active = 'active')
	{
		$routeName = Route::currentRouteName();
		if($routeName == $name){
			return $active;
		}else{
			return '';
		}
	}
}

