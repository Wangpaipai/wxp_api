<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2018/11/22
 * Time: 11:37
 */

namespace App\Http\Controllers\admin;

use App\Model\Project;
use App\Model\ProjectGroup;
use App\Model\User;
use App\Model\UserLoginLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
	/**
	 * 用户列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/22 11:58
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
	 */
	public function index()
	{
		return view('admin.user.index');
	}

	/**
	 * 获取用户列表数据
	 * Created by：Mp_Lxj
	 * @date 2018/11/22 11:58
	 * @param Request $request
	 * @return mixed
	 */
	public function userList(Request $request)
	{
		$param = $request->all();
		$User = new User();
		$Project = new Project();
		$ProjectGroup = new ProjectGroup();
		$list = $User->getUserList($param)->toArray();

		if(!$list['total']){
			return returnCode(0);
		}
		$res['total'] = $list['total'];
		$res['page_count'] = $list['last_page'];
		$res['member'] = $list['data'];

		foreach($res['member'] as &$value){
			$value['project_count'] = $ProjectGroup->groupCount(['uid'=>$value['id']]);
			$value['my_project'] = $Project->getProjectCount(['uid'=>$value['id']]);
		}
		return returnCode(1,'',$res);
	}

	/**
	 * 登录历史记录
	 * Created by：Mp_Lxj
	 * @date 2018/11/22 13:23
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
	 */
	public function history()
	{
		return view('admin.history.login');
	}

	/**
	 * 登录历史列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/22 13:38
	 * @param Request $request
	 * @return mixed
	 */
	public function historyList(Request $request)
	{
		$param = $request->all();
		$UserLoginLog = new UserLoginLog();
		$list = $UserLoginLog->historyList($param)->toArray();

		if(!$list['total']){
			return returnCode(0);
		}
		$res['total'] = $list['total'];
		$res['page_count'] = $list['last_page'];
		$res['history'] = $list['data'];
		return returnCode(1,'',$res);
	}
}