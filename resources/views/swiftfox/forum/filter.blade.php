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

	@include('component.form.post')

	<div class="container">
		<div class="row">
			<form action="{{ route('forum.search') }}" method="GET">
				<div class="input-field col m12">
					<i class="material-icons prefix">search</i>
					<input name="search" id="icon_prefix" type="text" class="validate">
					<label for="icon_prefix">Search</label>
				</div>
			</form>
		</div>
		<div class="row">
			<form action="{{ route('forum.filter') }}" method="GET">
				<div class="input-field col m4">
					<select name="filter">
						<option value="" disabled selected>熱度篩選</option>
						<option value="觀看次數">觀看次數</option>
						<option value="喜歡次數">喜歡次數</option>
					</select>
					<label>熱度篩選</label>
				</div>
				<div class="input-field">
					<button type="submit" class="btn waves-effect waves-light brown right">貼文篩選</button>
				</div>
			</form>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<h3 class="center-align">搜尋結果</h3>
			<br>
			<ul class="pagination center">
				@if ($posts->lastPage() > 1)
					<li class="waves-effect {{ $posts->currentPage() == 1 ? 'disabled' : '' }}">
						<a href="{{ $posts->previousPageUrl() }}"><i class="material-icons">chevron_left</i></a>
					</li>
					@for ($i = 1; $i <= $posts->lastPage(); $i++)
						@if ($i == 1 || $i == $posts->lastPage() || abs($posts->currentPage() - $i) < 3 || $i == $posts->currentPage())
							<li class="waves-effect {{ $i == $posts->currentPage() ? 'active brown' : '' }}">
								<a href="{{ $posts->appends(request()->except('page'))->appends(['page' => $i])->appends(['filter' => request()->query('filter')])->url($i) }}">{{ $i }}</a>
							</li>
						@elseif ((($i == $posts->currentPage() - 3) || ($i == $posts->currentPage() + 3)) && abs($posts->currentPage() - $i) > 3)
							<li class="disabled">
								<span>...</span>
							</li>
						@endif
					@endfor
					<li class="waves-effect {{ $posts->currentPage() == $posts->lastPage() ? 'disabled' : '' }}">
						<a href="{{ $posts->nextPageUrl() }}"><i class="material-icons">chevron_right</i></a>
					</li>
				@endif
			</ul>
			@if(count($posts) > 0)
				@foreach ($posts as $post)
					<div class="col s12 m4">
						<div class="card hoverable center" id="post">
							<div class="card-content">
								<h5 class="truncate"><b>主題: {{ $post->title }}</b></h5>
								<br>
								<div class="chip left brown">
									<p class="white-text">#{{ $post->tag }}</p>
								</div>
								<br>
								<p class="right">作者：{{ $post->user->account }}</p>
								<br><br>
								<div class="row">
									<p class="left">讚:{{ $post->like }}</p>
									<p class="left">噓:{{ $post->dislike }}</p>
								</div>
								<div class="row">
									<p class="left">觀看數:{{ $post->view }}</p>
									<p class="right">{{ $post->created_at }}</p>
								</div>
									<a class="waves-effect waves-light btn right brown" href="{{ route('forum.show', ['post' => $post->id]) }}">查看</a>
								<br>
							</div>
						</div>
					</div>
				@endforeach
			@else
				<h3 class="center-align">沒有搜尋到相關貼文</h3>
			@endif
		</div>
	</div>
	
	<br>
	
	@include('component.contact')
	
	<br>
	
    @include('component.footer')
	
</div>

@endsection