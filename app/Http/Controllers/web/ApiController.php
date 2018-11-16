<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2018/11/16
 * Time: 10:56
 */

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class ApiController extends Controller
{
	/**
	 * 项目主页
	 * Created by：Mp_Lxj
	 * @date 2018/11/16 10:57
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
	 */
	public function index(Request $request,$id)
	{
		return view('web.project.home',['project_id' => $id]);
	}
}