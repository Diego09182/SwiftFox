<div class="container">
    <div class="row">
        @php
            $buttons = [
                ['route' => 'management.reports', 'label' => '檢舉列表', 'icon' => 'report_problem'],
                ['route' => 'management.users', 'label' => '使用者列表', 'icon' => 'people'],
                ['route' => 'management.posts', 'label' => '貼文列表', 'icon' => 'forum'],
                ['route' => 'management.articles', 'label' => '文章列表', 'icon' => 'article'],
                ['route' => 'management.opinions', 'label' => '投票列表', 'icon' => 'how_to_vote'],
                ['route' => 'management.clubs', 'label' => '社團列表', 'icon' => 'groups'],
                ['route' => 'management.works', 'label' => '作品列表', 'icon' => 'palette'],
                ['route' => 'management.videos', 'label' => '影片列表', 'icon' => 'videocam'],
                ['route' => 'management.files', 'label' => '檔案列表', 'icon' => 'attach_file'],
                ['route' => 'management.prizeRedemptions', 'label' => '兌換列表', 'icon' => 'redeem'],
                ['route' => 'management.prizes', 'label' => '獎品列表', 'icon' => 'card_giftcard'],
                ['route' => 'management.index', 'label' => '系統管理', 'icon' => 'settings'],
            ];
        @endphp

        @foreach ($buttons as $button)
            <div class="col s12 m6 l4">
                <a href="{{ route($button['route']) }}" class="btn-large waves-effect waves-light brown z-depth-2"
                   style="width: 100%; margin-bottom: 20px; font-size: 18px;">
                    <i class="material-icons left">{{ $button['icon'] }}</i>{{ $button['label'] }}
                </a>
            </div>
        @endforeach
    </div>
</div>

