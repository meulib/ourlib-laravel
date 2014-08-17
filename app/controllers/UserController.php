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

    public function submitSignup()
    {
        $captcha = Input::get('f_captcha');
        
        if (Session::has('captcha'))
        {
            $generatedCaptcha = Session::pull('captcha');
            if ($generatedCaptcha != $captcha)
                Session::push('RegisterError','Captcha text does not match');
        }
        else
            Session::push('RegisterError','Captcha error');

        $data = Input::all();

        $rules = array(
            'email' => 'required|email|confirmed|max:100|unique:user_access,EMail',
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'username' => 'required|alpha_num|between:2,64|unique:user_access,Username',
            'password' => 'required|confirmed|min:6'
        );
        
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) 
        {
            return Redirect::to(URL::previous())->withErrors($validator);
        }

        return "Data was saved.";
    }
}
?>