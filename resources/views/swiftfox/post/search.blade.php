@extends('layouts.app')

@section('content')

<div id="app">

	@include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

	@include('component.toolbar')

    @include('component.searchpanel')

	<div class="container">
		<div class="row">
			<h3 class="center-align">搜尋結果</h3>
			<br>
			{{ $posts->links('vendor.pagination.materialize') }}
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
