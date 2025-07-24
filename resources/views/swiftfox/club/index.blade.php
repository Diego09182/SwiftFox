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
			<h3 class="center-align  wow animate__animated animate__fadeInUp animate__delay-2s">社團介紹</h3>
			<br>
			@if ($clubs->isEmpty())
            	<h3 class="center-align  wow animate__animated animate__fadeInUp animate__delay-2s">目前沒有社團</h3>
        	@else
				{{ $clubs->links('vendor.pagination.materialize') }}
				@foreach ($clubs as $club)
					<div class="col s12 m4  wow animate__animated animate__fadeInUp animate__delay-2s">
						<div class="card" id="post">
							<div class="card-content">
								<h5 class="truncate">社團名稱:{{ $club->title }}</h5>
								<br>
								<div class="chip left brown">
									<p class="white-text">#{{ $club->tag }}</p>
								</div>
								<br><br>
								<h5>社團介紹:</h5>
								<h5>{{ $club->content }}</h5>
								<h5>社長:{{ $club->director }}</h5>
								<h5>副社長:{{ $club->vice_director }}</h5>
								<h5>指導教師:{{ $club->teacher }}</h5>
								<br>
								<h6 class="right">{{ $club->created_at }}</h6>
								<br><br>
								@if(Auth::user()->administration == 5)
									<form action="{{ route('club.destroy', $club->id) }}" method="POST">
										@csrf
										@method('DELETE')
										<button type="submit" class="waves-effect waves-light btn brown right">
											<i class="material-icons">delete</i>
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
