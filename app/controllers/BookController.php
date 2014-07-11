<?php 

class BookController extends BaseController
{
    public function showIndex()
    {
    	$books = FlatBook::all();
        return View::make('booksIndex',array('books' => $books));
    }

    public function showSingle($articleId)
    {
        //return View::make('single');
    }
}
?>