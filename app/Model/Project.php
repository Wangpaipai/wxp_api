<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2018/11/14
 * Time: 10:58
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
class Project extends Model
{
	protected $table = 'project';
	protected $dateFormat = 'U';
	protected $guarded = [];//字段黑名单

	/**
	 * 返回项目列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/14 11:33
	 * @return mixed
	 */
	public function getProjectList()
	{
		$field = [
			'id','name','brief','created_at','updated_at'
		];
		return $this->where('uid',session('user')->id)->orderBy('created_at','desc')->get($field);
	}
}