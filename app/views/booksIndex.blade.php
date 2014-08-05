
@extends('templates.base')

@section('content')
	<ul>
	@foreach($books as $book)
		{{-- var_dump($book) --}}
		<li>
			<a href={{  URL::action('BookController@showSingle', array($book->ID))}}>
			{{{ $book->Title }}}
			@if ($book->SubTitle)
				{{{ ": ".$book->SubTitle }}}
			@endif
			</a>
			@if ($book->Author1)
				{{{ "&nbsp;by ".$book->Author1 }}}
			@endif
			@if ($book->Author2)
				{{{ ", ".$book->Author2 }}}
			@endif
			@if ($category == 'mine')
				<br/>
				@foreach($book->Copies as $copy)
					{{{$copy->StatusTxt()}}} 
					@if ($copy->StatusTxt() == 'Available')
						<?php $onclick = "lendDiv('".$copy->ID."')"; ?>
						{{ HTML::link('#','Lend', ['onclick'=>$onclick]); }}
						{{"<div id='lendBook".$copy->ID."' style='display:none'></div>"}}
					@endif
				@endforeach
				<br/><br/>
			@endif	
	@endforeach
	</ul>
@stop

