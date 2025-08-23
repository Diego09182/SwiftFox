@extends('layouts.app')

@section('content')

	@include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

    @include('component.toolbar')

	<br>

	<div class="container">
        <h4 class="center-align black-text">使用者資料</h4>
        <div class="card white z-depth-3">
            <form name="ProfileForm" method="post" action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-content black-text">
                    <h5 class="brown-text text-darken-2 mb-4">
                        <strong>使用者資料 <span class="red-text">*</span> 欄位請務必填寫</strong>
                    </h5>
                    <div class="row">
                        <div class="input-field col s12">
                            <strong class="black-text">*使用者帳號：</strong>
                            <p class="grey-text text-darken-2">{{ $user->account }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m6 s12">
                            <input name="password" id="password" type="password" class="validate">
                            <label for="password">*使用者密碼</label>
                            <span class="helper-text" data-error="格式錯誤">請使用英文或數字鍵，勿使用特殊字元</span>
                        </div>
                        <div class="input-field col m6 s12">
                            <input name="new_password" id="new_password" type="password" class="validate">
                            <label for="new_password">*密碼更新</label>
                            <span class="helper-text">再次輸入新密碼，並牢記密碼</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m6 s12">
                            <input name="name" id="name" type="text" value="{{ $user->name }}" class="validate">
                            <label for="name" class="active">*使用者姓名</label>
                        </div>
                        <div class="input-field col m6 s12">
                            <input name="birthday" id="birthday" type="text" class="datepicker" value="{{ $user->birthday }}">
                            <label for="birthday" class="active">*生日</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m6 s12">
                            <input name="email" id="email" type="email" class="validate" value="{{ $user->email }}">
                            <label for="email" class="active">*E-mail</label>
                        </div>
                        <div class="input-field col m6 s12">
                            <input name="url" id="url" type="text" value="{{ $user->url }}">
                            <label for="url" class="active">個人網站</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="cellphone" id="cellphone" type="text" value="{{ $user->cellphone }}">
                            <label for="cellphone" class="active">*行動電話</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m6 s12">
                            <input name="interest" id="interest" type="text" value="{{ $user->interest }}">
                            <label for="interest" class="active">興趣</label>
                        </div>
                        <div class="input-field col m6 s12">
                            <input name="club" id="club" type="text" value="{{ $user->club }}">
                            <label for="club" class="active">社團</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea name="info" id="textarea1" class="materialize-textarea">{{ $user->info }}</textarea>
                            <label for="textarea1" class="active">自我介紹</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="file-field input-field col s12">
                            <div class="btn brown">
                                <span>上傳頭像</span>
                                <input type="file" name="avatar" id="avatar" onchange="previewImage(event)">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="選擇您的頭像文件">
                            </div>
                            <div class="center-align" style="margin-top: 1rem;">
                                @if($user->avatar)
                                    <img id="avatar-preview" src="{{ asset('storage/'.$user->avatar) }}" alt="頭像預覽" class="circle responsive-img z-depth-2" style="max-width: 150px;">
                                @else
                                    <img id="avatar-preview" src="#" alt="頭像預覽" class="circle responsive-img z-depth-2" style="display: none; max-width: 150px;">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-action center-align">
                        <button type="submit" class="btn-large brown waves-effect waves-light">
                            <i class="material-icons left">save</i> 確定送出
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const reader = new FileReader();
            reader.onload = function(){
                const img = document.getElementById('avatar-preview');
                img.src = reader.result;
                img.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }

    </script>

	<br>

    @include('component.footer')

@endsection
