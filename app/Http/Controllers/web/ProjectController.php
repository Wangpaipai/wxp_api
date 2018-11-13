<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2018/11/13
 * Time: 15:47
 */

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class ProjectController extends Controller
{
	public function projectCreateView(Request $request)
	{
		return view('web.project.add');
	}
}