@extends('layouts.app')

@section('content')
	
	@include('component.navigation')
	
    @include('component.serve.message')

    @include('component.logoutbanner')
	
	@include('component.toolbar')

	<div class="container">
		<div class="row">
			<h3 class="center-align">所有活動</h3>
			<br>
			@if ($activities->isEmpty())
            	<h3 class="center-align">目前沒有活動</h3>
        	@else
				<ul class="pagination center">
					@if ($activities->lastPage() > 1)
						<li class="waves-effect {{ $activities->currentPage() == 1 ? 'disabled' : '' }}">
							<a href="{{ $activities->previousPageUrl() }}"><i class="material-icons">chevron_left</i></a>
						</li>
						@for ($i = 1; $i <= $activities->lastPage(); $i++)
							@if ($i == 1 || $i == $activities->lastPage() || abs($activities->currentPage() - $i) < 3 || $i == $activities->currentPage())
								<li class="waves-effect {{ $i == $activities->currentPage() ? 'active brown' : '' }}">
									<a href="{{ $activities->url($i) }}">{{ $i }}</a>
								</li>
							@elseif (abs($activities->currentPage() - $i) === 3)
								<li class="disabled">
									<span>...</span>
								</li>
							@endif
						@endfor
						<li class="waves-effect {{ $activities->currentPage() == $activities->lastPage() ? 'disabled' : '' }}">
							<a href="{{ $activities->nextPageUrl() }}"><i class="material-icons">chevron_right</i></a>
						</li>
					@endif
				</ul>
				@foreach ($activities as $activity)
					<div class="col s12 m4">
						<div class="card" id="post">
							<div class="card-content">
								<h4 class="truncate">活動名稱:{{ $activity->title }}</h4>
								<h5>活動介紹:</h5>
								<h5>{{ $activity->content }}</h5>
								<h5>地點:</h5>
								<h5>{{ $activity->location }}</h5>
								<h5>網址:</h5>
								<h5>{{ $activity->url }}</h5>
								<h5>活動時間:</h5>
								<h5>{{ $activity->date }}</h5>
								<br>
								<h6 class="right">發布時間:{{ $activity->created_at }}</h6>
								<br><br>
								@if ($activity->url)
									<a href="{{ $activity->url }}" class="modal-action modal-close waves-effect waves-green brown btn right">前往</a>
								@endif
								@if(Auth::user()->administration == 5)
									<form action="{{ route('activity.destroy', $activity->id) }}" method="POST">
										@csrf
										@method('DELETE')
										<button type="submit" class="waves-effect waves-light btn brown left">
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