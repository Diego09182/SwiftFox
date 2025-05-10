<div class="container">
    <div class="row">
        <div class="col s12 m6">
            <h5>📌 貼文排行榜</h5>
            <ul class="collection">
                @foreach ($postTopUsers as $item)
                    <li class="collection-item">
                        {{ $item->user->name ?? '未知使用者' }}（{{ $item->total }} 篇）
                    </li>
                @endforeach
            </ul>
            <h5>📝 文章排行榜</h5>
            <ul class="collection">
                @foreach ($articleTopUsers as $item)
                    <li class="collection-item">
                        {{ $item->user->name ?? '未知使用者' }}（{{ $item->total }} 篇）
                    </li>
                @endforeach
            </ul>
            <h5>📒 影片排行榜</h5>
            <ul class="collection">
                @foreach ($videoTopUsers as $item)
                    <li class="collection-item">
                        {{ $item->user->name ?? '未知使用者' }}（{{ $item->total }} 筆）
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col s12 m6">
            <h5>🎨 作品排行榜</h5>
            <ul class="collection">
                @foreach ($workTopUsers as $item)
                    <li class="collection-item">
                        {{ $item->user->name ?? '未知使用者' }}（{{ $item->total }} 件）
                    </li>
                @endforeach
            </ul>
            <h5>💬 意見排行榜</h5>
            <ul class="collection">
                @foreach ($opinionTopUsers as $item)
                    <li class="collection-item">
                        {{ $item->user->name ?? '未知使用者' }}（{{ $item->total }} 則）
                    </li>
                @endforeach
            </ul>
            <h5>📁 檔案排行榜</h5>
            <ul class="collection">
                @foreach ($fileTopUsers as $item)
                    <li class="collection-item">
                        {{ $item->user->name ?? '未知使用者' }}（{{ $item->total }} 則）
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
