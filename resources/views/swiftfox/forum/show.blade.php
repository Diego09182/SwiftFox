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
				<a href="#modal1" class="btn-floating red tooltipped modal-trigger" data-position="top" data-tooltip="發布貼文">
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

	@include('component.form.comment')
	
	<br>
	<div class="container">
		<div class="row">
			<div class="col s12 m3">
				<div class="center">
					<div class="card">
						<div class="card-image">
							<img class="materialboxed" src="{{ asset('images/SWIFT FOX LOGO.png') }}">
						</div>
						<div class="card-content">
							<a href="#modal2" class="modal-trigger btn-floating waves-effect waves-light brown right tooltipped" data-delay="50" data-tooltip="個人資料"><i class="material-icons">perm_identity</i></a>
							<br><br>
							<h5>發文者:</h5>
							<h5>{{ $post->user->account }}</h5>
						</div>
					</div>
					<ul class="collapsible" data-collapsible="accordion">
						<li>
							<div class="collapsible-header"><i class="material-icons">info</i>自我介紹</div>
							<div class="collapsible-body"><p>{{ $post->user->info }}</p></div>
						</li>
					</ul>
				</div>
			</div>
			<div class="col s12 m9 right">
				<div class="card">
					<br><br>
					<div class="card-content center">
						<h3>{{ $post->title }}</h4>
						<h5>{!! $post->content !!}</h5>
						<br>
						<div class="chip left brown">
							<p class="white-text">#{{ $post->tag }}</p>
						</div>
						<p class="right">發文時間: {{ $post->created_at }}</p>
						<br><br>
						<div class="card-action">
							<p class="left">讚: {{ $post->like }}</p>
							<p class="left">噓: {{ $post->dislike }}</p>
							<form method="POST" action="{{ route('forum.dislike', $post->id) }}">
								@csrf
								<button type="submit" class="btn-floating waves-effect waves-light brown right tooltipped" data-delay="50" data-tooltip="噓他"><i class="material-icons">thumb_down</i></button>
							</form>
							<form method="POST" action="{{ route('forum.like', $post->id) }}">
								@csrf
								<button type="submit" class="btn-floating waves-effect waves-light brown right tooltipped" data-delay="50" data-tooltip="按讚"><i class="material-icons">thumb_up</i></button>
							</form>
							<a class="btn-floating waves-effect waves-light brown right" tooltipped data-delay="50" data-tooltip="字體縮小"><i class="material-icons">zoom_out</i></a>
							<a class="btn-floating waves-effect waves-light brown right" tooltipped data-delay="50" data-tooltip="字體放大"><i class="material-icons">zoom_in</i></a>
						</div>
						<br><br>
						<div class="row">
							@if(Auth::user()->administration == 5 || $post->user->id == Auth::user()->id)
								<form action="{{ route('forum.destroy', $post->id) }}" method="POST">
									@csrf
									@method('DELETE')
									<button type="submit" class="waves-effect waves-light btn brown right">
										刪除
									</button>
								</form>
							@endif
						</div>
						<div class="row">
							<a href="" class="btn-floating waves-effect waves-light brown right tooltipped" data-delay="50" data-tooltip="收藏貼文"><i class="material-icons">class</i></a>
							<a href="#modal3" class="btn-floating waves-effect waves-light brown left tooltipped" data-delay="50" data-tooltip="檢舉貼文"><i class="material-icons">report_problem</i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="modal2" class="modal">
		<div class="modal-content">
			<h4 class="center-align">個人資料</h4>
			<div class="row">
				<div class="col s12 m4">
					<div class="card">
						<div class="card-image">
							<img  src="{{ asset('images/SWIFT FOX LOGO.png') }}">
						</div>
						<div class="card-content">
							<h5>使用者: {{ $post->user->account }}</h5>
						</div>
					</div>
				</div>
				<div class="col s12 m8">
					<div class="card">
						<div class="card-content">
							<h5>個人簡介:</h5>
							<h5>{{ $post->user->info }}</h5>
							<h5>興趣: {{ $post->user->interest }}</h5>
							<h5>社團: {{ $post->user->club }}</h5>
							<h5>上站次數: {{ $post->user->times }}</h5>
							<h5>個人網站:</h5>
							@if ($post->user->url)
								<h5>{{ $post->user->url }}</h5>
								<a href="{{ $post->user->url }}" class="modal-action modal-close waves-effect waves-green brown btn right">前往</a>
							@endif
							<br>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

    <br>

	<div class="container">
		<ul class="collection">
			<li class="collection-item avatar">
				<img src="{{ asset('images/SWIFT FOX LOGO.png') }}" alt="評論者頭像" class="circle">
				<span class="title left">發問前先查閱相關內容</span>
				<span class="author right">發文者: 系統管理員</span>
				<br>
				<p class="right"></p>
				<br>
				<hr>
				<p class="left">記得遵守社群守則</p>
				<br>
				<br>
				<br>
			</li>
		</ul>
	</div>

	@foreach ($comments as $comment)
		<div class="container">
			<ul class="collection">
				<li class="collection-item avatar">
					<img src="{{ asset('images/SWIFT FOX LOGO.png') }}" alt="評論者頭像" class="circle">
					<span class="title left">{{ $comment->title }}</span>
					<span class="right">{{ $comment->user->account }}</span>
					<br>
					<p class="right">{{ $comment->created_at }}</p>
					<br>
					<form action="{{ route('comment.destroy', ['post' => $post->id, 'comment' => $comment->id]) }}" method="POST">
						@csrf
						@method('DELETE')
						<button type="submit" class="btn-floating waves-effect waves-light brown right tooltipped" data-delay="50" data-tooltip="刪除評論">
							<i class="material-icons">delete</i>
						</button>
					</form>
					<br><br>
					<hr>
					<p class="left">{{ $comment->content }}</p>
					<br>
					<br>
					<br>
				</li>
			</ul>
		</div>
	@endforeach

	<ul class="pagination center">
		@if ($comments->currentPage() > 1)
			<li class="waves-effect"><a href="{{ $comments->previousPageUrl() }}"><i class="material-icons">chevron_left</i></a></li>
		@endif
		@for ($i = 1; $i <= $comments->lastPage(); $i++)
			<li class="waves-effect {{ $i == $comments->currentPage() ? 'active' : '' }}"><a href="{{ $comments->url($i) }}">{{ $i }}</a></li>
		@endfor
		@if ($comments->hasMorePages())
			<li class="waves-effect"><a href="{{ $comments->nextPageUrl() }}"><i class="material-icons">chevron_right</i></a></li>
		@endif
	</ul>

	@include('component.billboard')
	
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