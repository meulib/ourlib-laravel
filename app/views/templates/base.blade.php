<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    @section('htmlHead')
        {{ HTML::script('js/ourlib.js'); }}
    	<title>{{Config::get('app.name')}}</title>
    @show
</head>
<body>
    @section('header')
   		@include('templates.mast')
	@show
    @section('appLinks')
        <a href={{URL::to('/browse')}}>Browse Collection</a> | 
        @if (Session::has('loggedInUser'))
            Messages | My Books | My Borrowed Books
        @else
            Join
        @endif
        <br/><br/>
    @show
    @yield('content')
    {{--placeholder for footer--}}
</body>
</html>

