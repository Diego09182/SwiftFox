@extends('layouts.app')

@section('content')

<div id="app">
	
	@include('component.navigation')
	
    @include('component.serve.message')

    @include('component.logoutbanner')

	@include('component.toolbar')
	
	<div class="container">
		<div class="row">
			<h3 class="center-align">所有投票</h3>
			<br>
			<div class="row center">
				<a href="{{ route('opinion.create') }}" class="waves-effect waves-light btn brown"><i class="material-icons left">mode_edit</i>發表</a>
			</div>
			@if ($opinions->isEmpty())
            	<h3 class="center-align">目前沒有投票事項</h3>
        	@else
				<ul class="pagination center">
					@if ($opinions->currentPage() > 1)
						<li class="waves-effect"><a href="{{ $opinions->previousPageUrl() }}"><i class="material-icons">chevron_left</i></a></li>
					@endif
					@for ($i = 1; $i <= $opinions->lastPage(); $i++)
						@if ($i == 1 || $i == $opinions->lastPage() || abs($opinions->currentPage() - $i) < 3 || $i == $opinions->currentPage())
							<li class="waves-effect {{ $i == $opinions->currentPage() ? 'active brown' : '' }}"><a href="{{ $opinions->url($i) }}">{{ $i }}</a></li>
						@elseif (abs($opinions->currentPage() - $i) === 3)
							<li class="disabled">
								<span>...</span>
							</li>
						@endif
					@endfor
					@if ($opinions->hasMorePages())
						<li class="waves-effect"><a href="{{ $opinions->nextPageUrl() }}"><i class="material-icons">chevron_right</i></a></li>
					@endif
				</ul>
				@foreach ($opinions as $opinion)
					<div class="col s12 m4">
						<div class="card hoverable center">
							<div class="card-content">
								<h4 class="truncate">主題: {{ $opinion->title }}</h4>
								<br>
								@if ($opinion->status == 1)
									<div class="chip left green">
										<p class="black-text">#進行中</p>
									</div>
								@else
									<div class="chip left brown">
										<p class="white-text">#已結束</p>
									</div>
								@endif
								<br>
								<div class="row">
									<h5 class="right">發布者：{{ $opinion->user->account }}</h5>
								</div>
								<div class="row">
									<h5 class="right">創建時間: {{ $opinion->created_at }}</h5>
									<h5 class="right">結束時間: {{ $opinion->finished_time }}</h5>
								</div>
								<a class="waves-effect waves-light btn right brown" href="{{ route('opinion.show', ['opinion' => $opinion->id]) }}">查看</a>
								<br>
							</div>
							<div class="progress">
								@if ($opinion->status == 1)
									<div class="determinate green" style="width:100%"></div>
								@else
									<div class="determinate brown" style="width:100%"></div>
								@endif
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