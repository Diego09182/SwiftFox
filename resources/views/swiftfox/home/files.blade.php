    @extends('layouts.app')

    @section('content')

    @include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

    @include('component.toolbar')

    @include('component.userlist')

    <div class="container">
        <h3 class="center">檔案列表</h3>

        @if ($files->isEmpty())
            <h3 class="center-align">目前沒有檔案</h3>
        @else
            {{ $files->links('vendor.pagination.materialize') }}
            <table class="striped">
            <table class="striped">
                <thead>
                    <tr>
                        <th>檔案標題</th>
                        <th>內容</th>
                        <th>檔案名稱</th>
                        <th>操作</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($files as $file)
                        <tr>
                            <td>{{ $file->title }}</td>
                            <td>{{ $file->content }}</td>
                            <td>{{ $file->filename }}</td>
                            <td>
                                <div class="flex" style="display: flex; gap: 8px; align-items: center;">
                                    <form action="{{ route('file.destroy', ['file' => $file->id]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-floating waves-effect waves-light brown tooltipped" data-tooltip="刪除">
                                            <i class="material-icons">delete</i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('file.show', ['file' => $file->id]) }}" class="btn waves-effect waves-light brown tooltipped" data-tooltip="查看檔案">
                                    查看
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@include('component.footer')

@endsection
