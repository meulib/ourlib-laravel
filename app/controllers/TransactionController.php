<?php 

class TransactionController extends BaseController
{
    public function request()
    {
        $loggedIn = false;
        if (!Session::has('loggedInUser'))
            return Redirect::to(URL::previous());

        $userID = Session::get('loggedInUser')->UserID;
        $bookCopyID = Input::get('bookCopyID');
        $msg = Input::get('requestMessage');
        Transaction::request($userID,$bookCopyID,$msg);
    }
}
?>