@extends('layouts.app')

@section('content')

<div id="app">

    @include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

    <div class="container">
        <div class="card white">
            <form name="PhotoForm" method="post" action="{{ route('photo.store', ['work' => $work->id]) }}" enctype="multipart/form-data">
                @csrf
                <div class="card-content">
                    <span class="card-title black-text">發布作品</span>
                    <div class="row">
                        <div class="col m5 right">
                            <h5 class="black-text">帳號: {{ Auth::user()->account }}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="file-field input-field">
                            <div class="btn brown">
                                <span>圖片上傳</span>
                                <input type="file" name="file">
                            </div>
                            <div class="file-path-wrapper">
                                <input name="file" class="file-path validate black-text" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m12">
                            <i class="material-icons prefix black-text">mode_edit</i>
                            <textarea class="materialize-textarea black-text" name="name"></textarea>
                            <label for="icon_prefix2" class="black-text">名稱</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m12">
                            <i class="material-icons prefix black-text">mode_edit</i>
                            <textarea class="materialize-textarea black-text" name="content"></textarea>
                            <label for="icon_prefix2" class="black-text">內容</label>
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
