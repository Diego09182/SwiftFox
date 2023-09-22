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
	
	<br>
	
	<div class="container">
		<h3 class="center-align">使用者資料</h3>
		<div class="card">
			<form name="myForm" method="post" action="{{ route('profile.update', $user->id) }}">
				@csrf
				@method('PUT')
				<div class="card blue-grey darken-1 card">
					<div class="card-content white-text">
						<span class="card-title">使用者資料(標示「*」欄位請務必填寫)</span>
						<div class="input-field col s6">
							<p>*使用者帳號:</p>
							<br>
							<p>{{ $user->account }}</p>
						</div>
						<div class="row">
							<div class="input-field col m6">
								*使用者密碼：
								<input name="password" type="password" class="validate" size="10" length="10" value="">
								(請使用英文或數字鍵，勿使用特殊字元)
							</div>
							<div class="input-field col m6">
								*密碼更新：
								<input name="new_password" type="password" class="validate" size="10" length="10" value="">
								(再輸入一次密碼，並記下您的使用者名稱與密碼)
							</div>
						</div>
						<div class="row">
							<div class="input-field col m6">
								*使用者姓名：
								<input name="name"  id="name" type="text" class="validate" size="3" length="3" value="{{ $user->name }}">
							</div>
							<div class="input-field col m6 black-text">
								*生日:
								<input name="birthday" value="{{ $user->birthday }}" type="text" class="datepicker">
							</div>
						</div>
						<div class="row">
							<div class="input-field col m6">
								*E-mail
								<input name="email" type="text" size="30" length="30" value="{{ $user->email }}">
							</div>  
							<div class="input-field col m6">
								個人網站：
								<input name="url" type="text" size="40" length="40" value="{{ $user->url }}">
							</div>
						</div>
						<div class="row">
							<div class="input-field col m12">
								*行動電話：
								<input name="cellphone" type="text" size="10" length="10" value="{{ $user->cellphone }}">
							</div>
						</div>
						<div class="row">
							<div class="input-field col m12">
								興趣：
								<input name="interest" type="text" size="10" length="10" value="{{ $user->interest }}">
							</div>
						</div>
						<div class="row">
							<div class="input-field col m12">
								社團：
								<input name="club" type="text" size="5" length="5" value="{{ $user->club }}">
							</div>
						</div>
						<div class="row">
							<div class="input-field col m12">
								自我介紹：
								<textarea name="info" id="textarea1" size="30" length="30" class="materialize-textarea">{{ $user->info }}</textarea>
							</div>
						</div>
						<br>
						<div class="card-action center-align">
							<button href="{{route('profile.update')}}" type="submit" class="waves-effect waves-light btn brown">確定</button>
							<br><br>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	
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