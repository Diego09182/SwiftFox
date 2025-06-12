@extends('layouts.app')

@section('content')

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
		<div class="card">
			<form name="ArticleForm" method="post" action="{{ route('article.store') }}">
				@csrf
				<div class="card-content black-text">
					<span class="card-title">發表文章</span>
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
								<textarea class="materialize-textarea" name="content"></textarea>
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

	@include('component.contact')

	<br>

    @include('component.footer')

</div>

@endsection
