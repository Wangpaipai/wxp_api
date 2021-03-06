<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2018/11/13
 * Time: 15:47
 */

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Model\Project;
use App\Model\ProjectApi;
use App\Model\ProjectApiLog;
use App\Model\ProjectGroup;
use App\Model\ProjectModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\web\traits\ProjectAction;

class ProjectController extends Controller
{
	use ProjectAction;
	/**
	 * 添加项目
	 * Created by：Mp_Lxj
	 * @date 2018/11/14 11:06
	 * @param Request $request
	 * @return mixed
	 */
	public function projectCreate(Request $request)
	{
		$Project = new Project();
		$param = $request->all();
		foreach($param['param'] as &$value){
			$value = json_decode($value,true);
		}
		$user = session('user');
		$param['uid'] = $user->id;
		$param['param'] = serialize($param['param']);
		$project = $Project->create($param);
		if($project){
			$project->param = unserialize($project->param);
			return returnCode(1,'添加成功',$project);
		}else{
			return returnCode(0,'添加失败');
		}
	}

	/**
	 * 获取项目列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/14 11:36
	 * @return mixed
	 */
	public function projectList()
	{
		$Project = new Project();
		$ProjectGroup = new ProjectGroup();
		$project = $Project->getProjectList();
		$group = $ProjectGroup->getProjectList();
		return returnCode(1,'',['project' => $project,'group' => $group]);
	}

	/**
	 * 修改项目信息
	 * Created by：Mp_Lxj
	 * @date 2018/11/14 15:06
	 * @param Request $request
	 * @return mixed
	 */
	public function projectUpdate(Request $request)
	{
		$param = $request->all();
		$Project = new Project();
		$ProjectGroup = new ProjectGroup();
		$user = session('user');
		if($user->id != $param['uid']){
			$role = $ProjectGroup->getProjectGroupFind($user->id,$param['id']);
			if(!$role && !$role->is_update){
				return returnCode(0,'无权限操作此项');
			}
		}
		foreach($param['param'] as &$value){
			$value = json_decode($value,true);
		}
		$project = $Project->getProjectData($param['id']);
		$project->name = $param['name'];
		$project->brief = $param['brief'];
		$project->param = serialize($param['param']);
		$project->is_show = $param['is_show'];
		$result = $project->save();
		if($result){
			return returnCode(1,'修改成功');
		}else{
			return returnCode(0,'修改失败');
		}
	}

	/**
	 * 获取修改的项目参数
	 * Created by：Mp_Lxj
	 * @date 2018/11/14 14:45
	 * @param Request $request
	 * @return mixed
	 */
	public function getProjectData(Request $request)
	{
		$param = $request->all();
		$Project = new Project();
		$result = $Project->getProjectData($param['project_id']);

		if($result){
			$user = session('user');
			$result->param = unserialize($result->param);
			if($result->uid == $user->id){
				return returnCode(1,'',$result);
			}else{
				$ProjectGroup = new ProjectGroup();
				$role = $ProjectGroup->getProjectGroupFind($user->id,$param['project_id']);
				if($role && $role->is_update){
					return returnCode(1,'',$result);
				}else{
					return returnCode(0,'无权限操作此项');
				}
			}
		}else{
			return returnCode(0,'项目不存在');
		}
	}

	/**
	 * 删除项目
	 * Created by：Mp_Lxj
	 * @date 2018/11/14 15:53
	 * @param Request $request
	 * @return mixed
	 */
	public function projectRemove(Request $request)
	{
		$param = $request->all();
		$Project = new Project();
		$ProjectGroup = new ProjectGroup();
		$ProjectModel = new ProjectModel();
		$ProjectApi = new ProjectApi();
		$ProjectApiLog = new ProjectApiLog();
		$project = $Project->getProjectData($param['id']);
		$user = session('user');

		if(!password_verify($param['password'],$user->password)){
			return returnCode(0,'密码错误');
		}

		if($user->id != $project->uid){
			$role = $ProjectGroup->getProjectGroupFind($user->id,$param['id']);
			if(!$role && !$role->is_del){
				return returnCode(0,'无权限操作此项');
			}
		}
		DB::beginTransaction();
		try{
			$Project->projectDel($param['id']);
			$ProjectModel->projectModelDel($param['id']);
			$ProjectGroup->projectGroupDel(['project_id' => $param['id']]);
			$ProjectApi->projectApiDel($param['id']);
			$ProjectApiLog->projectApiLogDel($param['id']);
			DB::commit();
			return returnCode(1,'删除成功');
		}catch(\Exception $e){
			DB::rollBack();
			return returnCode(0,'删除失败');
		}
	}

	/**
	 * 搜索项目页面
	 * Created by：Mp_Lxj
	 * @date 2018/11/15 11:39
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
	 */
	public function search()
	{
		return view('web.project.search');
	}

	/**
	 * 搜索、筛选
	 * Created by：Mp_Lxj
	 * @date 2018/11/15 14:26
	 * @param Request $request
	 * @return mixed
	 */
	public function searchRequest(Request $request)
	{
		$param = $request->all();
		$Project = new Project();
		$ProjectGroup = new ProjectGroup();
		//获取可被搜索的项目列表
		$project = $Project->searchProject($param);
		$project = $project->toArray();
		//是否存在数据
		if($project['data']){
			$result['total'] = $project['total'];
			$result['page_count'] = $project['last_page'];
			$user = session('user');
			//查看当前用户在项目的地位  1创建者  2申请中  3 参与者 4待加入
			foreach($project['data'] as &$value){
				if($value['uid'] == $user->id){
					$value['status'] = 1;
				}else{
					$group = $ProjectGroup->getUserGroup($user->id,$value['id']);
					if($group){
						switch($group->apply){
							case 1:
								$value['status'] = 2;
								break;
							case 2:
								$value['status'] = 3;
								break;
							default:
								$value['status'] = 4;
						}
					}else{
						$value['status'] = 4;
					}
				}
			}
			$result['project'] = $project['data'];
			return returnCode(1,'',$result);
		}else{
			return returnCode(0);
		}
	}

	/**
	 * 提交申请
	 * Created by：Mp_Lxj
	 * @date 2018/11/15 15:43
	 * @param Request $request
	 * @return mixed
	 */
	public function searchApply(Request $request)
	{
		$param = $request->all();
		$ProjectGroup = new ProjectGroup();
		$user = session('user');
		$group = $ProjectGroup->getGroupCount($param['project_id'],$user->id);
		if($group){
			returnCode(0,'不可重复申请');
		}else{
			$ProjectGroup->project_id = $param['project_id'];
			$ProjectGroup->uid = $user->id;
			$result = $ProjectGroup->save();
			if($result){
				return returnCode(1,'提交申请成功');
			}else{
				return returnCode(1,'提交申请失败');
			}
		}
	}

	/**
	 * 申请列表页
	 * Created by：Mp_Lxj
	 * @date 2018/11/15 16:46
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
	 */
	public function applyList()
	{
		return view('web.apply.index');
	}

	/**
	 * 获取项目申请列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/16 8:55
	 * @param Request $request
	 * @return mixed
	 */
	public function getApplyList(Request $request)
	{
		$param = $request->all();
		$ProjectGroup = new ProjectGroup();
		$group = $ProjectGroup->getGroupApply($param)->toArray();
		if($group['data']){
			$result['total'] = $group['total'];
			$result['apply'] = $group['data'];
			$result['page_count'] = $group['last_page'];
			return returnCode(1,'',$result);
		}else{
			return returnCode(0);
		}
	}

	/**
	 * 更新申请状态
	 * Created by：Mp_Lxj
	 * @date 2018/11/16 9:34
	 * @param Request $request
	 * @return mixed
	 */
	public function applyUpdate(Request $request)
	{
		$param = $request->all();
		$ProjectGroup = new ProjectGroup();
		if(!in_array($param['apply'],[0,2])){
			return returnCode(0,'状态错误');
		}
		if(!$param['group_id']){
			return returnCode(0,'项目不存在');
		}
		$result = $ProjectGroup->applyUpdate($param);
		if($result){
			return returnCode(1,'操作成功');
		}else{
			return returnCode(0,'操作失败，请稍后再试');
		}
	}

	/**
	 * 退出项目
	 * Created by：Mp_Lxj
	 * @date 2018/11/16 10:11
	 * @param Request $request
	 * @return mixed
	 */
	public function applyOut(Request $request)
	{
		$param = $request->all();
		$ProjectGroup = new ProjectGroup();
		if(!$param['project_id']){
			return returnCode(0,'项目不存在');
		}
		$result = $ProjectGroup->applyOut($param['project_id']);
		if($result){
			return returnCode(1,'退出成功');
		}else{
			return returnCode(0,'退出失败,请稍后再试');
		}
	}

	/**
	 * 获取项目成员列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/21 15:30
	 * @param Request $request
	 * @return mixed
	 */
	public function memberList(Request $request)
	{
		$param = $request->all();

		$group = $this->projectGroup($param['project_id']);
		if(!$group['is_give']){
			return returnCode(0,'无权限操作此项');
		}

		$ProjectGroup = new ProjectGroup();
		$list = $ProjectGroup->getGroupList($param['project_id']);
		if($list->count()){
			return returnCode(1,'',$list);
		}else{
			return returnCode(0,'此项目下暂无其他成员');
		}
	}

	/**
	 * 转让项目
	 * Created by：Mp_Lxj
	 * @date 2018/11/21 15:48
	 * @param Request $request
	 * @return mixed
	 */
	public function giveProject(Request $request)
	{
		$param = $request->all();

		if(!password_verify($param['password'],session('user')->password)){
			return returnCode(0,'密码错误');
		}

		$group = $this->projectGroup($param['project_id']);
		if(!$group['is_give']){
			return returnCode(0,'无权限操作此项');
		}

		$ProjectGroup = new ProjectGroup();
		$Project = new Project();
		DB::beginTransaction();
		try{
			$Project->projectGive($param);
			$ProjectGroup->projectGroupDel(['uid' => $param['uid'],'project_id' => $param['project_id']]);
			DB::commit();
			return returnCode(1,'z转让成功');
		}catch(\Exception $e){
			DB::rollBack();
			return returnCode(0,'转让失败');
		}
	}
}