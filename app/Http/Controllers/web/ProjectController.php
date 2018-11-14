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
use Illuminate\Http\Request;
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
		$result = $Project->getProjectList();
		return returnCode(1,'',$result);
	}
}