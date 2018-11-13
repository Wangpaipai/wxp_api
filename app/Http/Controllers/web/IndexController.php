<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2018/11/13
 * Time: 14:32
 */

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class IndexController extends Controller
{
	public function index()
	{
		return view('web.project.select');
	}
}