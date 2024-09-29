@extends('layouts.app')

@section('content')
	
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
		<div class="row">
			<form action="{{ route('article.search') }}" method="GET">
				<div class="input-field col m12">
					<i class="material-icons prefix">search</i>
					<input name="search" id="icon_prefix" type="text" class="validate">
					<label for="icon_prefix">Search</label>
				</div>
			</form>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<h3 class="center-align">所有文章</h3>
			<br>
			<div class="row center">
				<a href="{{ route('article.create') }}" class="waves-effect waves-light btn brown"><i class="material-icons left">mode_edit</i>發表</a>
			</div>
			@if ($articles->isEmpty())
            	<h3 class="center-align">目前沒有文章</h3>
        	@else
				<ul class="pagination center">
					@if ($articles->currentPage() > 1)
						<li class="waves-effect"><a href="{{ $articles->previousPageUrl() }}"><i class="material-icons">chevron_left</i></a></li>
					@endif
					@for ($i = 1; $i <= $articles->lastPage(); $i++)
						@if ($i == 1 || $i == $articles->lastPage() || abs($articles->currentPage() - $i) < 3 || $i == $articles->currentPage())
							<li class="waves-effect {{ $i == $articles->currentPage() ? 'active brown' : '' }}"><a href="{{ $articles->url($i) }}">{{ $i }}</a></li>
						@elseif (abs($articles->currentPage() - $i) === 3)
							<li class="disabled">
								<span>...</span>
							</li>
						@endif
					@endfor
					@if ($articles->hasMorePages())
						<li class="waves-effect"><a href="{{ $articles->nextPageUrl() }}"><i class="material-icons">chevron_right</i></a></li>
					@endif
				</ul>
				@foreach ($articles as $article)
					<div class="col s12 m12">
						<div class="card hoverable center" id="article">
							<div class="card-content">
								<h5 class="truncate">主題: {{ $article->title }}</h5>
								<br>
								<div class="chip left brown">
									<p class="white-text">#{{ $article->tag }}</p>
								</div>
								<p class="right">作者：{{ $article->user->account }}</p>
								<br>
								<div class="right">{{ $article->created_at }}</div>
								<br>
								<a class="waves-effect waves-light btn right brown" href="{{ route('article.show', ['article' => $article->id]) }}">查看</a>
								<br>
							</div>
						</div>
					</div>
				@endforeach
			@endif
		</div>
	</div>
		
	<br>
	
	@include('component.contact')
	
	<br>
	
    @include('component.footer')
	
</div>

@endsection