<?php

class BookCopy extends Eloquent {

	protected $table = 'bookcopies';
	protected $primaryKey = 'ID';

	public function Owner()
	{
		return $this->hasOne('User', 'UserID', 'UserID');
	}

	public function Book()
	{
		return $this->hasOne('FlatBook', 'ID', 'BookID');
	}

	public function StatusTxt()
	{
		switch ($this->Status) 
		{
			case 1:
				return 'Available';
				break;
		
			default:
				return '';
				break;
		}
	}
}

?>