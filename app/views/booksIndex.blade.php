@extends('templates.base')

<ul>
@section('content')
	@foreach($books as $book)
		{{-- var_dump($book) --}}
		<li>{{{ $book->Title }}}
		@if ($book->SubTitle)
			{{{ ": ".$book->SubTitle }}}
		@endif
		@if ($book->Author1)
			{{{ "&nbsp;by ".$book->Author1 }}}
		@endif
		@if ($book->Author2)
			{{{ ", ".$book->Author2 }}}
		@endif
		<br/>
	@endforeach
@stop
</ul>