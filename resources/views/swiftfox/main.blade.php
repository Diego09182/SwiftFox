@extends('layouts.app')

@section('content')
	
	@include('component.navigation')

	<div class="fixed-action-btn click-to-toggle">
		<a class="btn-floating btn-large">
			<i class="large material-icons brown">menu</i>
		</a>
		<ul>
			<li>
				<a href="{{route('home.index')}}"class="btn-floating yellow tooltipped" data-position="top" data-tooltip="我的小屋">
					<i class="material-icons">view_quilt</i>
				</a>
			</li>
			<li>
				<a href="{{route('profile.index')}}" class="btn-floating green tooltipped" data-position="top" data-tooltip="個人資料">
					<i class="material-icons">perm_identity</i>
				</a>
			</li>
		</ul>
	</div>
	
    @include('component.serve.message')

    @include('component.logoutbanner')

    @include('component.function')

	@include('component.statistics')
	
	<br>

	@include('component.billboard')
	
	<br>
	
	@include('component.contact')
	
	<br>
	
    @include('component.footer')
	
</div>

@endsection