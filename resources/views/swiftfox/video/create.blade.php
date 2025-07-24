@extends('layouts.app')

@section('content')

<div id="app">

	@include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

	<div class="container">
        <div class="card white">
            <form name="VideoForm" method="post" action="{{ route('video.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-content">
                    <span class="card-title black-text">新增影片</span>

                    <div class="row">
                        <div class="input-field col m12">
                            <i class="material-icons prefix black-text">title</i>
                            <input class="validate black-text" name="title" type="text" value="{{ old('title') }}">
                            <label for="title" class="black-text">標題</label>
                            @error('title')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col m12">
                            <i class="material-icons prefix black-text">description</i>
                            <textarea class="materialize-textarea black-text" name="content">{{ old('content') }}</textarea>
                            <label for="content" class="black-text">內容</label>
                            @error('content')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="file-field input-field col m12">
                            <div class="btn brown">
                                <span>選擇檔案</span>
                                <input type="file" name="video">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate black-text" type="text">
                            </div>
                            @error('video')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <button class="waves-effect waves-light btn brown right" type="submit">上傳影片</button>
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
