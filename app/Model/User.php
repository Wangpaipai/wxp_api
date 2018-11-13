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
		return $this
			->when($type === 'name',function($query) use($data){
				return $query->where('name',$data['username']);
			})
			->when($type === 'email',function($query)use($data){
				return $query->where('email',$data['username']);
			})
			->first();
	}
}