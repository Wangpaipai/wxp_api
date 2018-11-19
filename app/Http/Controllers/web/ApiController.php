<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2018/11/16
 * Time: 10:56
 */

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Model\Project;
use App\Model\ProjectGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\web\traits\ProjectAction;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
	use ProjectAction;
	/**
	 * 项目主页
	 * Created by：Mp_Lxj
	 * @date 2018/11/16 10:57
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
	 */
	public function index(Request $request,$id)
	{
		$this->returnCommon($id);
		return view('web.project.home');
	}

	/**
	 * 项目成员列表页
	 * Created by：Mp_Lxj
	 * @date 2018/11/19 9:05
	 * @param Request $request
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
	 */
	public function group(Request $request,$id)
	{
		$this->returnCommon($id);
		return view('web.project.member');
	}

	/**
	 * 获取项目成员列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/19 10:08
	 * @param Request $request
	 * @return mixed
	 */
	public function getGroup(Request $request)
	{
		$param = $request->all();
		if(!$param['project']){
			return returnCode(0,'项目不存在');
		}

		$group = $this->projectGroup($param['project']);
		if(!$group['is_show']){
			return returnCode('无权限操作此项!');
		}
		$ProjectGroup = new ProjectGroup();
		$member = $ProjectGroup->getMemberList($param['project'])->toArray();
		if($member['data']){
			$result['member'] = $member['data'];
			$result['total'] = $member['total'];
			$result['page_count'] = $member['last_page'];
			return returnCode(1,'',$result);
		}else{
			return returnCode(0);
		}
	}

	/**
	 * 新增项目成员
	 * Created by：Mp_Lxj
	 * @date 2018/11/19 13:57
	 * @param Request $request
	 * @return mixed
	 */
	public function createGroup(Request $request)
	{
		$param = $request->all();
		$ProjectGroup = new ProjectGroup();
		$group = $this->projectGroup($param['project']);
		if(!$group['is_update']){
			return returnCode(0,'无限制操作此项');
		}

		$user = $this->getUsers($param['name']);
		if(!$user){
			return returnCode(0,'用户不存在');
		}
		$count = $ProjectGroup->getUserGroup($user->id,$param['project']);
		if($count){
			return returnCode(0,'改成员已加入或已申请进入此项目');
		}
		$role = $this->paramData($param['role_group']);
		$role['uid'] = $user->id;
		$role['apply'] = $ProjectGroup::APPLY_TRUE;
		$role['project_id'] = $param['project'];
		$res = $ProjectGroup->create($role);
		if($res){
			return returnCode(1);
		}else{
			return returnCode(0,'添加失败,请稍后再试');
		}
	}

	/**
	 * 修改需成员权限
	 * Created by：Mp_Lxj
	 * @date 2018/11/19 14:03
	 * @param Request $request
	 * @return mixed
	 */
	public function updateGroup(Request $request)
	{
		$param = $request->all();

		$group = $this->projectGroup($param['project']);
		if(!$group['is_update']){
			return returnCode(0,'无限制操作此项');
		}

		if(!$param['id']){
			return returnCode(0,'项目不存在');
		}
		$ProjectGroup = new ProjectGroup();
		$role = $this->paramData($param['role_group']);
		DB::beginTransaction();
		try{
			$ProjectGroup->groupRoleUpdate($param,$role);
			DB::commit();
			return returnCode(1,'修改成功');
		}catch(\Exception $e){
			DB::rollBack();
			return returnCode(0,'修改失败');
		}
	}

	/**
	 * 移除项目成员
	 * Created by：Mp_Lxj
	 * @date 2018/11/19 14:54
	 * @param Request $request
	 * @return mixed
	 */
	public function removeGroup(Request $request)
	{
		$param = $request->all();
		$ProjectGroup = new ProjectGroup();

		$group = $this->projectGroup($param['project']);
		if(!$group['is_del']){
			return returnCode(0,'无限制操作此项');
		}

		DB::beginTransaction();
		try{
			$ProjectGroup->groupDel($param['group']);
			DB::commit();
			return returnCode(1,'移除成功');
		}catch(\Exception $e){
			DB::rollBack();
			return returnCode(0,'移除失败,请稍后再试');
		}
	}

}