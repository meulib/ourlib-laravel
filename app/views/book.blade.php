
@extends('templates.base')

<ul>
@section('content')
	<b>{{{$book->Title}}}
		@if ($book->SubTitle)
			{{{ ": ".$book->SubTitle }}}
		@endif
	</b><br/>
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
	<b>Lenders</b><br/>
	@foreach($copies as $bCopy)
		{{{$bCopy->Owner->City.', '.$bCopy->Owner->Locality}}}<br/>
	@endforeach
@stop
</ul>
