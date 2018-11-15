<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2018/11/14
 * Time: 14:39
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProjectGroup extends Model
{
	use SoftDeletes;
	protected $table = 'project_group';
	protected $dateFormat = 'U';
	protected $guarded = [];//字段黑名单
	protected $dates = ['deleted_at'];

	//申请状态
	const APPLY_FALSE = 0;//拒绝
	const APPLY_LOADING = 1;//申请中
	const APPLY_TRUE = 2;//同意

	/**
	 * 获取用户对项目的权限
	 * Created by：Mp_Lxj
	 * @date 2018/11/14 14:43
	 * @param $user_id
	 * @param $project_id
	 * @return mixed
	 */
	public function getProjectGroupFind($user_id,$project_id)
	{
		$field = [
			'is_show','is_update','is_del','is_give'
		];
		return $this->where('project_id',$project_id)->where('uid',$user_id)->where('apply',self::APPLY_TRUE)->first($field);
	}

	/**
	 * 软删除项目组成员
	 * Created by：Mp_Lxj
	 * @date 2018/11/14 15:57
	 * @param $project_id
	 * @return mixed
	 */
	public function projectGroupDel($data)
	{
		return $this
			->when(isset($data['project_id']),function($query)use($data){
				return $query->where('project_id',$data['project_id']);
			})
			->when(isset($data['uid']),function($query)use($data){
				return $query->where('uid',$data['uid']);
			})
			->delete();
	}

	/**
	 * 加入的项目列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/14 17:08
	 * @return mixed
	 */
	public function getProjectList()
	{
		$field = [
			'project_group.is_show','project_group.is_update','project_group.is_del','project_group.is_give',
			'project.id','project.name','project.brief','project.created_at','project.updated_at'
		];
		return $this
			->leftJoin('project','project_group.project_id','=','project.id')
			->where('project_group.uid',session('user')->id)
			->where('apply',self::APPLY_TRUE)
			->orderBy('project_group.created_at')
			->select($field)
			->get();
	}
}