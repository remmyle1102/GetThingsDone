<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	<link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Get Things Done</title>
</head>
<body>
<div id="app" class="text-center bg">
<task-component></task-component>
@yield('content')
</div>
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>