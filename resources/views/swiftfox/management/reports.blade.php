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
        <h3 class="center">檢舉列表</h3>
        @if ($reports->isEmpty())
            <h3 class="center-align">目前沒有檢舉</h3>
        @else
            {{ $reports->links('vendor.pagination.materialize') }}
            <table class="striped">
                <thead>
                    <tr>
                        <th>檢舉主題</th>
                        <th>檢舉標籤</th>
                        <th>附註內容</th>
                        <th>發表時間</th>
                        <th>操作</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $report)
                        <tr>
                            <td>{{ $report->title }}</td>
                            <td>{{ $report->tag }}</td>
                            <td>{{ $report->content }}</td>
                            <td>{{ $report->created_at }}</td>
                            <td>
                                <form action="{{ route('report.destroy', ['report' => $report->id ]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-floating waves-effect waves-light brown tooltipped" data-delay="50" data-tooltip="刪除檢舉">
                                        <i class="material-icons">delete</i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('forum.show', ['post' => $report->post_id]) }}" class="btn waves-effect waves-light brown tooltipped" data-delay="50" data-tooltip="查看貼文">
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
