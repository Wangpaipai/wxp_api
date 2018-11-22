<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2018/11/22
 * Time: 10:20
 */

namespace App\Http\Controllers\admin;

use App\Model\Project;
use App\Model\ProjectApi;
use App\Model\ProjectGroup;
use App\Model\ProjectModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
	/**
	 * 项目列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/22 10:54
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
	 */
	public function index()
	{
		return view('admin.project.index');
	}

	/**
	 * 项目列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/22 11:19
	 * @param Request $request
	 * @return mixed
	 */
	public function projectList(Request $request)
	{
		$param = $request->all();
		$Project = new Project();
		$ProjectApi = new ProjectApi();
		$ProjectGroup = new ProjectGroup();
		$ProjectModel = new ProjectModel();
		$list = $Project->searchProject($param)->toArray();

		if(!$list['total']){
			return returnCode(0);
		}
		$res['total'] = $list['total'];
		$res['page_count'] = $list['last_page'];
		$res['project'] = $list['data'];

		foreach($res['project'] as &$value){
			$value['member_count'] = $ProjectGroup->groupCount(['project_id' => $value['id']]);
			$value['api_count'] = $ProjectApi->getProjectApiCount(['project_id' => $value['id']]);
			$value['model_count'] = $ProjectModel->getProjectModelCount(['project_id' => $value['id']]);
		}

		return returnCode(1,'',$res);
	}
}