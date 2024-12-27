<h3 class="center-align">統計數據</h3>
<div class="container">
    <div class="row">
        <div class="col s12 m4">
            <div class="icon-block">
                <h2 class="center"><i class="material-icons large">person</i></h2>
                <h4 class="center">使用者數量</h4>
                <h4 class="center">{{ $userCount }}</h4>
            </div>
        </div>
        <div class="col s12 m4">
            <div class="icon-block">
                <h2 class="center"><i class="material-icons large">comment</i></h2>
                <h4 class="center">貼文數量</h4>
                <h4 class="center">{{ $postCount }}</h4>
            </div>
        </div>
        <div class="col s12 m4">
            <div class="icon-block">
                <h2 class="center"><i class="material-icons large">description</i></h2>
                <h4 class="center">文章數量</h4>
                <h4 class="center">{{ $articleCount }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m4">
            <div class="icon-block">
                <h2 class="center light-brown-text"><i class="material-icons large">folder</i></h2>
                <h4 class="center">作品數量</h4>
                <h4 class="center">{{ $workCount }}</h4>
            </div>
        </div>
        <div class="col s12 m4">
            <div class="icon-block">
                <h2 class="center light-brown-text"><i class="material-icons large">toc</i></h2>
                <h4 class="center">事項數量</h4>
                <h4 class="center">{{ $opinionCount }}</h4>
            </div>
        </div>
        <div class="col s12 m4">
            <div class="icon-block">
                <h2 class="center light-brown-text"><i class="material-icons large">note</i></h2>
                <h4 class="center">日記數量</h4>
                <h4 class="center">{{ $noteCount }}</h4>
            </div>
        </div>
    </div>
</div>
