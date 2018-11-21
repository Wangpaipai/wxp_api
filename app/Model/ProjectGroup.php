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
	const APPLY_OUT = 3;//已退出

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

	/**
	 * 获取当前用户对项目的状态
	 * Created by：Mp_Lxj
	 * @date 2018/11/15 14:17
	 * @param $uid
	 * @return mixed
	 */
	public function getUserGroup($uid,$project_id)
	{
		return $this->where('uid',$uid)->where('project_id',$project_id)->where('apply','<>',self::APPLY_FALSE)->where('apply','<>',self::APPLY_OUT)->first(['apply']);
	}

	/**
	 * 获取当前用户对项目的申请状态
	 * Created by：Mp_Lxj
	 * @date 2018/11/15 15:47
	 * @param $project_id
	 * @param $uid
	 * @return mixed
	 */
	public function getGroupCount($project_id,$uid)
	{
		return $this->where('uid',$uid)->where('project_id',$project_id)->where('apply','<>',self::APPLY_OUT)->count();
	}

	/**
	 * 获取申请列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/16 8:51
	 * @param $data
	 * @return mixed
	 */
	public function getGroupApply($data)
	{
		$field = [
			'project_group.id','project_group.apply','project_group.created_at','t1.name as username','t2.name'
		];
		return $this
			->leftJoin('users as t1','project_group.uid','=','t1.id')
			->leftJoin('project as t2','project_group.project_id','=','t2.id')
			->when(isset($data['name']) && $data['name'],function($query)use($data){
				return $query->where('t2.name','like','%' . $data['name'] . '%');
			})
			->when(isset($data['username']) && $data['username'],function($query)use($data){
				return $query->where('t1.name','like','%' . $data['username'] . '%');
			})
			->orderBy('project_group.created_at','desc')
			->select($field)
			->paginate(15);
	}

	/**
	 * 修改项目组申请状态
	 * Created by：Mp_Lxj
	 * @date 2018/11/16 9:32
	 * @param array $data
	 * @return mixed
	 */
	public function applyUpdate(array $data)
	{
		return $this->where('id',$data['group_id'])->update(['apply' => $data['apply']]);
	}

	/**
	 * 退出项目
	 * Created by：Mp_Lxj
	 * @date 2018/11/16 10:09
	 * @param $project_id
	 * @return mixed
	 */
	public function applyOut($project_id)
	{
		return $this->where('project_id',$project_id)->where('uid',session('user')->id)->update(['apply' => self::APPLY_OUT]);
	}

	/**
	 * 获取项目成员列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/19 10:01
	 * @param $project_id
	 * @return mixed
	 */
	public function getMemberList($project_id)
	{
		$field = [
			't1.name','project_group.id','project_group.is_show','project_group.is_update','project_group.is_del','project_group.is_give',
			'project_group.created_at','project_group.id'
		];
		return $this
			->leftJoin('users as t1','project_group.uid','=','t1.id')
			->where('project_id',$project_id)
			->where('apply',self::APPLY_TRUE)
			->orderBy('project_group.created_at','desc')
			->select($field)
			->orderBy('project_group.created_at','desc')
			->paginate(15);
	}

	/**
	 * 修改项目成员权限
	 * Created by：Mp_Lxj
	 * @date 2018/11/19 14:00
	 * @param $data
	 * @param $role
	 * @return mixed
	 */
	public function groupRoleUpdate($data,$role)
	{
		return $this->where('id',$data['id'])->update($role);
	}

	/**
	 * 移除项目成员
	 * Created by：Mp_Lxj
	 * @date 2018/11/19 14:52
	 * @param $group_id
	 * @return mixed
	 */
	public function groupDel($group_id)
	{
		return $this->where('id',$group_id)->delete();
	}

	/**
	 * 获取项目下所有成员
	 * Created by：Mp_Lxj
	 * @date 2018/11/21 15:28
	 * @param $project_id
	 * @return mixed
	 */
	public function getGroupList($project_id)
	{
		$field = [
			't.id','t.name'
		];
		return $this
			->leftJoin('users as t','t.id','=','project_group.uid')
			->where('project_id',$project_id)
			->select($field)
			->get();
	}
}