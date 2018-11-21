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
use App\Model\ProjectApi;
use App\Model\ProjectGroup;
use App\Model\ProjectModel;
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
			return returnCode(0,'无权限操作此项');
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
			return returnCode(0,'无权限操作此项');
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
			return returnCode(0,'无权限操作此项');
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

	/**
	 * 添加模块
	 * Created by：Mp_Lxj
	 * @date 2018/11/19 16:11
	 * @param Request $request
	 * @return mixed
	 */
	public function createModel(Request $request)
	{
		$param = $request->all();

		$group = $this->projectGroup($param['project']);
		if(!$group['is_update']){
			return returnCode(0,'无权限操作此项');
		}

		if(!$param['project']){
			return returnCode(0,'项目不存在');
		}

		$ProjectModel = new ProjectModel();
		$data['project_id'] = $param['project'];
		$data['name'] = $param['name'];
		$res = $ProjectModel->create($data);

		if($res){
			return returnCode(1,'添加成功',$res);
		}else{
			return returnCode(0,'添加失败,请稍后再试');
		}
	}

	/**
	 * 获取模块详情
	 * Created by：Mp_Lxj
	 * @date 2018/11/19 16:43
	 * @param Request $request
	 * @return mixed
	 */
	public function getModelDetail(Request $request)
	{
		$param = $request->all();
		$ProjectModel = new ProjectModel();
		$result = $ProjectModel->getModelData($param);
		if($result){
			return returnCode(1,'',$result);
		}else{
			return returnCode(0,'模块不存在');
		}
	}

	/**
	 * 更新模块信息
	 * Created by：Mp_Lxj
	 * @date 2018/11/19 16:58
	 * @param Request $request
	 * @return mixed
	 */
	public function updateModel(Request $request)
	{
		$param = $request->all();

		$group = $this->projectGroup($param['project']);
		if(!$group['is_update']){
			return returnCode(0,'无权限操作此项');
		}

		$ProjectModel = new ProjectModel();
		DB::beginTransaction();
		try{
			$ProjectModel->updateModel($param);
			DB::commit();
			return returnCode(1,'修改成功');
		}catch(\Exception $e){
			DB::rollBack();
			return returnCode(0,'修改失败,请稍后再试');
		}
	}

	/**
	 * 删除模块
	 * Created by：Mp_Lxj
	 * @date 2018/11/19 17:16
	 * @param Request $request
	 * @return mixed
	 */
	public function removeModel(Request $request)
	{
		$param = $request->all();
		if(!password_verify($param['pwd'],session('user')->password)){
			return returnCode(0,'密码错误');
		}

		if(!$param['id'] || !$param['project']){
			return returnCode(0,'模块不存在');
		}
		$group = $this->projectGroup($param['project']);
		if(!$group['is_del']){
			return returnCode(0,'无权限操作此项');
		}
		$ProjectModel = new ProjectModel();
		$ProjectApi = new ProjectApi();

		DB::beginTransaction();
		try{
			$ProjectModel->removeModel($param);
			$ProjectApi->removeApi($param['id']);
			DB::commit();
			return returnCode(1,'删除成功');
		}catch(\Exception $e){
			DB::rollBack();
			return returnCode(0,'删除失败,请稍后再试');
		}
	}

	/**
	 * 获取菜单
	 * Created by：Mp_Lxj
	 * @date 2018/11/20 9:04
	 * @param Request $request
	 * @return mixed
	 */
	public function getMenu(Request $request)
	{
		$project = $request->input('project',0);
		if(!$project){
			return returnCode(0,'项目不存在');
		}
		$menu = $this->returnCommon($project);
		return returnCode(1,'',$menu);
	}

	/**
	 * 添加接口
	 * Created by：Mp_Lxj
	 * @date 2018/11/20 13:41
	 * @param Request $request
	 * @return mixed
	 */
	public function createApi(Request $request)
	{
		$param = $request->all();

		$group = $this->projectGroup($param['project_id']);
		if(!$group['is_update']){
			return returnCode(0,'无权限操作此项');
		}

		$ProjectApi = new ProjectApi();
		unset($param['index']);
		unset($param['model_name']);
		$param['uid'] = session('user')->id;
		$result = $ProjectApi->create($param);
		if($result){
			return returnCode(1,'添加成功',$result);
		}else{
			return returnCode(0,'添加失败，请稍后再试');
		}
	}

	/**
	 * api详情页
	 * Created by：Mp_Lxj
	 * @date 2018/11/20 14:38
	 * @param Request $request
	 * @param $id
	 * @param $project
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
	 */
	public function detailApi(Request $request,$id,$project)
	{
		$this->returnCommon($project);
		$ProjectApi = new ProjectApi();
		$api = $ProjectApi->find($id);
		return view('web.api.detail',['api' => $api]);
	}

	/**
	 * 删除api
	 * Created by：Mp_Lxj
	 * @date 2018/11/20 16:14
	 * @param Request $request
	 * @return mixed
	 */
	public function deleteApi(Request $request)
	{
		$param = $request->all();
		$group = $this->projectGroup($param['project']);
		if(!$group['is_del']){
			return returnCode(0,'无权限操作此项');
		}
		if(!password_verify($param['password'],session('user')->password)){
			return returnCode(0,'密码错误');
		}
		$ProjectApi = new ProjectApi();
		DB::beginTransaction();
		try{
			$ProjectApi->delApi($param['id']);
			DB::commit();
			return returnCode(1,'删除成功');
		}catch(\Exception $e){
			DB::rollBack();
			return returnCode(0,'删除失败,请稍后再试');
		}
	}

	/**
	 * 修改接口数据页面
	 * Created by：Mp_Lxj
	 * @date 2018/11/20 16:01
	 * @param Request $request
	 * @param $id
	 * @param $project
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
	 */
	public function editApi(Request $request,$id,$project)
	{
		$this->returnCommon($project);
		$ProjectModel = new ProjectModel();
		$model = $ProjectModel->getModelList($project);
		return view('web.api.edit',['api_id' => $id,'model' => $model]);
	}

	/**
	 * 获取api接口详情
	 * Created by：Mp_Lxj
	 * @date 2018/11/20 17:01
	 * @param Request $request
	 * @return mixed
	 */
	public function getDetail(Request $request)
	{
		$param = $request->all();
		$ProjectApi = new ProjectApi();
		$api = $ProjectApi->getDetail($param['api'],$param['project']);
		if($api){
			$api->header = $api->header ? unserialize($api->header) : [];
			$api->param = $api->param ? unserialize($api->param) : [];
			$api->response = $api->response ? unserialize($api->response) : [];
			return returnCode(1,'',$api);
		}else{
			return returnCode(0,'项目不存在');
		}
	}

	/**
	 * 更新api接口数据
	 * Created by：Mp_Lxj
	 * @date 2018/11/21 10:29
	 * @param Request $request
	 * @return mixed
	 */
	public function updateApi(Request $request)
	{
		$param = $request->all();
		$group = $this->projectGroup($param['project_id']);
		if(!$group['is_update']){
			return returnCode(0,'无权限操作此项');
		}

		$ProjectApi = new ProjectApi();
		$param['header'] = $param['header'] ? serialize($param['header']) : '';
		$param['param'] = $param['param'] ? serialize($param['param']) : '';
		$param['response'] = $param['response'] ? serialize($param['response']) : '';
		DB::beginTransaction();
		try{
			$ProjectApi->updateApi($param);
			DB::commit();
			return returnCode(1,'更新成功');
		}catch(\Exception $e){
			DB::rollBack();
			return returnCode(0,'更新失败,请稍后再试');
		}
	}

}