<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	protected $table = 'users';
	protected $dateFormat = 'U';
	protected $guarded = [];//字段黑名单

	/**
	 * 检测当前用户是否已被注册
	 * Created by：Mp_Lxj
	 * @date 2018/11/13 11:40
	 * @param $data-注册数据
	 * @return mixed
	 */
	public function isExistence(array $data)
	{
		return $this
			->when(isset($data['name']),function($query) use ($data){
				return $query->where('name',$data['name']);
			})
			->when(isset($data['email']),function($query) use ($data){
				return $query->where('email',$data['email']);
			})
			->count();
	}

	/**
	 * 获取用户信息
	 * Created by：Mp_Lxj
	 * @date 2018/11/13 13:36
	 * @param array $data-登录信息
	 * @param string $type-用户名类型
	 * @return mixed
	 */
	public function getUserData(array $data,$type = 'email')
	{
		if(!$type){
			return false;
		}
		$user = $this
			->when($type === 'name',function($query) use($data){
				return $query->where('name',$data['username']);
			})
			->when($type === 'email',function($query)use($data){
				return $query->where('email',$data['username']);
			})
			->first();
		if(!$user){
			$user = $this
				->when($type === 'name',function($query) use($data){
					return $query->where('email',$data['username']);
				})
				->when($type === 'email',function($query)use($data){
					return $query->where('name',$data['username']);
				})
				->first();
		}
		return $user;
	}

	/**
	 * 获取用户个数
	 * Created by：Mp_Lxj
	 * @date 2018/11/22 10:00
	 * @param $data
	 * @return mixed
	 */
	public function getUserCount($data)
	{
		return $this
			->when(isset($data['created_at']) && $data['created_at'],function($query)use($data){
				return $query->where('created_at','>',$data['created_at']);
			})
			->count();
	}

	/**
	 * 获取用户列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/22 11:53
	 * @param $data
	 * @return mixed
	 */
	public function getUserList($data)
	{
		$field = [
			'name','email','id','created_at'
		];
		return $this
			->when(isset($data['name']) && $data['name'],function($query)use($data){
				return $query->where('name','like','%' . $data['name'] . '%')->orWhere('email','like','%' . $data['name'] . '%');
			})
			->select($field)
			->paginate(15);
	}
}