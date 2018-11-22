<?php

namespace App\Http\Controllers\admin;

use App\Model\Project;
use App\Model\ProjectApi;
use App\Model\ProjectModel;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class IndexController extends Controller
{
	/**
	 * 后台首页
	 * Created by：Mp_Lxj
	 * @date 2018/11/22 10:04
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
	 */
	public function index()
	{
		return view('admin.index',['total'  => $this->getTotal()]);
	}

	/**
	 * 后台数据统计
	 * Created by：Mp_Lxj
	 * @date 2018/11/22 10:05
	 */
	public function getTotal()
	{
		$User = new User();
		$Project = new Project();
		$ProjectModel = new ProjectModel();
		$ProjectApi = new ProjectApi();

		$res['user']['total'] = $User->getUserCount([]);
		$res['user']['today'] = $User->getUserCount(['created_at' => strtotime(date('Y-m-d'))]);
		$res['project']['total'] = $Project->getProjectCount([]);
		$res['project']['today'] = $Project->getProjectCount(['created_at' => strtotime(date('Y-m-d'))]);
		$res['project_model']['total'] = $ProjectModel->getProjectModelCount([]);
		$res['project_model']['today'] = $ProjectModel->getProjectModelCount(['created_at' => strtotime(date('Y-m-d'))]);
		$res['project_api']['total'] = $ProjectApi->getProjectApiCount([]);
		$res['project_api']['today'] = $ProjectApi->getProjectApiCount(['created_at' => strtotime(date('Y-m-d'))]);

		return $res;
	}
}