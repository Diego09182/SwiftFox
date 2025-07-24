@extends('layouts.app')

@section('content')

<div id="app">

	@include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

	<br>

	@include('component.toolbar')

	<div class="container">
		<div class="row">
			<h3 class="center-align  wow animate__animated animate__fadeInUp animate__delay-2s">所有影片</h3>
			<br>
			<div class="row center">
				<a href="{{ route('video.create') }}" class="waves-effect waves-light btn brown"><i class="material-icons left">add</i>新增影片</a>
			</div>
			@if ($videos->isEmpty())
				<h3 class="center-align  wow animate__animated animate__fadeInUp animate__delay-2s">目前沒有影片</h3>
			@else
				{{ $videos->links('vendor.pagination.materialize') }}
				<div class="row">
					@foreach ($videos as $video)
						<div class="col s12 m4  wow animate__animated animate__fadeInUp animate__delay-2s">
							<div class="card hoverable center" id="video">
								<div class="card-content">
									<h5 class="truncate">標題: {{ $video->title }}</h5>
									<p>上傳者: {{ $video->user->account }}</p>
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
