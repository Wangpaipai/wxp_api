<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\UserLoginLog;
use Illuminate\Http\Request;
use Validator;
class LoginController extends Controller
{
	/**
	 * 登录页面
	 * Created by：Mp_Lxj
	 * @date 2018/11/13 10:22
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
	 */
	public function login()
	{
		return view('web.login');
	}

	/**
	 * 注册页面
	 * Created by：Mp_Lxj
	 * @date 2018/11/13 10:22
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
	 */
	public function register()
	{
		return view('web.register');
	}

	/**
	 * 用户注册
	 * Created by：Mp_Lxj
	 * @date 2018/11/13 11:16
	 * @param Request $request
	 * @return mixed
	 */
	public function registerCheck(Request $request)
	{
		try{
			$this->validate($request,[
				'code' => 'required|captcha'
			]);
		}catch(\Exception $e){
			return returnCode(0,'验证码错误');
		}

		$User = new User();
		$param = $request->all();
		unset($param['code']);
		unset($param['repassword']);

		//检测用户名是否被占用
		$nameCount = $User->isExistence(['name' => $param['name']]);
		if($nameCount){
			return returnCode(0,'用户名已存在');
		}
		//检测邮箱是否已存在
		$emailCount = $User->isExistence(['email' => $param['email']]);
		if($emailCount){
			return returnCode(0,'该邮箱已被注册');
		}

		$param['password'] = password_hash($param['password'], PASSWORD_DEFAULT);
		$user = $User->create($param);
		if($user){
			return returnCode(1,'注册成功');
		}else{
			return returnCode(0,'注册失败');
		}
	}

	/**
	 * 检测用户是否已存在
	 * Created by：Mp_Lxj
	 * @date 2018/11/13 11:42
	 * @param Request $request
	 * @return mixed
	 */
	public function isExistence(Request $request)
	{
		$param = $request->all();
		$User = new User();
		$count = $User->isExistence($param);
		if($count){
			return returnCode(0);
		}else{
			return returnCode(1);
		}
	}

	/**
	 * 用户登录
	 * Created by：Mp_Lxj
	 * @date 2018/11/13 14:49
	 * @param Request $request
	 * @return mixed
	 */
	public function loginValidate(Request $request)
	{
		$param = $request->all();
		$User = new User();
		//检测验证码
		$validate = Validator::make($param,[
			'code' => 'required|captcha'
		]);

		if($validate->fails()){
			return returnCode(0,'验证码错误');
		}

		//判断当前登录用户名类型
		if(verifyEmail($param['username'])){
			$type = 'email';
		}else{
			$type = 'name';
		}

		$userData = $User->getUserData($param,$type);
		if(!$userData){
			return returnCode(0,'帐号、密码错误!');
		}

		//检测密码是否正确
		if(password_verify($param['password'],$userData->password)){
			session(['user' => $userData]);
			$UserLoginLog = new UserLoginLog();
			$UserLoginLog->ip = $request->getClientIp();
			$UserLoginLog->uid = $userData->id;
			$UserLoginLog->save();
			return returnCode(1,'登录成功');
		}else{
			return returnCode(0,'帐号、密码错误!');
		}
	}
}