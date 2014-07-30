<?php

class Transaction extends Eloquent {

	protected $table = 'transactions_active';
	protected $primaryKey = 'ID';

	public function Lender()
	{
		return $this->hasOne('User', 'UserID', 'Lender');
	}

	public function Borrower()
	{
		return $this->hasOne('User', 'UserID', 'Borrower');
	}

	public function Book()
	{
		return $this->hasOne('FlatBook', 'ID', 'ItemID');
	}	

	public static function request($borrowerID, $itemCopyID, $msg)
	{
		$iCopy = BookCopy::findOrFail($itemCopyID);
		$ownerID = $iCopy->UserID;
		$itemID = $iCopy->BookID;
		$tranID = 0;

		DB::beginTransaction();

		try 
		{
			$tran = new Transaction;
			$tran->Borrower = $borrowerID;
			$tran->Lender = $ownerID;
			$tran->ItemCopyID = $itemCopyID;
			$tran->ItemID = $itemID;
			$tran->Status = TRANSACTION_STATUS_REQUESTED;
			$tran->save();
			$tranID = $tran->ID;

			$tranH = new TransactionHistory;
			$tranH->TransactionID = $tranID;
			$tranH->Status = TRANSACTION_STATUS_REQUESTED;
			$tranH->save();

			$tranM = new TransactionMessage;
			$tranM->TransactionID = $tranID;
			$tranM->MessageFrom = $borrowerID;
			$tranM->MessageTo = $ownerID;
			$tranM->Message = $msg;
			$tranM->save();
			$msgID = $tranM->ID;

			$userM = new UserMessage;
			$userM->MsgID = $msgID;
			$userM->UserID = $borrowerID;
			$userM->FromTo = MESSAGE_FROM;
			$userM->OtherUserID = $ownerID;
			$userM->TransactionID = $tranID;
			$userM->Message = $msg;
			$userM->ReadFlag = 1;
			$userM->save();

			$userM = new UserMessage;
			$userM->MsgID = $msgID;
			$userM->UserID = $ownerID;
			$userM->FromTo = MESSAGE_TO;
			$userM->OtherUserID = $borrowerID;
			$userM->TransactionID = $tranID;
			$userM->Message = $msg;
			$userM->save();
		}
		catch (Exception $e)
		{
			DB::rollback();
			throw $e;
		}				
		DB::commit();
		return $tranID;
	}

	public static function openMsgTransactions($userID)
	{
		$tranIDs = DB::table('messages2')
					->select('TransactionID')
					->distinct()
					->where('UserID', '=', $userID)
					->where('ReadFlag', '=', 0)
					->lists('TransactionID');

		$trans = Transaction::whereIn('ID',$tranIDs)->with('Lender','Borrower','Book')->get();

		return $trans;
	}
}

?>