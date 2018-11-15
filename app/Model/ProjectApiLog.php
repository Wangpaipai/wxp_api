<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2018/11/14
 * Time: 16:52
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProjectApiLog extends Model
{
	use SoftDeletes;
	protected $table = 'project_api_log';
	protected $dateFormat = 'U';
	protected $guarded = [];//字段黑名单
	protected $dates = ['deleted_at'];

	/**
	 * 删除api日志
	 * Created by：Mp_Lxj
	 * @date 2018/11/14 16:54
	 * @param $project_id
	 * @return mixed
	 */
	public function projectApiLogDel($project_id)
	{
		return $this->where('project_id',$project_id)->delete();
	}
}