@extends('layouts.app')

@section('content')

<div id="app">

	@include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

    <div class="container">
        <div class="card white">
            <form name="WorkForm" method="post" action="{{ route('work.store') }}">
                @csrf
                <div class="card-content">
                    <span class="card-title black-text">創建作品集</span>
                    <div class="row">
                        <div class="input-field col m12">
                            <i class="material-icons prefix black-text">mode_edit</i>
                            <input class="validate black-text" name="name" type="text" value="{{ old('name') }}">
                            <label for="icon_prefix2" class="black-text">作品集名稱</label>
                            @error('name')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button class="waves-effect waves-light btn brown right" type="submit">發布作品</button>
                    <br>
                </div>
            </form>
        </div>
    </div>

	<br>

	@include('component.contact')

	<br>

    @include('component.footer')

</div>

@endsection
