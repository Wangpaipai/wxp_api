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
class ProjectApi extends Model
{
	use SoftDeletes;
	protected $table = 'project_api';
	protected $dateFormat = 'U';
	protected $guarded = [];//字段黑名单
	protected $dates = ['deleted_at'];

	/**
	 * 删除对应的api
	 * Created by：Mp_Lxj
	 * @date 2018/11/14 16:54
	 * @param $project_id
	 * @return mixed
	 */
	public function projectApiDel($project_id)
	{
		return $this->where('project_id',$project_id)->delete();
	}

	/**
	 * 删除对应的api
	 * Created by：Mp_Lxj
	 * @date 2018/11/19 17:17
	 * @param $project_id
	 * @return mixed
	 */
	public function removeApi($model)
	{
		return $this->where('model_id',$model)->delete();
	}

	/**
	 * 删除api
	 * Created by：Mp_Lxj
	 * @date 2018/11/20 16:13
	 * @param $api
	 * @return mixed
	 */
	public function delApi($api)
	{
		return $this->where('id',$api)->delete();
	}

	/**
	 * 获取接口详情
	 * Created by：Mp_Lxj
	 * @date 2018/11/20 16:58
	 * @param $api
	 * @param $project
	 * @return mixed
	 */
	public function getDetail($api,$project)
	{
		$field = [
			'id','project_id','model_id','title','method','brief','url','header','param','response','case',
		];
		return $this->where('id',$api)->where('project_id',$project)->first($field);
	}

	/**
	 * 更新接口数据
	 * Created by：Mp_Lxj
	 * @date 2018/11/21 10:28
	 * @param array $api
	 * @return mixed
	 */
	public function updateApi(array $api)
	{
		return $this->where('id',$api['id'])->where('project_id',$api['project_id'])->update($api);
	}

	/**
	 * 虎丘项目接口数
	 * Created by：Mp_Lxj
	 * @date 2018/11/22 10:04
	 * @param $data
	 * @return mixed
	 */
	public function getProjectApiCount($data)
	{
		return $this
			->when(isset($data['created_at']) && $data['created_at'],function($query)use($data){
				return $query->where('created_at','>',$data['created_at']);
			})
			->when(isset($data['project_id']) && $data['project_id'],function($query)use($data){
				return $query->where('project_id',$data['project_id']);
			})
			->count();
	}
}