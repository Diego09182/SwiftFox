@php
$features = [
    [
        'title' => '投票區',
        'desc' => '關於學生自治與校務投票。',
        'route' => 'opinion.index',
        'icon' => 'fa-solid fa-square-poll-vertical'
    ],
    [
        'title' => '綜合討論區',
        'desc' => '討論關於校園的任何事項。',
        'route' => 'forum.index',
        'icon' => 'fa-solid fa-comments'
    ],
    [
        'title' => '作品分享區',
        'desc' => '圖片檔案分享。',
        'route' => 'work.index',
        'icon' => 'fa-solid fa-image'
    ],
    [
        'title' => '文章區',
        'desc' => '學習資訊分享。',
        'route' => 'article.index',
        'icon' => 'fa-solid fa-file-lines'
    ],
    [
        'title' => '社團區',
        'desc' => '社團資訊分享。',
        'route' => 'club.index',
        'icon' => 'fa-solid fa-people-group'
    ],
    [
        'title' => '活動區',
        'desc' => '活動資訊分享。',
        'route' => 'activity.index',
        'icon' => 'fa-solid fa-calendar-days'
    ],
    [
        'title' => '影片分享區',
        'desc' => '多媒體資源分享。',
        'route' => 'video.index',
        'icon' => 'fa-solid fa-video'
    ],
    [
        'title' => '檔案分享區',
        'desc' => '檔案資源分享。',
        'route' => 'file.index',
        'icon' => 'fa-solid fa-folder-open'
    ],
    [
        'title' => '商城區',
        'desc' => '獎品兌換與虛擬商品。',
        'route' => 'prize.index',
        'icon' => 'fa-solid fa-store'
    ],
];
@endphp

<div class="container">
    <div class="row">
        @foreach($features as $index => $feature)
            @php
                $delay = number_format($index * 0.2, 1);
                $animation = $index % 2 === 0 ? 'animate__fadeInLeft' : 'animate__fadeInRight';
            @endphp
            <div class="col s12 m6 l4">
                <div class="card hoverable animate__animated {{ $animation }}" style="animation-delay: {{ $delay }}s; border-radius: 12px;">
                    <div class="card-image center-align" style="padding: 30px;">
                        <i class="{{ $feature['icon'] }} fa-icon fa-4x brown-text text-darken-2"></i>
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4" style="font-weight: bold;">
                            {{ $feature['title'] }}
                            <i class="material-icons right">more_vert</i>
                        </span>
                        <a class="waves-effect waves-light btn-small right brown lighten-1" href="{{ route($feature['route']) }}" style="margin-top: 10px; font-weight: bold;">
                            進入
                        </a>
                    </div>
                    <br><br>
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4" style="font-weight: bold;">
                            {{ $feature['title'] }}
                            <i class="material-icons right">close</i>
                        </span>
                        <p style="font-weight: bold;">{{ $feature['desc'] }}</p>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
</div>
