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
				<a href="#modal1" class="btn-floating red tooltipped modal-trigger" data-position="top" data-tooltip="發布日記">
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
	
	@include('component.form.note')
	
	<br>

	<div class="container">
		<div class="row">
			<div class="col s12 m9">
				<div class="card-panel teal brown">
					<h4 class="white-text center">我的日誌</h4>
					<hr>
					@foreach ($notes as $note)
						<ul class="collection">
							<li class="collection-item avatar">
								<img src="{{ asset('images/SWIFT FOX LOGO.png') }}" alt="評論者頭像" class="circle">
								<h5 class="left">日記主題:{{ $note->title }}</h5>
								<br><br>
								<div class="row">
									<form action="{{ route('note.destroy', ['note' => $note->id ]) }}" method="POST">
										@csrf
										@method('DELETE')
										<button type="submit" class="btn-floating waves-effect waves-light brown right tooltipped" data-delay="50" data-tooltip="刪除日記">
											<i class="material-icons">delete</i>
										</button>
									</form>
								</div>
								<hr>
								<p class="right">發表時間:{{ $note->created_at }}</p>
								<br><br>
								<a href="{{ route('note.show', ['note' => $note->id]) }}" class="btn waves-effect waves-light brown right tooltipped" data-delay="50" data-tooltip="查看日記">
									查看
								</a>
								<br><br>
							</li>
						</ul>
					@endforeach
					<ul class="pagination center">
						@if ($notes->currentPage() > 1)
							<li class="waves-effect"><a href="{{ $notes->previousPageUrl() }}"><i class="material-icons">chevron_left</i></a></li>
						@endif
						@for ($i = 1; $i <= $notes->lastPage(); $i++)
							<li class="waves-effect {{ $i == $notes->currentPage() ? 'active' : '' }}"><a href="{{ $notes->url($i) }}">{{ $i }}</a></li>
						@endfor
						@if ($notes->hasMorePages())
							<li class="waves-effect"><a href="{{ $notes->nextPageUrl() }}"><i class="material-icons">chevron_right</i></a></li>
						@endif
					</ul>
				</div>
			</div>
			<div class="col s12 m3">
				<div class="card">
					<div class="card-image">
						<img class="responsive-img" src="{{ asset('images/SWIFT FOX LOGO.png') }}">
					</div>
					<div class="card-content">
						<span class="card-title activator grey-text text-darken-4"><i class="material-icons right">more_vert</i></span>
						<h5>{{ $user->account }}</h5>
					</div>
					<div class="card-reveal">
						<span class="card-title grey-text text-darken-4">使用者頭像<i class="material-icons right">close</i></span>
						<p>會顯示於發文者區塊</p>
					</div>
				</div>
				<div class="card-panel right">
					<h5 class="card-title grey-text text-darken-4 center">自我介紹</h5>
					<h5>{{ $user->info }}</h5>
					<h5 class="card-title grey-text text-darken-4 center">興趣</h5>
					<h5>{{ $user->interest }}</h5>
					<h5 class="card-title grey-text text-darken-4 center">社團</h5>
					<h5>{{ $user->club }}</h5>
					<br>
					<h5>登入次數: {{ $user->times }}</h5>
					<br>
					<h5>日記數量: {{ $totalPosts }}</h5>
					<br>
					<h5>文章數量: {{ $totalNotes }}</h5>
					<br>
				</div>
			</div>
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