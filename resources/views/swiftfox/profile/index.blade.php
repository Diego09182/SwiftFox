@extends('layouts.app')

@section('content')

<div id="app">

	@include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

	<br>

	<div class="container">
		<h4 class="center-align">使用者資料</h4>
		<div class="card">
			<form name="ProfileForm" method="post" action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<div class="card blue-grey darken-1 card">
					<div class="card-content white-text">
						<span class="card-title"><h4>使用者資料(標示「*」欄位請務必填寫)</h4></span>
						<div class="input-field col s6">
							<p><strong>*使用者帳號:</strong></p>
							<p>{{ $user->account }}</p>
						</div>
						<div class="row">
							<div class="input-field col m6">
								<h4>*使用者密碼：</h4>
								<input name="password" type="password" class="validate" value="">
								(請使用英文或數字鍵，勿使用特殊字元)
							</div>
							<div class="input-field col m6">
								<h4>*密碼更新：</h4>
								<input name="new_password" type="password" class="validate" value="">
								(再輸入一次密碼，並記下您的使用者名稱與密碼)
							</div>
						</div>
						<div class="row">
							<div class="input-field col m6">
								<h4>*使用者姓名：</h4>
								<input name="name" id="name" type="text" class="validate" value="{{ $user->name }}">
							</div>
							<div class="input-field col m6 black-text">
								<h4>*生日:</h4>
								<input name="birthday" value="{{ $user->birthday }}" type="text" class="datepicker">
							</div>
						</div>
						<div class="row">
							<div class="input-field col m6">
								<h4>*E-mail</h4>
								<input name="email" type="text" value="{{ $user->email }}">
							</div>
							<div class="input-field col m6">
								<h4>個人網站：</h4>
								<input name="url" type="text"  value="{{ $user->url }}">
							</div>
						</div>
						<div class="row">
							<div class="input-field col m12">
								<h4>*行動電話：</h4>
								<input name="cellphone" type="text" value="{{ $user->cellphone }}">
							</div>
						</div>
						<div class="row">
							<div class="input-field col m12">
								<h4>興趣：</h4>
								<input name="interest" type="text" value="{{ $user->interest }}">
							</div>
						</div>
						<div class="row">
							<div class="input-field col m12">
								<h4>社團：</h4>
								<input name="club" type="text" value="{{ $user->club }}">
							</div>
						</div>
						<div class="row">
							<div class="input-field col m12">
								<h4>自我介紹：</h4>
								<textarea name="info" id="textarea1" class="materialize-textarea">{{ $user->info }}</textarea>
							</div>
						</div>
						<div class="file-field input-field col s12 m12">
							<div class="btn brown">
								<span>上傳頭像</span>
								<input name="avatar" id="avatar" type="file">
							</div>
							<div class="file-path-wrapper">
								<input name="avatar" class="file-path validate" type="text" placeholder="選擇您的頭像文件">
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

@endsection
