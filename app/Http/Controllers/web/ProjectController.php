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

class ProjectController extends Controller
{
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
			if(!$role->is_update){
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
				if($role->is_update){
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
			if(!$role->is_del){
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

	public function search()
	{
		return view('web.project.search');
	}
}