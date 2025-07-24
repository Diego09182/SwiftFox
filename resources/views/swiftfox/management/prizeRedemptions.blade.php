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
        <h3 class="center">獎品兌換紀錄</h3>

        @if ($redemptions->isEmpty())
            <h3 class="center-align">目前沒有任何兌換紀錄</h3>
        @else
            {{ $redemptions->links('vendor.pagination.materialize') }}
            <table class="striped responsive-table">
                <thead>
                    <tr>
                        <th>用戶名稱</th>
                        <th>獎品名稱</th>
                        <th>數量</th>
                        <th>狀態</th>
                        <th>寄送地址</th>
                        <th>備註</th>
                        <th>兌換時間</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($redemptions as $record)
                        <tr>
                            <td>{{ $record->user->name }}</td>
                            <td>{{ $record->prize->prize }}</td>
                            <td>{{ $record->quantity }}</td>
                            <td>
                                <span class="new badge {{
                                    $record->status === 'pending' ? 'orange' :
                                    ($record->status === 'approved' ? 'green' : 'blue')
                                }}" data-badge-caption="{{ $record->status }}"></span>
                            </td>
                            <td>{{ $record->shipping_address }}</td>
                            <td>{{ $record->note ?? '—' }}</td>
                            <td>{{ $record->created_at->format('Y-m-d H:i') }}</td>
                            <td class="center">
                                <form action="{{ route('redemptions.destroy', $record->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-floating btn-small red tooltipped" data-tooltip="刪除">
                                        <i class="material-icons">delete</i>
                                    </button>
                                </form>
                                @if($record->status === 'pending')
                                    <form action="{{ route('redemptions.updateStatus', $record->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn-floating btn-small green tooltipped" data-tooltip="核准兌換">
                                            <i class="material-icons">check</i>
                                        </button>
                                    </form>
                                @endif
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

