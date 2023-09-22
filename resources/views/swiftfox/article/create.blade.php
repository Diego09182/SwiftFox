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
				<a href="{{ route('article.create') }}" class="btn-floating red tooltipped modal-trigger" data-position="top" data-tooltip="發布文章">
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

	<div class="container">
		<div class="card blue-grey darken-1 card">
			<form name="ArticleForm" method="post" action="{{ route('article.store') }}">
				@csrf
				<div class="card-content white-text">
					<span class="card-title">發表文章</span>
					<div class="row">
						<div class="input-field col m5 right">
							<h5>帳號:{{ Auth::user()->account }}</h5>
						</div>
					</div>
					<div class="row">
						<div class="input-field col m8">
							<i class="material-icons prefix">mode_edit</i>
							<input class="validate" name="title" type="text" size="10" length="10">
							<label for="icon_prefix2">主題</label>
						</div>
						<div class="input-field col m4">
							<select name="tag">
								<option value="" disabled selected>選擇文章標籤</option>
								<option value="大學面試">大學面試</option>
								<option value="競賽經驗">競賽經驗</option>
								<option value="學習歷程">學習歷程</option>
								<option value="活動分享">活動分享</option>
							</select>
							<label>文章標籤</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col m12">
							<div class="input-field">
								<i class="material-icons prefix">mode_edit</i>
								<textarea class="materialize-textarea" name="content" size="300" length="300"></textarea>
								<label for="icon_prefix2">內容</label>
							</div>
						</div>
					</div>
					<button class="waves-effect waves-light btn brown right" type="submit">發布文章</button>
					<br>
				</div>
			</form>
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