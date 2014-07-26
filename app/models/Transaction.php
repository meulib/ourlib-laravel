<?php

class Transaction extends Eloquent {

	protected $table = 'transactions_active';
	protected $primaryKey = 'ID';

	public static function request($borrowerID, $itemCopyID, $msg)
	{
		$iCopy = BookCopy::findOrFail($itemCopyID);
		$ownerID = $iCopy->UserID;
		$itemID = $iCopy->BookID;

		DB::beginTransaction();

			$tran = new Transaction;
			$tran->Borrower = $borrowerID;
			$tran->Lender = $ownerID;
			$tran->ItemCopyID = $itemCopyID;
			$tran->ItemID = $itemID;
			$tran->Status = TRANSACTION_STATUS_REQUESTED;
			$tran->save();
			$tranID = $tran->id;
			echo $tranID;

		DB::commit();
	}
}

?>