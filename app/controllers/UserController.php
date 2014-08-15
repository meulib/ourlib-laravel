<?php 

//require_once('MyExceptions.php');

class UserController extends BaseController
{

    public function login()
    {
        $userNameEmail = Input::get('user_name');
        $pwd = Input::get('user_password');
        try
        {
            $result = UserAccess::login($userNameEmail, $pwd);
            if ($result)
            {
                $loggedInUser = User::find($result);
                Session::put('loggedInUser',$loggedInUser);
                return Redirect::to(URL::previous());
            }
            else
                throw new Exception("Something Wrong In Login", 1);               
        }
        catch (LoginException $e)
        {
            echo $e->getMessage();
        }
    }

    public function logout()
    {
        Session::flush();
        return Redirect::to(URL::previous());
    }

    public function signup()
    {
        return View::make('signup');
    }
}
?>