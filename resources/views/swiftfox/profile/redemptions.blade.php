@extends('layouts.app')

@section('content')

<div id="app">

	@include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

    <h4 class="center">🎁 兌換紀錄</h4>

    <div class="container">
        @if ($redemptions->isEmpty())
            <div class="card-panel center-align grey lighten-3">
                尚無兌換紀錄
            </div>
        @else
            {{ $redemptions->links('vendor.pagination.materialize') }}
            <div class="card z-depth-2">
                <div class="card-content">
                    <table class="striped highlight responsive-table">
                        <thead>
                            <tr>
                                <th>獎品名稱</th>
                                <th>數量</th>
                                <th>狀態</th>
                                <th>備註</th>
                                <th>地址</th>
                                <th>兌換時間</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($redemptions as $item)
                                <tr>
                                    <td>{{ $item->prize->prize ?? '（已刪除）' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>
                                        <span class="new badge
                                            {{
                                                $item->status === 'pending' ? 'orange' :
                                                ($item->status === 'approved' ? 'green' :
                                                ($item->status === 'rejected' ? 'red' : 'grey'))
                                            }}"
                                            data-badge-caption="{{ $item->status }}">
                                        </span>
                                    </td>
                                    <td>{{ $item->note ?? '-' }}</td>
                                    <td>{{ $item->shipping_address ?? '未填寫' }}</td>
                                    <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

	<br>

	<br>

    @include('component.footer')

</div>

@endsection
