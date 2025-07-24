@extends('layouts.app')

@section('content')

<div id="app">

    @include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

    <div class="container">
        <div class="card blue-grey darken-1">
            <form name="FileForm" method="post" action="{{ route('file.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-content white-text">
                    <span class="card-title">新增檔案</span>

                    <div class="row">
                        <div class="input-field col m12">
                            <i class="material-icons prefix">title</i>
                            <input class="validate white-text" name="title" type="text" value="{{ old('title') }}">
                            <label for="title">標題</label>
                            @error('title')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col m12">
                            <i class="material-icons prefix">description</i>
                            <textarea class="materialize-textarea white-text" name="content">{{ old('content') }}</textarea>
                            <label for="content">內容</label>
                            @error('content')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="file-field input-field col m12">
                            <div class="btn brown">
                                <span>選擇檔案</span>
                                <input type="file" name="file">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate white-text" type="text">
                            </div>
                            @error('file')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="s12 m6 input-field">
                            <input id="donation" type="text" name="donation" class="white-text" value="{{ old('donation') }}">
                            <label for="donation">贊助連結</label>
                            @error('donation')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <button class="waves-effect waves-light btn brown right" type="submit">上傳檔案</button>
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
