<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2018/11/14
 * Time: 16:24
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProjectModel extends Model
{
	use SoftDeletes;
	protected $table = 'project_model';
	protected $dateFormat = 'U';
	protected $guarded = [];//字段黑名单
	protected $dates = ['deleted_at'];

	/**
	 * 删除项目模型
	 * Created by：Mp_Lxj
	 * @date 2018/11/14 16:25
	 * @param $project_id
	 * @return mixed
	 */
	public function projectModelDel($project_id)
	{
		return $this->where('project_id',$project_id)->delete();
	}

	/**
	 * 获取项目菜单栏
	 * Created by：Mp_Lxj
	 * @date 2018/11/16 14:30
	 * @param $project_id
	 * @return mixed
	 */
	public function getModelApi($project_id)
	{
		$field = [
			'project_model.id','project_model.name','t.id as api_id','t.title'
		];
		return $this
			->leftJoin('project_api as t','project_model.id','=','t.model_id')
			->where('project_model.project_id',$project_id)
			->whereNull('t.deleted_at')
			->select($field)
			->orderBy('project_model.created_at')
			->get();
	}
}