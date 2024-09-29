@extends('layouts.app')

@section('content')
	
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
				<a href="#modal1" class="btn-floating red tooltipped modal-trigger" data-position="top" data-tooltip="上傳圖片">
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

	@include('component.form.photo')

	<div class="container">
		<div class="row">
			<h3 class="center-align">作品展示:</h3>
			<br>
			<div class="row center">
				<a href="{{ route('photo.create', $work->id) }}" class="waves-effect waves-light btn brown"><i class="material-icons left">mode_edit</i>發表</a>
			</div>
			@if ($photos->isEmpty())
            	<h3 class="center-align">此作品集目前沒有任何作品。</h3>
        	@else
				@foreach ($photos as $photo)
					<div class="col s12 m4">
						<div class="card">
							<div class="card-image">
								<img alt="photo" class="responsive-img materialboxed" src="{{ asset('storage/'.$photo->path) }}">
								<a class="btn-floating halfway-fab waves-effect waves-light brown" href="{{ route('photo.show', ['work' => $photo->work_id, 'photo' => $photo->id]) }}"><i class="material-icons">search</i></a>
							</div>
							<div class="card-content">
								<h4>作品名稱:</h4>
								<h4>{{ $photo->name }}</h4>
							</div>
							<div class="card-action">
								<a class="waves-effect waves-light btn right brown" href="{{ route('photo.show', ['work' => $photo->work_id, 'photo' => $photo->id]) }}">查看</a>
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
			@endif
		</div>
	</div>
		
	<br>
	
	@include('component.contact')
	
	<br>
	
    @include('component.footer')
	
</div>

@endsection