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
				<a href="#modal1" class="btn-floating red tooltipped modal-trigger" data-position="top" data-tooltip="發布日記">
					<i class="material-icons">mode_edit</i>
				</a>
			</li>
			<li>
				<a href="{{route('home.index')}}" class="btn-floating yellow tooltipped modal-trigger" data-position="top" data-tooltip="我的小屋">
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
				<div class="card-panel teal brown" id="note-panel">
					<h4 class="white-text center"><b>日誌列表</b></h4>
					<hr>
					@if ($notes->currentPage() > 1)
						<ul class="pagination center">
							@if ($notes->currentPage() > 1)
								<li class="waves-effect"><a href="{{ $notes->previousPageUrl() }}"><i class="material-icons">chevron_left</i></a></li>
							@endif
							@for ($i = 1; $i <= $notes->lastPage(); $i++)
								@if ($i == 1 || $i == $notes->lastPage() || abs($notes->currentPage() - $i) < 3 || $i == $notes->currentPage())
									<li class="waves-effect {{ $i == $notes->currentPage() ? 'active brown' : '' }}"><a href="{{ $notes->url($i) }}">{{ $i }}</a></li>
								@elseif (abs($notes->currentPage() - $i) === 3)
									<li class="disabled">
										<span>...</span>
									</li>
								@endif
							@endfor
							@if ($notes->hasMorePages())
								<li class="waves-effect"><a href="{{ $notes->nextPageUrl() }}"><i class="material-icons">chevron_right</i></a></li>
							@endif
						</ul>
					@endif
					@if ($notes->count() > 0)
						@foreach ($notes as $note)
							<ul class="collection">
								<li class="collection-item avatar">
									@if ($user->avatar_filename)
										<img class="circle" src="{{ asset('storage/avatars/' . $user->avatar_filename) }}" alt="User Avatar">
									@else
										<img class="circle" src="{{ asset('images/SWIFT FOX LOGO.png') }}" alt="User Avatar">
									@endif
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
					@endif
				</div>
			</div>
			<div class="col s12 m3">
				<div class="card">
					<div class="card-image">
						@if ($user->avatar_filename)
							<img src="{{ asset('storage/avatars/' . $user->avatar_filename) }}" alt="User Avatar">
						@else
							<img class="materialboxed" src="{{ asset('images/SWIFT FOX LOGO.png') }}" alt="Default Avatar">
						@endif
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
				<div class="col s12 card-panel right">
					<h5 class="card-title grey-text text-darken-4">自我介紹:</h5>
					<h5>{{ $user->info }}</h5>
					<br>
					<h5 class="card-title grey-text text-darken-4">興趣:</h5>
					<h5>{{ $user->interest }}</h5>
					<br>
					<h5 class="card-title grey-text text-darken-4">社團:</h5>
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

@endsection