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

	@include('component.form.report')
	
	<br>
	
	<div class="container">
		<div class="row">
			<div class="col s12 m3">
				<div class="card">
					<div class="card-image">
						<img class="materialboxed" src="{{ asset('storage/avatars/' . $post->user->avatar_filename) }}" alt="User Avatar">
					</div>
					<div class="card-content">
						<div class="row">
							<a href="#modal2" class="modal-trigger btn-floating waves-effect waves-light brown right tooltipped" data-delay="50" data-tooltip="個人資料"><i class="material-icons">perm_identity</i></a>
						</div>
						<h5>使用者:</h5>
						<h5 class="center">{{ $post->user->account }}</h5>
					</div>
				</div>
				<ul class="collapsible" data-collapsible="accordion">
					<li>
						<div class="collapsible-header"><i class="material-icons">info</i>個人簡介</div>
						<div class="collapsible-body center"><p>{{ $post->user->info }}</p></div>
					</li>
				</ul>
			</div>
			<div class="col s12 m9 right">
				<div class="card">
					<div class="card-content center">
						<div class="row">
							<h3>{{ $post->title }}</h3>
						</div>
						<h5 id="post-content" class="post-content">{!! $post->content !!}</h5>
						<br>
						<div class="row">
							<div class="chip left brown">
								<p class="white-text">#{{ $post->tag }}</p>
							</div>
							<p class="right">觀看次數: {{ $post->view }}</p>
							<br>
							<p class="right">發文時間: {{ $post->created_at }}</p>
						</div>
						<div class="card-action">
							<div class="row">
								<p id="reaction" class="left">讚: {{ $post->like }} 噓: {{ $post->dislike }}</p>
								<button class="btn-floating waves-effect waves-light brown right tooltipped like-button" data-post-id="{{ $post->id }}" data-tooltip="按讚"><i class="material-icons">thumb_up</i></button>
								<button class="btn-floating waves-effect waves-light brown right tooltipped dislike-button" data-post-id="{{ $post->id }}" data-tooltip="噓他"><i class="material-icons">thumb_down</i></button>
								<a href="#" class="btn-floating waves-effect waves-light brown right decrease-font-size" data-tooltip="字體縮小"><i class="material-icons">zoom_out</i></a>
								<a href="#" class="btn-floating waves-effect waves-light brown right increase-font-size" data-tooltip="字體放大"><i class="material-icons">zoom_in</i></a>
							</div>
							<div class="row">
								@if(Auth::user()->administration == 5 || $post->user->id == Auth::user()->id)
									<form action="{{ route('forum.destroy', $post->id) }}" method="POST">
										@csrf
										@method('DELETE')
										<button type="submit" class="waves-effect waves-light btn brown right">
											<i class="material-icons">delete</i>
										</button>
									</form>
								@endif
								<a href="#modal3" class="btn-floating modal-trigger waves-effect waves-light brown left tooltipped" data-delay="50" data-tooltip="檢舉貼文"><i class="material-icons">report_problem</i></a>
							</div>
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
							<img class="materialboxed" src="{{ asset('storage/avatars/' . $post->user->avatar_filename) }}" alt="User Avatar">
						</div>
						<div class="card-content">
							<h5 class="center">{{ $post->user->account }}</h5>
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

	@if ($comments->isEmpty())
        <h3 class="center-align">目前沒有留言</h3>
    @else
		<ul class="pagination center">
			@if ($comments->currentPage() > 1)
				<li class="waves-effect"><a href="{{ $comments->previousPageUrl() }}"><i class="material-icons">chevron_left</i></a></li>
			@endif
			@for ($i = 1; $i <= $comments->lastPage(); $i++)
				@if ($i == 1 || $i == $comments->lastPage() || abs($comments->currentPage() - $i) < 3 || $i == $comments->currentPage())
					<li class="waves-effect {{ $i == $comments->currentPage() ? 'active brown' : '' }}"><a href="{{ $comments->url($i) }}">{{ $i }}</a></li>
				@elseif (abs($comments->currentPage() - $i) === 3)
					<li class="disabled">
						<span>...</span>
					</li>
				@endif
			@endfor
			@if ($comments->hasMorePages())
				<li class="waves-effect"><a href="{{ $comments->nextPageUrl() }}"><i class="material-icons">chevron_right</i></a></li>
			@endif
		</ul>
		@foreach ($comments as $comment)
			<div class="container">
				<ul class="collection">
					<li class="collection-item avatar">
						<br>
						<img src="{{ asset('images/SWIFT FOX LOGO.png') }}" alt="評論者頭像" class="circle">
						<span class="left">{{ $comment->title }}</span>
						<span class="right">回覆者:{{ $comment->user->account }}</span>
						<br>
						<p class="right">回覆時間:{{ $comment->created_at }}</p>
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
						<br><br><br>
					</li>
				</ul>
			</div>
		@endforeach
	@endif
	
	<br>
	
    @include('component.footer')

@endsection

@section('scripts')

<script type="text/javascript">
    // 設定所有AJAX請求的CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // 點讚按鈕事件處理
    $('.like-button').on('click', function() {
        const postId = $(this).data('post-id');

        $.ajax({
            url: "{{ route('forum.like', ['post' => 'postId']) }}".replace('postId', postId),
            type: 'POST',
            success: function(response) {
                $('#reaction').html('讚: ' + response.like + ' 噓: ' + response.dislike);
            },
            error: function(xhr) {
                if (xhr.status === 403) {
                    alert('已經評價過了');
                }
            }
        });
    });

    // 點踩按鈕事件處理
    $('.dislike-button').on('click', function() {
        const postId = $(this).data('post-id');

        $.ajax({
            url: "{{ route('forum.dislike', ['post' => 'postId']) }}".replace('postId', postId),
            type: 'POST',
            success: function(response) {
                $('#reaction').html('讚: ' + response.like + ' 噓: ' + response.dislike);
            },
            error: function(xhr) {
                if (xhr.status === 403) {
                    alert('已經評價過了');
                }
            }
        });
    });

    // 字體縮小
    $('.decrease-font-size').on('click', function(event) {
        event.preventDefault();
        let currentSize = parseInt($('#post-content').css('font-size'));
        if (currentSize > 20) {
            $('#post-content').css('font-size', (currentSize - 5) + 'px');
        }
    });

    // 字體放大
    $('.increase-font-size').on('click', function(event) {
        event.preventDefault();
        let currentSize = parseInt($('#post-content').css('font-size'));
        if (currentSize < 70) {
            $('#post-content').css('font-size', (currentSize + 5) + 'px');
        }
    });
</script>

@endsection