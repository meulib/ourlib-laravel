<?php
	$requests = count($requestTransactions);
?>

@if ($requests == 0)
	No Pending Requests
@else
	Pending Requests
{{-- Form::open(array('action' => 'TransactionController@lend')) --}}
{{ Form::open() }}
	{{ Form::hidden('bookCopyID',$bookCopyID) }}
	@foreach ($requestTransactions as $request)
		<br/>
		{{ Form::radio('lendToID', $request->Borrower) }}
		{{ Form::label('', $request->BorrowerUser->FullName) }}
	@endforeach
	<br/>
	{{ Form::submit('Lend'); }}
{{ Form::close() }}

@endif