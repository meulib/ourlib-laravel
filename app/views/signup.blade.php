@extends('templates.base')

@section('content')
<!-- TO DO: break this form into several pages/tabs with heading so that it is easier for user. Form does not feel too long. -->
{{ Form::open() }}
	<table>
		<tr>
			<td>{{ Form::label('l_email', 'Email'); }}</td>
			<td>{{ Form::text('f_email', '', ['required']) }}<br/></td>
		</tr>
		<tr>
			<td>{{ Form::label('l_email1', 'Re-enter Email'); }}</td>
			<td>{{ Form::text('f_email1', '', ['required']) }}<br/></td>
		</tr>
		<tr>
			<td>{{ Form::label('l_name', 'Name'); }}</td>
			<td>{{ Form::text('f_name', '', ['required']) }}<br/></td>
		</tr>
		<tr>
			<td style="vertical-align: top;">
				{{ Form::label('l_addr', 'Address'); }}
			</td>
		    <td>{{ Form::textarea('msg', '', ['size' => '20x3','required']) }}
		    </td>
		</tr>
		<tr>
			<td>{{ Form::label('l_locality', 'Locality'); }}</td>
			<td>{{ Form::text('f_locality', '') }}</td>
		</tr>
		<tr>
			<td>{{ Form::label('l_city', 'City'); }}</td>
			<td>{{ Form::select('f_city', ['Manipal', 'Udupi'],['required']) }}
			</td>
		</tr>
		<tr>
			<td>{{ Form::label('l_state', 'State'); }}</td>
			<td>{{ Form::select('f_state', ['Karnataka'],['required']) }}
			</td>
		</tr>
		<tr>
			<td>{{ Form::label('l_phone', 'Phone number (mobile preferred)'); }}</td>
			<td>{{ Form::text('f_phone', '', ['required']) }}<br/></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><br/></td>
		</tr>
		<tr>
			<td>{{ Form::label('l_username', 'Username'); }}</td>
			<td>
			{{ Form::text('f_username', '', ['required','pattern' => '[a-zA-Z0-9]{2,64}']) }}<br/>
			</td>
		</tr>
		<tr>
			<td>{{ Form::label('l_pwd', 'Password'); }}</td>
			<td>
			{{ Form::text('f_pwd', '', ['required','pattern' => '.{6,}', 'autocomplete' => 'off']) }}<br/>
			</td>
		</tr>
		<tr>
			<td>{{ Form::label('l_pwd1', 'Re-enter Password'); }}</td>
			<td>
			{{ Form::text('f_pwd1', '', ['required','pattern' => '.{6,}', 'autocomplete' => 'off']) }}<br/>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				{{ HTML::image(URL::to('showCaptcha')) }}<br/>
      			<label>Please enter these characters</label><br/>
      			<input type="text" name="captcha" required /></td>
		</tr>
		<tr>
			<td></td>
			<td>{{ Form::submit('Join!'); }}</td>
		</tr>
	</table>
{{ Form::close() }}
@stop
