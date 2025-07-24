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
        <h3 class="center">作品列表</h3>
        @if ($works->isEmpty())
            <h3 class="center-align">目前沒有作品</h3>
        @else
            {{ $works->links('vendor.pagination.materialize') }}
            <table class="striped">
                <thead>
                    <tr>
                        <th>作品名稱</th>
                        <th>創建時間</th>
                        <th>操作</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($works as $work)
                        <tr>
                            <td>{{ $work->name }}</td>
                            <td>{{ $work->created_at }}</td>
                            <td>
                                <form action="{{ route('work.destroy', ['work' => $work->id ]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-floating waves-effect waves-light brown tooltipped" data-delay="50" data-tooltip="刪除">
                                        <i class="material-icons">delete</i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('work.show', ['work' => $work->id ]) }}" class="btn waves-effect waves-light brown tooltipped" data-delay="50" data-tooltip="查看資源">
                                    查看
                                </a>
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
