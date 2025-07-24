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
        <h3 class="center">使用者列表</h3>
        <ul class="pagination center">
            {{ $users->links('vendor.pagination.materialize') }}
        </ul>
        @if ($users->isEmpty())
            <h3 class="center-align">目前沒有使用者</h3>
        @else
            <table class="responsive-table">
                <thead>
                    <tr>
                        <th>帳號</th>
                        <th>姓名</th>
                        <th>信箱</th>
                        <th>電話</th>
                        <th>權限</th>
                        <th>狀態</th>
                        <th>創建日期</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->account }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->cellphone }}</td>
                        <td>{{ $user->administration }}</td>
                        <td>{{ $user->status }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            <form action="{{ route('management.update', ['user' => $user->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="input-field col m6">
                                        <select name="administration">
                                            <option value="1" {{ $user->administration == 1 ? 'selected' : '' }}>1</option>
                                            <option value="2" {{ $user->administration == 2 ? 'selected' : '' }}>2</option>
                                            <option value="3" {{ $user->administration == 3 ? 'selected' : '' }}>3</option>
                                            <option value="4" {{ $user->administration == 4 ? 'selected' : '' }}>4</option>
                                            <option value="5" {{ $user->administration == 5 ? 'selected' : '' }}>5</option>
                                        </select>
                                        <label>權限</label>
                                    </div>
                                    <div class="input-field col m6">
                                        <select name="status">
                                            <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>0</option>
                                            <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>1</option>
                                        </select>
                                        <label>狀態</label>
                                    </div>
                                </div>
                                <button class="btn waves-effect waves-light brown right" type="submit">更新</button>
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
