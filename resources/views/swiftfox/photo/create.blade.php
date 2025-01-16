@extends('layouts.app')

@section('content')

<div id="app">

    @include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

    <div class="container">
        <div class="card blue-grey darken-1">
            <form name="PhotoForm" method="post" action="{{ route('photo.store', ['work' => $work->id]) }}" enctype="multipart/form-data">
                @csrf
                <div class="card-content white-text">
                    <span class="card-title">發布作品</span>
                    <div class="row">
                        <div class="col m5 right">
                            <h5>帳號:{{ Auth::user()->account }}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="file-field input-field">
                            <div class="btn brown">
                                <span>圖片上傳</span>
                                <input type="file" name="file">
                            </div>
                            <div class="file-path-wrapper">
                                <input name="file" class="file-path validate" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m12">
                            <i class="material-icons prefix">mode_edit</i>
                            <textarea class="materialize-textarea" name="name"></textarea>
                            <label for="icon_prefix2">名稱</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m12">
                            <div class="input-field">
                                <i class="material-icons prefix">mode_edit</i>
                                <textarea class="materialize-textarea" name="content"></textarea>
                                <label for="icon_prefix2">內容</label>
                            </div>
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
