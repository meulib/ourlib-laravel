<?php

class Transaction extends Eloquent {

	protected $table = 'transactions_active';
	protected $primaryKey = 'ID';

	public function LenderUser()
	{
		return $this->hasOne('User', 'UserID', 'Lender');
	}

	public function BorrowerUser()
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
			$tran->Status = self::tStatusByKey('T_STATUS_REQUESTED');
			$tran->save();
			$tranID = $tran->ID;

			$tranH = new TransactionHistory;
			$tranH->TransactionID = $tranID;
			$tranH->Status = self::tStatusByKey('T_STATUS_REQUESTED');
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

	public static function reply($tranID, $fromUserID, $toUserID, $msg)
	{
		DB::beginTransaction();
		try
		{
			$tranM = new TransactionMessage;
			$tranM->TransactionID = $tranID;
			$tranM->MessageFrom = $fromUserID;
			$tranM->MessageTo = $toUserID;
			$tranM->Message = $msg;
			$tranM->save();

			$msgID = $tranM->ID;

			$userM = new UserMessage;
			$userM->MsgID = $msgID;
			$userM->UserID = $fromUserID;
			$userM->FromTo = MESSAGE_FROM;
			$userM->OtherUserID = $toUserID;
			$userM->TransactionID = $tranID;
			$userM->Message = $msg;
			$userM->ReadFlag = 1;
			$userM->save();

			$userM = new UserMessage;
			$userM->MsgID = $msgID;
			$userM->UserID = $toUserID;
			$userM->FromTo = MESSAGE_TO;
			$userM->OtherUserID = $fromUserID;
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
		return $msgID;
	}

	public static function openMsgTransactions($userID)
	{
		// unread messages
		$tranIDs = DB::table('messages2')
					->select('TransactionID')
					->distinct()
					->where('UserID', '=', $userID)
					->where('ReadFlag', '=', 0)
					->lists('TransactionID');

		// transaction details for unread messages
		$trans = Transaction::whereIn('ID',$tranIDs)
					->with('LenderUser','BorrowerUser','Book')
					->get();

		return $trans;
	}

	public static function tMessages($tranID,$userID)
	{
		$msgs = UserMessage::where('TransactionID', '=', $tranID)
						->where('UserID','=',$userID)
						->with('User','OtherUser')
						->get();
		return $msgs;
	}

	public static function tStatusByVal($sVal)
	{
		switch ($sVal) 
		{
			case 1:
				return 'T_STATUS_REQUESTED';
				break;

			case 2:
				return 'T_STATUS_LENT';
				break;

			case 10:
				return 'T_STATUS_RETURNED';
				break;
			
			default:
				return '';
				break;
		}
	}

	public static function tStatusByKey($sKey)
	{
		switch ($sKey) 
		{
			case 'T_STATUS_REQUESTED':
				return 1;
				break;

			case 'T_STATUS_LENT':
				return 2;
				break;

			case 'T_STATUS_RETURNED':
				return 10;
				break;
			
			default:
				return -1;
				break;
		}
	}
}

?>