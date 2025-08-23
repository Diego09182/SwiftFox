@extends('layouts.app')

@section('content')

    @include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

    @include('component.toolbar')

    @include('component.userlist')

    <div class="container">
        <h3 class="center">影片列表</h3>
        @if ($videos->isEmpty())
        <h3 class="center-align">目前沒有影片</h3>
        @else
            {{ $videos->links('vendor.pagination.materialize') }}
        <table class="striped">
            <thead>
                <tr>
                    <th>影片標題</th>
                    <th>內容描述</th>
                    <th>檔案名稱</th>
                    <th>路徑</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($videos as $video)
                <tr>
                    <td>{{ $video->title }}</td>
                    <td>{{ $video->content }}</td>
                    <td>{{ $video->filename }}</td>
                    <td>{{ $video->path }}</td>
                    <td>
                        <form action="{{ route('video.destroy', ['video' => $video->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-floating waves-effect waves-light brown tooltipped" data-delay="50" data-tooltip="刪除">
                                <i class="material-icons">delete</i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

@include('component.footer')

@endsection
