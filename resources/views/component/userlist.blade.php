<div class="container">
    <div class="row">
        @php
            $buttons = [
                ['route' => 'home.posts', 'label' => '貼文列表', 'icon' => 'forum'],
                ['route' => 'home.articles', 'label' => '文章列表', 'icon' => 'article'],
                ['route' => 'home.opinions', 'label' => '投票列表', 'icon' => 'how_to_vote'],
                ['route' => 'home.works', 'label' => '作品列表', 'icon' => 'palette'],
                ['route' => 'home.videos', 'label' => '影片列表', 'icon' => 'videocam'],
                ['route' => 'home.files', 'label' => '檔案列表', 'icon' => 'attach_file'],
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
