@extends('layouts.app')

@section('content')

<div id="app">

	@include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

    @include('component.toolbar')

	<div class="container">
		<div class="row">
			<form action="{{ route('article.search') }}" method="GET">
				<div class="input-field col m12">
					<i class="material-icons prefix">search</i>
					<input name="search" value="{{ $search }}" id="icon_prefix" type="text" class="validate">
					<label for="icon_prefix">Search</label>
				</div>
			</form>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<h3 class="center-align">搜尋結果</h3>
			<br>
			<div class="row center">
				<a href="{{ route('article.create') }}" class="waves-effect waves-light btn brown"><i class="material-icons left">mode_edit</i>發表</a>
			</div>
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
			@if(count($articles) > 0)
				@foreach ($articles as $article)
					<div class="col s12 m4">
						<div class="card hoverable center" id="article">
							<div class="card-content">
								<h5 class="truncate">主題: {{ $article->title }}</h5>
								<br>
								<div class="chip left brown">
									<p class="white-text">#{{ $article->tag }}</p>
								</div>
								<p class="right">作者：{{ $article->user->account }}</p>
								<br><br><br><br>
								<div class="right">{{ $article->created_at }}</div>
								<br><br>
								<a class="waves-effect waves-light btn right brown" href="{{ route('article.show', ['article' => $article->id]) }}">查看</a>
								<br>
							</div>
						</div>
					</div>
				@endforeach
			@else
				<h3 class="center-align">沒有搜尋到相關文章</h3>
			@endif
		</div>
	</div>

	<br>

	@include('component.contact')

	<br>

    @include('component.footer')

</div>

@endsection
