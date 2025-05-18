<div class="container">
    <div class="row">
        <div class="col s12 m6">
            <h5>📌 貼文排行榜</h5>
            <ul class="collection">
                @forelse ($postTopUsers as $item)
                    <li class="collection-item">
                        {{ $item->user->name ?? '未知使用者' }}（{{ $item->total }} 篇）
                    </li>
                @empty
                    <li class="collection-item">目前沒有資源</li>
                @endforelse
            </ul>

            <h5>📝 文章排行榜</h5>
            <ul class="collection">
                @forelse ($articleTopUsers as $item)
                    <li class="collection-item">
                        {{ $item->user->name ?? '未知使用者' }}（{{ $item->total }} 篇）
                    </li>
                @empty
                    <li class="collection-item">目前沒有資源</li>
                @endforelse
            </ul>

            <h5>📒 影片排行榜</h5>
            <ul class="collection">
                @forelse ($videoTopUsers as $item)
                    <li class="collection-item">
                        {{ $item->user->name ?? '未知使用者' }}（{{ $item->total }} 筆）
                    </li>
                @empty
                    <li class="collection-item">目前沒有資源</li>
                @endforelse
            </ul>
        </div>

        <div class="col s12 m6">
            <h5>🎨 作品排行榜</h5>
            <ul class="collection">
                @forelse ($workTopUsers as $item)
                    <li class="collection-item">
                        {{ $item->user->name ?? '未知使用者' }}（{{ $item->total }} 件）
                    </li>
                @empty
                    <li class="collection-item">目前沒有資源</li>
                @endforelse
            </ul>

            <h5>💬 意見排行榜</h5>
            <ul class="collection">
                @forelse ($opinionTopUsers as $item)
                    <li class="collection-item">
                        {{ $item->user->name ?? '未知使用者' }}（{{ $item->total }} 則）
                    </li>
                @empty
                    <li class="collection-item">目前沒有資源</li>
                @endforelse
            </ul>

            <h5>📁 檔案排行榜</h5>
            <ul class="collection">
                @forelse ($fileTopUsers as $item)
                    <li class="collection-item">
                        {{ $item->user->name ?? '未知使用者' }}（{{ $item->total }} 則）
                    </li>
                @empty
                    <li class="collection-item">目前沒有資源</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
