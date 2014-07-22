<?php

//require_once(MyExceptions.php);

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

	private function failedLogin()
	{
		//$sql = "UPDATE ".TBL_PREFIX."user_access SET FailedLogins = FailedLogins+1, "
		//	. "LastFailedLogin = :failedLoginTime WHERE UserID = :userid";
        //$this->dbconn->execute($sql,array('userid' => $userid, 
        //	':failedLoginTime' => time()),true);
	}

	public static function Login($userNameEmail, $pwd)
	{
		$user = NULL;

		// user can login with username or email
		if (filter_var($userNameEmail, FILTER_VALIDATE_EMAIL)) // given value is email
			$user = self::where('EMail','=',$userNameEmail)->first();
		else
			$user = self::where('Username','=',$userNameEmail)->first();

		if ($user == NULL)
			throw new LoginException("Incorrect Username Email Password", 1);

		// 3 earlier failed login attempts. ask user to wait for 2 minutes
		// to prevent automated tries
		if (($user->FailedLogins >= 3) && ($user->LastFailedLogin > (time() - (60*2))))
            throw new LoginException("Too Many Failed Recent Attempts", 2);

        // verify password
 		if (!(crypt($pwd,$user->Pwd) == $user->Pwd))
 		{
			// increment failed attempts
			$user->FailedLogins += 1;
			$user->LastFailedLogin = time();
			$user->save();

			throw new LoginException("Incorrect Username Email Password", 1);
 		}

 		// account active?
 		// TO TEST BY CREATING NEW ACCOUNT
 		if ($user->Active != 1)  			// no :-(
			throw new LoginException("Account Not Activated", 3);

        // reset failed login
        $user->FailedLogins = 0;
        $user->LastFailedLogin = NULL;
        $user->save();
        return $user->UserID;
	}
}

?>
