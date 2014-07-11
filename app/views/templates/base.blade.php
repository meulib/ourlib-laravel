<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    @section('htmlHead')
    	<title>{{Config::get('app.name')}}</title>
    @show
</head>
<body>
    @section('header')
    	<div id='head' style='position:relative;width:100%;margin-bottom:10px;'>
    		<div id='sitetitle' style='width:50%;'>
    			@include('templates.mast')
    		</div>
    		<div id='toplinks' style='width:50%;position:absolute;right:0;top:0;text-align:right'>
    			<br/>
    		</div>
    	</div>
		
	@show
    @yield('content')
    {{--placeholder for footer--}}
</body>
</html>

