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
        <h3 class="center">獎品管理列表</h3>

        @if ($prizes->isEmpty())
            <h3 class="center-align">目前沒有獎品</h3>
        @else
            {{ $prizes->links('vendor.pagination.materialize') }}
            <table class="striped responsive-table">
                <thead>
                    <tr>
                        <th>圖片</th>
                        <th>名稱</th>
                        <th>點數</th>
                        <th>庫存</th>
                        <th>新增時間</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($prizes as $prize)
                        <tr>
                            <td>
                                <img src="{{ asset('storage/' . $prize->image) }}" style="height: 50px; width: 50px; object-fit: cover;" alt="圖片">
                            </td>
                            <td>{{ $prize->prize }}</td>
                            <td>{{ $prize->price }}</td>
                            <td>{{ $prize->quantity }}</td>
                            <td>{{ $prize->created_at->format('Y-m-d') }}</td>
                            <td>
                                <form action="{{ route('prize.destroy', $prize->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-floating red tooltipped" data-tooltip="刪除" onclick="return confirm('確認刪除這個獎品嗎？')">
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
