<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2018/11/13
 * Time: 14:32
 */

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\UserLoginLog;
use Illuminate\Http\Request;
class IndexController extends Controller
{
	/**
	 * 首页
	 * Created by：Mp_Lxj
	 * @date 2018/11/15 8:51
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
	 */
	public function index()
	{
		return view('web.project.select');
	}

	/**
	 * 退出登录
	 * Created by：Mp_Lxj
	 * @date 2018/11/15 8:53
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function loginOut(Request $request)
	{
		$request->session()->forget('user');
		return redirect()->route('web.login');
	}

	/**
	 * 修改密码
	 * Created by：Mp_Lxj
	 * @date 2018/11/16 10:15
	 * @param Request $request
	 * @return mixed
	 */
	public function passwordUpdate(Request $request)
	{
		$param = $request->all();
		$user = session('user');
		if(password_verify($param['ypwd'],$user->password)){
			$user->password = password_hash($param['password'],PASSWORD_DEFAULT);
			$user->save();
			$request->session()->forget('user');
			return returnCode(1);
		}else{
			return returnCode(0,'密码输入错误');
		}
	}

	/**
	 * 登录历史记录
	 * Created by：Mp_Lxj
	 * @date 2018/11/16 10:17
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
	 */
	public function loginHistory()
	{
		return view('web.history.login');
	}

	/**
	 * 获取登录历史记录
	 * Created by：Mp_Lxj
	 * @date 2018/11/16 10:39
	 * @return mixed
	 */
	public function getLoginHistory()
	{
		$UserLoginLog = new UserLoginLog();
		$log = $UserLoginLog->getLoginLog()->toArray();
		if($log['data']){
			$result['total'] = $log['total'];
			$result['history'] = $log['data'];
			$result['page_count'] = $log['last_page'];
			return returnCode(1,'',$result);
		}else{
			return returnCode(0);
		}
	}
}