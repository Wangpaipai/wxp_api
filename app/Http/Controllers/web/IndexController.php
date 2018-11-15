<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2018/11/13
 * Time: 14:32
 */

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
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
}