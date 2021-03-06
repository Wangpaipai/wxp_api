<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2018/11/14
 * Time: 10:58
 */

namespace App\Model;

use gophp\helper\arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Project extends Model
{
	use SoftDeletes;
	protected $table = 'project';
	protected $dateFormat = 'U';
	protected $guarded = [];//字段黑名单
	protected $dates = ['deleted_at'];

	//显示状态
	const SHOW_TRUE = 1;
	const SHOW_FALSE = 0;

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

	/**
	 * 搜索项目列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/15 14:04
	 * @param array $data
	 * @return mixed
	 */
	public function searchProject(array  $data)
	{
		$field = [
			'project.id','project.name','project.brief','project.uid','project.created_at','users.name as username'
		];
		return $this
			->leftJoin('users','project.uid','=','users.id')
//			->leftJoin('project_group','project.id','=','project_group.project_id')
			->when(isset($data['username']) && $data['username'],function($query)use($data){
				return $query->where('users.name','like','%' . $data['username'] . '%');
			})
			->when(isset($data['name']) && $data['name'],function($query)use($data){
				return $query->where('project.name','like','%' . $data['name'] . '%');
			})
			->where('project.is_show',self::SHOW_TRUE)
			->select($field)
			->orderBy('project.created_at','desc')
			->paginate(15);
	}

	/**
	 * 获取当前项目详情
	 * Created by：Mp_Lxj
	 * @date 2018/11/16 13:39
	 * @param $project_id
	 * @return mixed
	 */
	public function getProjectDetail($project_id)
	{
		$field = [
			'project.id','project.name','project.uid','project.brief','project.param','project.is_show','users.name as username',
			'project.created_at','project.updated_at'
		];
		return $this
			->leftJoin('users','project.uid','=','users.id')
			->where('project.id',$project_id)
			->select($field)
			->first();
	}

	/**
	 * 转让项目
	 * Created by：Mp_Lxj
	 * @date 2018/11/21 15:47
	 * @param $data
	 * @return mixed
	 */
	public function projectGive($data)
	{
		return $this->where('id',$data['project_id'])->update(['uid' => $data['uid']]);
	}

	/**
	 * Created by：Mp_Lxj
	 * @date 2018/11/22 10:02
	 * @param $data
	 * @return mixed
	 */
	public function getProjectCount($data)
	{
		return $this
			->when(isset($data['created_at']) && $data['created_at'],function($query)use($data){
				return $query->where('created_at','>',$data['created_at']);
			})
			->when(isset($data['uid']) && $data['uid'],function($query)use($data){
				return $query->where('uid',$data['uid']);
			})
			->count();
	}

	/**
	 * 后端管理项目列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/22 13:53
	 * @param array $data
	 * @return mixed
	 */
	public function projectList(array  $data)
	{
		$field = [
			'project.id','project.name','project.uid','project.created_at','users.name as username'
		];
		return $this
			->leftJoin('users','project.uid','=','users.id')
			->when(isset($data['username']) && $data['username'],function($query)use($data){
				return $query->where('users.name','like','%' . $data['username'] . '%')->orWhere('users.email','like','%' . $data['username'] . '%');
			})
			->when(isset($data['name']) && $data['name'],function($query)use($data){
				return $query->where('project.name','like','%' . $data['name'] . '%');
			})
			->select($field)
			->orderBy('project.created_at','desc')
			->paginate(15);
	}
}