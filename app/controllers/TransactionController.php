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
        try
        {
            $tranID = Transaction::request($userID,$bookCopyID,$msg);
        }
        catch (Exception $e)
        {
            Session::put('TransactionMessage',['RequestBook','There was some error. Request not sent.']);
        }        

        if ($tranID > 0)
            Session::put('TransactionMessage',['RequestBook','Request Sent successfully']);
        else
           Session::put('TransactionMessage',['RequestBook','There was some error. Request not sent.']);

        return Redirect::to(URL::previous());
    }

    public function messages($tranID = 0)
    {
        $loggedIn = false;
        if (!Session::has('loggedInUser'))
            return Redirect::to(URL::previous());

        $userID = Session::get('loggedInUser')->UserID;

        $msgTransactions = Transaction::openMsgTransactions($userID);
        $msgs = NULL;
        
        if ($tranID > 0)
            $msgs = Transaction::tMessages($tranID,$userID);

        return View::make("messages",array('msgTransactions' => $msgTransactions,'msgs' => $msgs));
        //var_dump($result);

    }   
}
?>