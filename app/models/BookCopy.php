<?php

class BookCopy extends Eloquent {

	protected $table = 'bookcopies';
	protected $primaryKey = 'ID';

	public function Owner()
	{
		return $this->hasOne('User', 'UserID', 'UserID');
	}
}

?>