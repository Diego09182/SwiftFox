@extends('layouts.app')

@section('content')

<div id="app">

    @include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

    <br>

    @include('component.toolbar')

    <div class="container">
        <div class="row">
            <h3 class="center-align">所有檔案</h3>
            <br>
            <div class="row center">
                <a href="{{ route('file.create') }}" class="waves-effect waves-light btn brown"><i class="material-icons left">add</i>新增檔案</a>
            </div>
            @if ($files->isEmpty())
            <h3 class="center-align">目前沒有檔案</h3>
            @else
            {{ $files->links('vendor.pagination.materialize') }}
            <div class="row">
                @foreach ($files as $file)
                <div class="col s12 m4">
                    <div class="card hoverable center" id="file">
                        <div class="card-content">
                            <h5 class="truncate">標題: {{ $file->title }}</h5>
                            <p>上傳者: {{ $file->user->account }}</p>
                            <p>上傳時間: {{ $file->created_at }}</p>
                            <br>
                            <a class="waves-effect waves-light btn right brown" href="{{ route('file.show', ['file' => $file->id]) }}">查看</a>
                            @if(Auth::user()->administration == 5 || $file->user->id == Auth::user()->id)
                            <form action="{{ route('file.destroy', $file->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="waves-effect waves-light btn brown left">刪除</button>
                            </form>
                            @endif
                            <br>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <br>

    @include('component.contact')

    <br>

    @include('component.footer')

</div>

@endsection
