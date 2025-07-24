@extends('layouts.app')

@section('content')

	@include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

    <div class="container">
        <div class="card white">
            <form name="OpinionForm" method="post" action="{{ route('opinion.store') }}">
                @csrf
                <div class="card-content black-text">
                    <span class="card-title">發表投票</span>

                    <div class="row">
                        <div class="input-field col m8">
                            <i class="material-icons prefix black-text">mode_edit</i>
                            <input class="validate black-text" name="title" type="text" value="{{ old('title') }}">
                            <label for="title" class="black-text">投票主題</label>
                            @error('title')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field col m4">
                            <i class="material-icons prefix black-text">date_range</i>
                            <input name="finished_time" type="text" id="icon_prefix" class="datepicker black-text" value="{{ old('finished_time') }}">
                            <label for="icon_prefix" class="black-text">投票結束時間</label>
                            @error('finished_time')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col m12">
                            <i class="material-icons prefix black-text">mode_edit</i>
                            <textarea class="materialize-textarea black-text" name="content">{{ old('content') }}</textarea>
                            <label for="content" class="black-text">內容</label>
                            @error('content')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <button class="waves-effect waves-light btn brown right" type="submit">發表投票</button>
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
