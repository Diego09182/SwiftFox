@extends('layouts.app')

@section('content')

	@include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

	@include('component.toolbar')

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
				{{ $articles->links('vendor.pagination.materialize') }}
				@foreach ($articles as $article)
					<div class="col s12 m12">
						<div class="card hoverable center" id="article">
							<div class="card-content">
								<h5 class="truncate"><b>主題: {{ $article->title }}</b></h5>
								<br>
								<div class="chip left brown">
									<p class="white-text">#{{ $article->tag }}</p>
								</div>
								<p class="right"><b>作者：{{ $article->user->account }}</b></p>
								<br>
								<p class="right"><b>{{ $article->created_at }}</b></p>
								<br><br>
								<a class="waves-effect waves-light btn right brown" href="{{ route('article.show', ['article' => $article->id]) }}">查看</a>
								<br><br>
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
