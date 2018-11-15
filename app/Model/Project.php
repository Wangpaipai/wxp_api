<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2018/11/14
 * Time: 10:58
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Project extends Model
{
	use SoftDeletes;
	protected $table = 'project';
	protected $dateFormat = 'U';
	protected $guarded = [];//字段黑名单
	protected $dates = ['deleted_at'];

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

	/**
	 * 获取项目详细信息
	 * Created by：Mp_Lxj
	 * @date 2018/11/14 14:28
	 * @param $data
	 * @return mixed
	 */
	public function getProjectData($project_id)
	{
		$field = [
			'id','name','brief','param','is_show','uid'
		];
		return $this->where('id',$project_id)->first($field);
	}

	/**
	 * 软删除数据
	 * Created by：Mp_Lxj
	 * @date 2018/11/14 15:48
	 * @param $project_id
	 * @return mixed
	 */
	public function projectDel($project_id)
	{
		return $this->where('id',$project_id)->delete();
	}
}