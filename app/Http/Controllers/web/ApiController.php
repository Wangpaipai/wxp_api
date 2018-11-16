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
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\web\traits\ProjectAction;
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

}