@extends('layouts.app')

@section('content')
<div id="app">

    @include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

    <div class="fixed-action-btn click-to-toggle">
        <a class="btn-floating btn-large red">
            <i class="large material-icons brown">menu</i>
        </a>
        <ul>
            <li>
                <a href="{{ route('home.index') }}" class="btn-floating yellow tooltipped modal-trigger" data-position="top" data-tooltip="我的小屋">
                    <i class="material-icons">view_quilt</i>
                </a>
            </li>
            <li>
                <a href="{{ route('profile.index') }}" class="btn-floating green tooltipped modal-trigger" data-position="top" data-tooltip="個人資料">
                    <i class="material-icons">perm_identity</i>
                </a>
            </li>
        </ul>
    </div>

    <div class="container">
        <div class="row">

            <h3 class="center-align wow animate__animated animate__fadeInUp animate__delay-1s teal-text text-darken-3">
                🎁 <strong>可兌換獎品列表</strong>
            </h3>


            <div class="col s12">
                <div class="card-panel teal lighten-5 z-depth-1 center-align">
                    <h5 class="black-text">
                        🎯 您目前擁有 <span class="teal-text text-darken-3"><strong>{{ Auth::user()->points }}</strong></span> 點
                    </h5>
                </div>
            </div>

                @if ($prizes->isEmpty())
                    <div class="col s12 center-align">
                        <h5 class="grey-text text-darken-1">目前沒有可兌換的獎品，敬請期待！</h5>
                    </div>
                @else

                <div class="col s12">
                    {{ $prizes->links('vendor.pagination.materialize') }}
                </div>

                @foreach ($prizes as $prize)
                    <div class="col s12 m6 l4 wow animate__animated animate__fadeInUp animate__delay-2s">
                        <div class="card hoverable z-depth-3">
                            <div class="card-image">
                                <img class="materialboxed" src="{{ asset($prize->image ? 'storage/' . $prize->image : 'img/default-prize.png') }}"
                                     alt="獎品圖片"
                                     style="height: 200px; object-fit: cover;">
                            </div>
                            <div class="card-content">
                                <span class="card-title teal-text text-darken-2 truncate">
                                    <strong>🏷 {{ $prize->prize }}</strong>
                                </span>
                                <p>💰 所需點數：<span class="blue-text text-darken-2"><strong>{{ $prize->price }}</strong></span></p>
                                <p>📦 庫存：<span class="deep-orange-text text-darken-2"><strong>{{ $prize->quantity }}</strong></span></p>
                                <p class="grey-text text-lighten-1 right"><i class="material-icons tiny">schedule</i> {{ $prize->created_at->format('Y-m-d') }}</p>
                            </div>
                            <div class="card-action">
                                @if ($prize->quantity > 0)
                                    <form action="{{ route('prize.redeem', $prize->id) }}" method="POST">
                                        @csrf
                                        <div class="input-field">
                                            <input type="number" name="quantity" id="quantity-{{ $prize->id }}"
                                                   min="1" max="{{ $prize->quantity }}" value="1" required>
                                            <label for="quantity-{{ $prize->id }}">兌換數量</label>
                                        </div>

                                        <div class="input-field">
                                            <input type="text" name="shipping_address" id="shipping-{{ $prize->id }}" placeholder="例如：台中市東區建國路123號" required>
                                            <label for="shipping-{{ $prize->id }}">寄送地址</label>
                                        </div>

                                        <div class="input-field">
                                            <textarea name="note" id="note-{{ $prize->id }}" class="materialize-textarea" placeholder="可選填，例如：收件人手機號碼"></textarea>
                                            <label for="note-{{ $prize->id }}">備註（可選）</label>
                                        </div>

                                        @if(auth()->user()->points < $prize->price)
                                            <button class="btn disabled grey" disabled>點數不足</button>
                                        @else
                                            <button class="btn green waves-effect waves-light pulse" type="submit">
                                                立即兌換
                                            </button>
                                        @endif
                                    </form>
                                @else
                                    <p class="red-text text-darken-2"><strong>⚠️ 此獎品已兌換完畢</strong></p>
                                @endif
                                @if(Auth::user()->administration == 5)
                                    <form action="{{ route('prize.destroy', $prize->id) }}" method="POST" class="right-align" style="margin-top: 10px;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-flat waves-effect waves-red red-text text-darken-2">
                                            <i class="material-icons left">delete</i>刪除
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="col s12">
                    {{ $prizes->links('vendor.pagination.materialize') }}
                </div>

            @endif
        </div>
    </div>

    @include('component.contact')

    <br>

    @include('component.footer')

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        M.updateTextFields();
        const elems = document.querySelectorAll('.materialboxed');
        M.Materialbox.init(elems);
    });
</script>
@endsection
