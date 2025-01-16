@extends('layouts.app')

@section('content')

<div id="app">
	
	@include('component.tool')

    @include('component.navigation')

	@include('component.serve.message')
	
    @include('component.banner')

    @include('component.form.login')

    @include('component.form.register')

	<br>
	
	<router-view></router-view>
	
	<br>
	
    @include('component.contact')
	
	<br>
	
    @include('component.footer')
	
</div>

@endsection