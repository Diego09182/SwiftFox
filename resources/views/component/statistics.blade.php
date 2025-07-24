@php
    $stats = [
        ['icon' => 'person', 'color' => 'brown', 'label' => '使用者數量', 'value' => $userCount],
        ['icon' => 'comment', 'color' => 'teal', 'label' => '貼文數量', 'value' => $postCount],
        ['icon' => 'description', 'color' => 'orange', 'label' => '文章數量', 'value' => $articleCount],
        ['icon' => 'folder', 'color' => 'deep-purple', 'label' => '作品數量', 'value' => $workCount],
        ['icon' => 'toc', 'color' => 'green', 'label' => '事項數量', 'value' => $opinionCount],
        ['icon' => 'note', 'color' => 'red', 'label' => '影片數量', 'value' => $videoCount],
    ];
@endphp

<h3 class="center-align">統計數據</h3>
<div class="container">
    @foreach(array_chunk($stats, 3) as $rowIndex => $row)
        <div class="row">
            @foreach($row as $colIndex => $stat)
                @php
                    $delay = number_format(($rowIndex * 3 + $colIndex) * 1.5, 1);
                @endphp
                <div class="col s12 m4">
                    <div class="card z-depth-2 animate__animated animate__fadeInUp" style="animation-delay: {{ $delay }}s;">
                        <div class="card-content center">
                            <i class="material-icons large {{ $stat['color'] }}-text text-darken-2">{{ $stat['icon'] }}</i>
                            <h5 class="grey-text text-darken-3">{{ $stat['label'] }}</h5>
                            <h4 class="blue-text text-darken-3">{{ $stat['value'] }}</h4>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
