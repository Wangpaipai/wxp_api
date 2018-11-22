<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2018/11/16
 * Time: 10:32
 */

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class UserLoginLog extends Model
{
	protected $table = 'user_login_log';
	protected $dateFormat = 'U';
	protected $guarded = [];//字段黑名单

	/**
	 * 获取登录历史列表
	 * Created by：Mp_Lxj
	 * @date 2018/11/16 10:37
	 * @return mixed
	 */
	public function getLoginLog()
	{
		$field = [
			'ip','created_at'
		];
		return $this->where('uid',session('user')->id)->select($field)->orderBy('created_at','desc')->paginate(15);
	}

	/**
	 * 登录历史
	 * Created by：Mp_Lxj
	 * @date 2018/11/22 13:36
	 * @param array $data
	 * @return mixed
	 */
	public function historyList(array $data)
	{
		$field = [
			'user_login_log.id','user_login_log.ip','user_login_log.created_at','t.name','t.email'
		];
		return $this
			->leftJoin('users as t','t.id','=','user_login_log.uid')
			->when(isset($data['name']) && $data['name'],function($query)use($data){
				return $query->where('t.name','like','%' . $data['name'] . '%')->orWhere('t.email','like','%' . $data['name'] . '%');
			})
			->select($field)
			->orderBy('user_login_log.created_at','desc')
			->paginate(15);
	}
}