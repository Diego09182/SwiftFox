@extends('layouts.app')

@section('content')

<div id="app">

    @include('component.tool')

    @include('component.navigation')

    @include('component.serve.message')

    @include('component.form.login')

    @include('component.form.register')

    <br>

    @include('component.registration')

    <router-view></router-view>

</div>

<br>

@include('component.contact')

<br>

@include('component.footer')

@endsection
