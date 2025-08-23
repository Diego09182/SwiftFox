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
            <h3 class="center-align brown-text text-darken-2 wow animate__animated animate__fadeInUp animate__delay-1s">
                <b>所有檔案</b>
            </h3>
            <div class="col s12 center-align" style="margin-bottom: 20px;">
                <a href="{{ route('file.create') }}" class="waves-effect waves-light btn-large brown">
                    <i class="material-icons left">add</i> 新增檔案
                </a>
            </div>
            @if ($files->isEmpty())
                <h5 class="center-align grey-text text-darken-1 wow animate__animated animate__fadeInUp animate__delay-1s">
                    目前沒有檔案
                </h5>
            @else
                <div class="col s12 center-align">
                    {{ $files->links('vendor.pagination.materialize') }}
                </div>
                @foreach ($files as $file)
                    <div class="col s12 m6 l4 wow animate__animated animate__fadeInUp animate__delay-2s">
                        <div class="card hoverable" style="height: 100%;">
                            <div class="card-content">
                                <span class="card-title brown-text text-darken-2 truncate" style="font-weight: bold;">
                                    <i class="material-icons left">insert_drive_file</i>{{ $file->title }}
                                </span>

                                <h5 class="grey-text text-darken-2">
                                    <i class="material-icons tiny">person</i> 上傳者：{{ $file->user->account }}
                                </h5>
                                <h5 class="grey-text text-darken-2">
                                    <i class="material-icons tiny">access_time</i> 時間：{{ $file->created_at->format('Y-m-d H:i') }}
                                </h5>
                            </div>
                            <div class="card-action">
                                <a href="{{ route('file.show', ['file' => $file->id]) }}"
                                class="waves-effect waves-light btn brown right">
                                    <i class="material-icons left">visibility</i> 查看
                                </a>
                                @if(Auth::user()->administration == 5 || $file->user->id == Auth::user()->id)
                                    <form action="{{ route('file.destroy', $file->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn red lighten-1 waves-effect waves-light">
                                            <i class="material-icons">delete</i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>


    <br>

    @include('component.contact')

    <br>

    @include('component.footer')

</div>

@endsection
