<?php 

class BookController extends BaseController
{
    public function showAll()
    {
    	$books = FlatBook::all();
        return View::make('booksIndex',array('books' => $books));
    }

    public function showSingle($bookId = null)
    {
        //return View::make('single');
        if ($bookId == null)
        {
        	return Redirect::to(URL::previous());
        }
        else
        {
	        return "rcid $bookId";
	    }
    }
}
?>