@extends('layouts.app')

@section('content')

@include('component.navigation')

@include('component.serve.message')

@include('component.logoutbanner')

    <div class="fixed-action-btn click-to-toggle">
        <a class="btn-floating btn-large red">
            <i class="large material-icons brown">menu</i>
        </a>
        <ul>
            <li>
                <a href="{{ route('home.index') }}" class="btn-floating yellow tooltipped" data-tooltip="我的小屋">
                    <i class="material-icons">view_quilt</i>
                </a>
            </li>
            <li>
                <a href="{{ route('profile.index') }}" class="btn-floating green tooltipped" data-tooltip="個人資料">
                    <i class="material-icons">perm_identity</i>
                </a>
            </li>
        </ul>
    </div>


    @include('component.managementlist')

    <div class="container">
        <h3 class="center">📝 貼文管理列表</h3>

        @if ($posts->isEmpty())
            <h3 class="center-align">目前沒有貼文</h3>
        @else
            {{ $posts->links('vendor.pagination.materialize') }}
            <table class="striped responsive-table">
                <thead>
                    <tr>
                        <th>標題</th>
                        <th>標籤</th>
                        <th>違規</th>
                        <th>建立時間</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->tag }}</td>
                            <td>
                                @if ($post->violated)
                                    <span class="red-text">❌ 違規</span>
                                @else
                                    <span class="green-text">✅ 正常</span>
                                @endif
                            </td>
                            <td>{{ $post->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('forum.show', $post->id) }}" class="btn-floating amber tooltipped" data-tooltip="查看貼文">
                                    <i class="material-icons">visibility</i>
                                </a>
                                <form action="{{ route('forum.destroy', $post->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-floating red tooltipped" data-tooltip="刪除" onclick="return confirm('確定要刪除這篇貼文嗎？')">
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

<br>

@include('component.footer')

@endsection
