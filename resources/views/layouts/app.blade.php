<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0"/>
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Swift Fox:開源的學生社群軟體" />
    <meta name="keywords" content="學生社群" />
    <meta name="author" content="Diego" />
    <title>Swift Fox</title>
	@vite(['resources/css/style.css','resources/css/materialize.css','resources/js/app.js','resources/js/materialize.js','resources/js/init.js'])
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<link rel="shortcut icon" href="{{ asset('images/SWIFT FOX ICON.ico') }}" type="image/x-icon" />
</head>
<body>

	@yield('content')

</body>
<script src="https://cdn.jsdelivr.net/npm/@tsparticles/confetti@3.0.3/tsparticles.confetti.bundle.min.js"></script>
<script src="{{ asset('js/vue.js') }}"></script>
<script src="{{ asset('js/vue-router.js') }}"></script>
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/axios.js') }}"></script>
@yield('scripts')
</html>
