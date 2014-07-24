
@extends('templates.base')

<?php
	$loggedIn = false;
	if (Session::has('loggedInUser'))
		$loggedIn = true;
	$title = $book->Title;
	if ($book->SubTitle)
		$title .= ': '.$book->SubTitle;
?>

<ul>
@section('content')
	<b>{{{$title}}}</b><br/>
	@if ($book->Author1)
		{{{ $book->Author1 }}}
		@if ($book->Author2)
			{{{ ", ".$book->Author2 }}}
			 (Authors)
		@else
			 (Author)
		@endif		
	@endif
	<br/><br/>
	Book Copies ({{{count($copies)}}})
	<br/><br/>
	<b>Lenders</b><br/><br/>
	@foreach($copies as $bCopy)
		@if ($loggedIn)
			{{{$bCopy->Owner->FullName.': '}}}
		@endif
		{{{$bCopy->Owner->City.', '.$bCopy->Owner->Locality}}}<br/>
		@if ($loggedIn)
			<a href={{{URL::to('request', array($bCopy->ID))}}}>Request Book</a>
			@include('templates.requestBookForm')
		@endif
	@endforeach
@stop
</ul>
