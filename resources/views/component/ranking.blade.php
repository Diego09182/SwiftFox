@php
    $cards = [
        ['title' => '貼文排行榜', 'color' => 'brown', 'icon' => 'push_pin', 'data' => $postTopUsers, 'unit' => '篇數'],
        ['title' => '文章排行榜', 'color' => 'orange', 'icon' => 'description', 'data' => $articleTopUsers, 'unit' => '篇數'],
        ['title' => '影片排行榜', 'color' => 'teal', 'icon' => 'video_library', 'data' => $videoTopUsers, 'unit' => '筆數'],
        ['title' => '作品排行榜', 'color' => 'deep-purple', 'icon' => 'brush', 'data' => $workTopUsers, 'unit' => '件數'],
        ['title' => '意見排行榜', 'color' => 'blue', 'icon' => 'chat_bubble', 'data' => $opinionTopUsers, 'unit' => '則數'],
        ['title' => '檔案排行榜', 'color' => 'grey', 'icon' => 'folder', 'data' => $fileTopUsers, 'unit' => '則數'],
    ];
@endphp

<div class="container">
    <div class="row">
        @foreach ($cards as $index => $card)
            <div class="col s12 m6 animate__animated animate__fadeInUp" style="animation-delay: {{ $index * 2 }}s;">
                <div class="card z-depth-2">
                    <div class="card-content">
                        <span class="card-title {{ $card['color'] }}-text text-darken-4">
                            <i class="material-icons left">{{ $card['icon'] }}</i>{{ $card['title'] }}
                        </span>
                        <table class="highlight centered responsive-table">
                            <thead>
                                <tr>
                                    <th>使用者</th>
                                    <th>{{ $card['unit'] }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($card['data'] as $item)
                                    <tr>
                                        <td>{{ $item->user->name ?? '未知使用者' }}</td>
                                        <td>{{ $item->total }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">目前沒有資源</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
