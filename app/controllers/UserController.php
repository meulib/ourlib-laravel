<?php 

class UserController extends BaseController
{
    /* public function showAll()
    {
    	$books = FlatBook::all();
        return View::make('booksIndex',array('books' => $books));
    } */

    /* public function showSingle($bookId = null)
    {
        //return View::make('single');
        if ($bookId == null)
        {
        	return Redirect::to(URL::previous());
        }
        else
        {
            $book = FlatBook::find($bookId);
            $copies = BookCopy::where('BookID', '=', $book->ID)->get();
            return View::make("book",array('book' => $book, 'copies' => $copies));
	    }
    } */

    public function login()
    {
        echo "user controller login";
        $userNameEmail = Input::get('user_name');
        $pwd = Input::get('user_password');
        UserAccess::login($userNameEmail, $pwd);
    }
}
?>