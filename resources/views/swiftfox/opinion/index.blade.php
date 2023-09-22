<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
	<title>SwiftFox</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('css/materialize.css') }}">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&display=swap" rel="stylesheet">
	<link rel="shortcut icon" href="{{ asset('images/SWIFT FOX ICON.ico') }}" type="image/x-icon" />
</head>
<body>
<div id="app">
	
	@include('component.navigation')
	
    @include('component.serve.message')

    @include('component.logoutbanner')

	<div class="fixed-action-btn click-to-toggle">
		<a class="btn-floating btn-large red">
			<i class="large material-icons brown">menu</i>
		</a>
		<ul>
			<li>
				<a href="#modal1" class="btn-floating red tooltipped modal-trigger" data-position="top" data-tooltip="發布投票">
					<i class="material-icons">mode_edit</i>
				</a>
			</li>
			<li>
				<a href="{{route('home.index')}}"class="btn-floating yellow tooltipped modal-trigger" data-position="top" data-tooltip="我的小屋">
					<i class="material-icons">view_quilt</i>
				</a>
			</li>
			<li>
				<a href="{{route('profile.index')}}" class="btn-floating green tooltipped modal-trigger" data-position="top" data-tooltip="個人資料">
					<i class="material-icons">perm_identity</i>
				</a>
			</li>
		</ul>
	</div>

	@include('component.form.opinion')
	
	<div class="container">
		<div class="row">
			<h3 class="center-align">所有投票</h3>
			<br>
			@foreach ($opinions as $opinion)
				<div class="col s12 m4">
					<div class="card hoverable center">
						<div class="card-content">
							<h4>主題: {{ $opinion->title }}</h4>
							<div class="row">
								<h5 class="right">發布者：{{ $opinion->user->account }}</h5>
							</div>
							<div class="row">
								<h5 class="right">{{ $opinion->created_at }}</h5>
							</div>
							<a class="waves-effect waves-light btn right brown" href="{{ route('opinion.show', ['opinion' => $opinion->id]) }}">查看</a>
							<br>
						</div>
						<div class="progress">
							<div class="determinate brown" style="width:100%"></div>
						</div>
					</div>
				</div>
			@endforeach
			<ul class="pagination center">
				@if ($opinions->currentPage() > 1)
					<li class="waves-effect"><a href="{{ $opinions->previousPageUrl() }}"><i class="material-icons">chevron_left</i></a></li>
				@endif
				@for ($i = 1; $i <= $opinions->lastPage(); $i++)
					<li class="waves-effect {{ $i == $opinions->currentPage() ? 'active' : '' }}"><a href="{{ $opinions->url($i) }}">{{ $i }}</a></li>
				@endfor
				@if ($opinions->hasMorePages())
					<li class="waves-effect"><a href="{{ $opinions->nextPageUrl() }}"><i class="material-icons">chevron_right</i></a></li>
				@endif
			</ul>
		</div>
	</div>

	<br>
	
	@include('component.billboard')
		
	<br>
	
	@include('component.contact')
	
	<br>
	
    @include('component.footer')
	
</div>
<!--  Scripts-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.7.14/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-router/3.0.1/vue-router.js"></script>
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.11"></script>
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="{{ asset('js/materialize.js') }}"></script>
<script src="{{ asset('js/init.js') }}"></script>
<script type="text/javascript"></script>
</body>
</html>