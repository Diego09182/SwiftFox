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
            <a href="{{route('home.index')}}" class="btn-floating yellow tooltipped modal-trigger" data-position="top" data-tooltip="我的小屋">
                <i class="material-icons">view_quilt</i>
            </a>
        </li>
        <li>
            <a href="{{route('profile.index')}}" class="btn-floating green tooltipped modal-trigger" data-position="top" data-tooltip="個人資料">
                <i class="material-icons">perm_identity</i>
            </a>
        </li>
    </ul>
</div>

<div class="container">
    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s3"><a href="#clubForm">創建社團</a></li>
                <li class="tab col s3"><a href="#activityForm">創建活動</a></li>
                <li class="tab col s3"><a href="#bulletinForm">發布公告</a></li>
            </ul>
        </div>
    </div>
</div>

<div id="clubForm" class="col s12">
    @include('component.form.club')
</div>
<div id="activityForm" class="col s12">
    @include('component.form.activity')
</div>
<div id="bulletinForm" class="col s12">
    @include('component.form.bulletin')
</div>

@include('component.managementlist')

<div class="container">
    <h4 class="center">檔案列表</h4>

    @if ($files->isEmpty())
        <h5 class="center-align">目前沒有檔案</h5>
    @else
        {{-- 分頁 --}}
        <ul class="pagination center">
            @if ($files->onFirstPage() === false)
                <li class="waves-effect">
                    <a href="{{ $files->previousPageUrl() }}">
                        <i class="material-icons">chevron_left</i>
                    </a>
                </li>
            @endif

            @for ($i = 1; $i <= $files->lastPage(); $i++)
                @if ($i === 1 || $i === $files->lastPage() || abs($files->currentPage() - $i) < 3)
                    <li class="waves-effect {{ $i === $files->currentPage() ? 'active brown' : '' }}">
                        <a href="{{ $files->url($i) }}">{{ $i }}</a>
                    </li>
                @elseif (abs($files->currentPage() - $i) === 3)
                    <li class="disabled"><span>...</span></li>
                @endif
            @endfor

            @if ($files->hasMorePages())
                <li class="waves-effect">
                    <a href="{{ $files->nextPageUrl() }}">
                        <i class="material-icons">chevron_right</i>
                    </a>
                </li>
            @endif
        </ul>

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
