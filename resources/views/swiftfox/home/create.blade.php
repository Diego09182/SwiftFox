@extends('layouts.app')

@section('content')

<div id="app">

	@include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

	<div class="container">
        <div class="card white">
            <form name="NoteForm" method="post" action="{{ route('note.store') }}">
                <div class="card-content black-text">
                    @csrf
                    <span class="card-title">發布日記</span>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <i class="material-icons prefix">mode_edit</i>
                            <input name="title" id="title" type="text" class="validate" value="{{ old('title') }}">
                            <label for="title">日記主題</label>
                            @error('title')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="material-icons prefix">mode_edit</i>
                            <input name="tag" id="tag" type="text" class="validate" value="{{ old('tag') }}">
                            <label for="tag">日記標籤</label>
                            @error('tag')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">mode_edit</i>
                            <textarea name="content" id="content" class="materialize-textarea">{{ old('content') }}</textarea>
                            <label for="content">日記內容</label>
                            @error('content')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <div class="card-action">
                        <button class="waves-effect waves-light btn brown right" type="submit">發布日記</button>
                    </div>
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
