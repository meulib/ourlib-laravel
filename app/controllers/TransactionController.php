<?php 

class TransactionController extends BaseController
{
    public function request()
    {
        $loggedIn = false;
        if (!Session::has('loggedInUser'))
            return Redirect::to(URL::to('/'));

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
            Session::put('TransactionMessage',['RequestBook','Request Sent.']);
        else
           Session::put('TransactionMessage',['RequestBook','There was some error. Request not sent.']);

        return Redirect::to(URL::previous());
    }

    public function messages($tranID = 0)
    {
        $loggedIn = false;
        if (!Session::has('loggedInUser'))
            return Redirect::to(URL::to('/'));

        $userID = Session::get('loggedInUser')->UserID;

        $msgTransactions = Transaction::openMsgTransactions($userID);
        $msgs = NULL;
        
        if ($tranID > 0)
            $msgs = Transaction::tMessages($tranID,$userID);

        return View::make("messages",array('msgTransactions' => $msgTransactions,'msgs' => $msgs));
        //var_dump($result);
    }

    public function reply()
    {
        $loggedIn = false;
        if (!Session::has('loggedInUser'))
            return Redirect::to(URL::to('/'));

        $userID = Session::get('loggedInUser')->UserID;
        $toUserID = Input::get('toUserID');
        $tranID = Input::get('tranID');
        $msg = Input::get('msg');

        try
        {
            $msgID = Transaction::reply($tranID, $userID, $toUserID, $msg);
        }
        catch (Exception $e)
        {
            Session::put('TransactionMessage',['Reply','There was some error. Reply not sent.']);
        }        

        if ($msgID > 0)
            Session::put('TransactionMessage',['Reply','Reply Sent.']);
        else
           Session::put('TransactionMessage',['Reply','There was some error. Reply not sent.']);

        return Redirect::to(URL::previous());
    }

    public function pendingRequests($bookCopyID=0)
    {
        $userID = Session::get('loggedInUser')->UserID;
        $trans = Transaction::pendingRequests($bookCopyID,$userID);
        return View::make("templates.lendBookForm",array('bookCopyID' => $bookCopyID,'requestTransactions' => $trans));
    }
}
?>