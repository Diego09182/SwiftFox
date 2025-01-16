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
			<h3 class="center-align">所有作品</h3>
			<br>
			<div class="row center">
				<a href="{{ route('work.create') }}" class="waves-effect waves-light btn brown"><i class="material-icons left">mode_edit</i>發表</a>
			</div>
			@if ($works->isEmpty())
            	<h3 class="center-align">目前沒有作品集</h3>
        	@else
				<ul class="pagination center">
					@if ($works->currentPage() > 1)
						<li class="waves-effect"><a href="{{ $works->previousPageUrl() }}"><i class="material-icons">chevron_left</i></a></li>
					@endif
					@for ($i = 1; $i <= $works->lastPage(); $i++)
						@if ($i == 1 || $i == $works->lastPage() || abs($works->currentPage() - $i) < 3 || $i == $works->currentPage())
							<li class="waves-effect {{ $i == $works->currentPage() ? 'active brown' : '' }}"><a href="{{ $works->url($i) }}">{{ $i }}</a></li>
						@elseif (abs($works->currentPage() - $i) === 3)
							<li class="disabled">
								<span>...</span>
							</li>
						@endif
					@endfor
					@if ($works->hasMorePages())
						<li class="waves-effect"><a href="{{ $works->nextPageUrl() }}"><i class="material-icons">chevron_right</i></a></li>
					@endif
				</ul>
				@foreach ($works as $work)
					<div class="col s12 m4">
						<div class="card hoverable center" id="work">
							<div class="card-content">
								<h5 class="truncate">主題: {{ $work->name }}</h5>
								<br><br>
								<p class="right">作者：{{ $work->user->account }}</p>
								<br><br>
								<p class="right">{{ $work->created_at }}</p>
								<br><br>
								<a class="waves-effect waves-light btn right brown" href="{{ route('work.show', ['work' => $work->id]) }}">查看</a>
								@if(Auth::user()->administration == 5 || $work->user->id == Auth::user()->id)
									<form action="{{ route('work.destroy', $work->id) }}" method="POST">
										@csrf
										@method('DELETE')
										<button type="submit" class="waves-effect waves-light btn brown left">
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