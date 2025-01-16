@extends('layouts.app')

@section('content')

<div id="app">
	
	@include('component.navigation')
	
    @include('component.serve.message')

    @include('component.logoutbanner')
	
	<br>

	<div class="container">
		<h4 class="center">作品名稱:</h4>
		<h4 class="center">{{ $photo->name }}</h4>
		<div class="row">
			<div class="col s12 m3">
				<div class="center">
					<div class="card">
						<div class="card-image">
							<img class="materialboxed" src="{{ asset('storage/avatars/' . $user->avatar_filename) }}" alt="User Avatar">
						</div>
						<div class="card-content">
							<a href="#modal2" class="modal-trigger btn-floating waves-effect waves-light brown right tooltipped" data-delay="50" data-tooltip="個人資料"><i class="material-icons">perm_identity</i></a>
							<br><br>
							<h5>發文者:</h5>
							<h5>{{ $photo->user->account }}</h5>
						</div>
					</div>
					<ul class="collapsible" data-collapsible="accordion">
						<li>
							<div class="collapsible-header"><i class="material-icons">info</i>自我介紹</div>
							<div class="collapsible-body"><p>{{ $photo->user->info }}</p></div>
						</li>
					</ul>
				</div>
			</div>
			<div class="col s12 m9">
				<div class="card horizontal">
					<div class="card-image">
						<img class="responsive-img materialboxed" alt="avatar" src="{{ asset('storage/photos/' . $photo->filename) }}" alt="Photo">
					</div>
					<div class="card-stacked">
						<div class="card-content">
							<h4>作品描述:</h4>
							<h4>{{ $photo->content }}</h4>
						</div>
						<div class="card-action">
							@if(Auth::user()->administration == 5 || $photo->user->id == Auth::user()->id)
								<form action="{{ route('photo.destroy', ['work' => $photo->work_id, 'photo' => $photo->id]) }}" method="POST">
									@csrf
									@method('DELETE')
									<button type="submit" class="btn-floating waves-effect waves-light brown right">
										<i class="material-icons">delete</i>
									</button>
								</form>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<h3 class="center-align">其他作品:</h3>
			<br>
			@foreach ($photos as $photo)
				<div class="col s12 m4">
					<div class="card">
						<div class="card-image">
							<img class="responsive-img materialboxed" alt="photo" src="{{ asset('storage/'.$photo->path) }}">
							@if(Auth::user()->administration == 5 || $photo->user->id == Auth::user()->id)
								<a class="btn-floating halfway-fab waves-effect waves-light brown" href="{{ route('photo.show', ['work' => $photo->work_id, 'photo' => $photo->id]) }}"><i class="material-icons">search</i></a>
							@endif
						</div>
						<div class="card-content">
							<h4>作品名稱:</h4>
							<h4>{{ $photo->name }}</h4>
						</div>
						<div class="card-action">
							@if(Auth::user()->administration == 5 || $photo->user->id == Auth::user()->id)
								<form action="{{ route('photo.destroy', ['work' => $photo->work_id, 'photo' => $photo->id]) }}" method="POST">
									@csrf
									@method('DELETE')
									<button type="submit" class="waves-effect waves-light btn brown right">
										刪除
									</button>
								</form>
							@endif
							<br><br>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>

	<div id="modal2" class="modal">
		<div class="modal-content">
			<h4 class="center-align">個人資料</h4>
			<div class="row">
				<div class="col s12 m4">
					<div class="card">
						<div class="card-image">
							<img class="materialboxed" src="{{ asset('storage/avatars/' . $user->avatar_filename) }}" alt="User Avatar">
						</div>
						<div class="card-content">
							<h5>使用者: {{ $work->user->account }}</h5>
						</div>
					</div>
				</div>
				<div class="col s12 m8">
					<div class="card">
						<div class="card-content">
							<h5>個人簡介:</h5>
							<h5>{{ $work->user->info }}</h5>
							<h5>興趣: {{ $work->user->interest }}</h5>
							<h5>社團: {{ $work->user->club }}</h5>
							<h5>上站次數: {{ $work->user->times }}</h5>
							<h5>個人網站:</h5>
							@if ($work->user->url)
								<h5>{{ $work->user->url }}</h5>
								<a href="{{ $work->user->url }}" class="modal-action modal-close waves-effect waves-green brown btn right">前往</a>
							@endif
							<br>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
		
	<br>
	
	@include('component.contact')
	
	<br>
	
    @include('component.footer')
	
</div>

@endsection