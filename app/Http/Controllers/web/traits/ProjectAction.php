<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2018/11/16
 * Time: 13:59
 */

namespace App\Http\Controllers\web\traits;


use App\Model\Project;
use App\Model\ProjectGroup;
use App\Model\ProjectModel;
use App\Model\User;

trait ProjectAction
{

	/**
	 * 返回公共参数
	 * Created by：Mp_Lxj
	 * @date 2018/11/16 13:57
	 * @param $project_id
	 */
	public function returnCommon($project_id)
	{
		$project = $this->projectDetail($project_id);
		$group = $this->projectGroup($project_id,$project);
		if($project->uid != session('user')->id && (!$group || !$group->is_show)){
			abort(404);
		}
		$menu = $this->projectModel($project_id);

		return ['project' => $project,'group' => $group,'menu' => $menu];
	}

	/**
	 * 获取项目的目录
	 * Created by：Mp_Lxj
	 * @date 2018/11/16 14:58
	 * @param $project_id
	 * @return array
	 */
	public function projectModel($project_id)
	{
		$ProjectModel = new ProjectModel();
		$model = $ProjectModel->getModelApi($project_id);
		$modelGroup = $this->arrayGroup($model->toArray(),'id',['id','name'],'api');
		foreach($modelGroup as $key=>$value){
			foreach($value['api'] as $k=>$v){
				if(!$v['api_id']){
					unset($modelGroup[$key]['api'][$k]);
				}
			}
		}
		view()->share('menu',$modelGroup);
		return $modelGroup;
	}

	/**
	 * 获取项目详情
	 * Created by：Mp_Lxj
	 * @date 2018/11/16 13:51
	 * @param $project_id
	 * @return mixed
	 */
	public function projectDetail($project_id)
	{
		$Project = new Project();
		$project_detail = $Project->getProjectDetail($project_id);
		if($project_detail->param){
			$project_detail->param = unserialize($project_detail->param);
		}
		view()->share('project',$project_detail);
		return $project_detail;
	}

	/**
	 * 获取用户对项目的权限
	 * Created by：Mp_Lxj
	 * @date 2018/11/16 13:51
	 * @param $project_id
	 * @return mixed
	 */
	public function projectGroup($project_id,$project = '')
	{
		if(!$project){
			$project = $this->projectDetail($project_id);
		}
		$ProjectGroup = new ProjectGroup();
		$user = session('user');
		if($user->id == $project->uid){
			$group['is_show'] = 1;
			$group['is_update'] = 1;
			$group['is_del'] = 1;
			$group['is_give'] = 1;
		}else{
			$group = $ProjectGroup->getProjectGroupFind($user->id,$project_id)->toArray();
		}
		view()->share('group',$group);
		return $group;
	}

	/**
	 * 重组二维数组
	 * Created by：Mp_Lxj
	 * @date 2018/11/16 14:47
	 * @param $array->要组合的二维数组
	 * @param $m->str键，组合条件（根据那个键值来组合） 如把相同的id值合并
	 * @param $field->相同的字段(不同的装进一个数组)  相同的放在外面
	 * @param $fruit->不同集合组成数组的集合键值
	 * @return array
	 */
	private function arrayGroup($array,$m,$field,$fruit='group'){
		//重新生成键值0开始递增
		$array = array_values($array);
		if(!$array){
			return $array;
		}
		$res = [];//定义返回的数据，临时数组
		$arr = [];//定义本次要取的数据，临时数组
		$map = $array[0][$m];//定义本次判断的条件
		foreach($array as $k=>$v){
			//如果满足条件，则取出数据
			if($v[$m] == $map){
				//把相同的字段提取出来
				foreach($field as $key=>$value){
					$arr[$value] = $v[$value];
					unset($array[$k][$value]);
				}
				//判断是否存在新的子数组是否存在，根据情况写入数据
				if(isset($arr[$fruit])){
					array_push($arr[$fruit],$array[$k]);
				}else{
					$arr[$fruit] = [];
					array_push($arr[$fruit],$array[$k]);
				}
				unset($array[$k]);
			}
		}
		//把本次循环取出的值写入返回数据
		array_push($res,$arr);
		//递归重复此方法操作取值
		$result = $this->arrayGroup($array,$m,$field,$fruit);
		//判断返回结果是否有值,若有值，写入返回结果
		if($result){
			foreach($result as $k=>$v){
				array_push($res,$v);
			}
		}
		return $res;
	}

	/**
	 * 根据邮箱、用户名获取用户
	 * Created by：Mp_Lxj
	 * @date 2018/11/19 13:47
	 * @param $name
	 * @return mixed
	 */
	public function getUsers($name)
	{
		$User = new User();
		if(verifyEmail($name)){
			$user = $User->getUserData(['username'=>$name],'email');
		}else{
			$user = $User->getUserData(['username'=>$name],'name');
		}
		return $user;
	}

	/**
	 * 分析用户设置的权限
	 * Created by：Mp_Lxj
	 * @date 2018/11/19 13:51
	 * @param array $data
	 * @return array
	 */
	public function paramData(array $data)
	{
		$role = [
			'is_show' => 0,
			'is_update' => 0,
			'is_del' => 0,
			'is_give' => 0,
		];

		if(in_array('show',$data)){
			$role['is_show'] = 1;
		}
		if(in_array('update',$data)){
			$role['is_update'] = 1;
		}
		if(in_array('delete',$data)){
			$role['is_del'] = 1;
		}
		if(in_array('give',$data)){
			$role['is_give'] = 1;
		}
		return $role;
	}
}