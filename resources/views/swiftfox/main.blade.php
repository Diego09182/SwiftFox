@extends('layouts.app')

@section('content')
	
	@include('component.navigation')

	@include('component.toolbar')
	
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