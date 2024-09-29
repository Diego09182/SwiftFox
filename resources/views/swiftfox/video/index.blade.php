@extends('layouts.app')

@section('content')

<div id="app">
	
	@include('component.navigation')
	
    @include('component.serve.message')

    @include('component.logoutbanner')
	
	<br>

	<div class="fixed-action-btn click-to-toggle">
		<a class="btn-floating btn-large red">
			<i class="large material-icons brown">menu</i>
		</a>
		<ul>
			<li>
				<a href="#modal1" class="btn-floating red tooltipped modal-trigger" data-position="top" data-tooltip="上傳作品">
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

	@include('component.form.work')

	<div class="container">
		<div class="row">
			<h3 class="center-align">所有影片</h3>
			<br>
			<div class="row center">
				<a href="{{ route('video.create') }}" class="waves-effect waves-light btn brown"><i class="material-icons left">add</i>新增影片</a>
			</div>
			@if ($videos->isEmpty())
				<h3 class="center-align">目前沒有影片</h3>
			@else
				<div class="row">
					@foreach ($videos as $video)
						<div class="col s12 m4">
							<div class="card hoverable center" id="video">
								<div class="card-content">
									<h5 class="truncate">標題: {{ $video->title }}</h5>
									<p>上傳者: {{ $video->user->name }}</p>
									<p>上傳時間: {{ $video->created_at }}</p>
									<br>
									<a class="waves-effect waves-light btn right brown" href="{{ route('video.show', ['video' => $video->id]) }}">查看</a>
									@if(Auth::user()->administration == 5 || $video->user->id == Auth::user()->id)
										<form action="{{ route('video.destroy', $video->id) }}" method="POST">
											@csrf
											@method('DELETE')
											<button type="submit" class="waves-effect waves-light btn brown left">刪除</button>
										</form>
									@endif
									<br>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			@endif
		</div>
	</div>

	<br>
	
	@include('component.contact')
	
	<br>
	
    @include('component.footer')
	
</div>

@endsection