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
}