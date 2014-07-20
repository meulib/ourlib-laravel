<?php

//use Illuminate\Auth\UserTrait;
//use Illuminate\Auth\UserInterface;
//use Illuminate\Auth\Reminders\RemindableTrait;
//use Illuminate\Auth\Reminders\RemindableInterface;

//class User extends Eloquent implements UserInterface, RemindableInterface {

//	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
//	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
//	protected $hidden = array('password', 'remember_token');

//}

class UserAccess extends Eloquent {

	protected $table = 'user_access';
	protected $primaryKey = 'UserID';

	public static function Login($userNameEmail, $pwd)
	{
		$user = NULL;

		// user can login with username or email
		if (filter_var($userNameEmail, FILTER_VALIDATE_EMAIL)) // given value is email
			$user = self::where('EMail','=',$userNameEmail)->first();
		else
			$user = self::where('Username','=',$userNameEmail)->first();

		var_dump($user);
	}
}

?>
