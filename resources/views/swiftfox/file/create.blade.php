@extends('layouts.app')

@section('content')

<div id="app">

    @include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

    @include('component.toolbar')

    <div class="container">
        <div class="card white z-depth-2">
            <form name="FileForm" method="POST" action="{{ route('file.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-content black-text">
                    <span class="card-title">
                        <i class="material-icons left">upload_file</i><b>新增檔案</b>
                    </span>
                    <div class="row">
                        <div class="input-field col m12">
                            <i class="material-icons prefix">title</i>
                            <input class="validate" name="title" type="text" id="title" value="{{ old('title') }}">
                            <label for="title">標題</label>
                            @error('title')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m12">
                            <i class="material-icons prefix">description</i>
                            <textarea class="materialize-textarea" name="content" id="content">{{ old('content') }}</textarea>
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
                                <input class="file-path validate" type="text" placeholder="未選擇檔案">
                            </div>
                            @error('file')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m12">
                            <i class="material-icons prefix">link</i>
                            <input id="donation" type="text" name="donation" value="{{ old('donation') }}">
                            <label for="donation">贊助連結（可選）</label>
                            @error('donation')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 right-align">
                            <button class="waves-effect waves-light btn brown" type="submit">
                                <i class="material-icons left">cloud_upload</i> 上傳檔案
                            </button>
                        </div>
                    </div>
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
