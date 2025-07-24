<div class="container">
    <div class="center-align animate__animated animate__fadeInDown animate__delay-4s">
        <h3 class="tm-text-primary tm-section-title mb-4">
            公佈欄
        </h3>
    </div>

    <div class="row">
        <div class="col s12 m8 offset-m2">
            <div class="card z-depth-3 animate__animated animate__fadeInDown animate__delay-4s">
                <div class="card-content">
                    @if ($bulletin)
                        <h4 class="card-title">
                            <i class="material-icons left">info_outline</i>{{ $bulletin->title }}
                        </h4>

                        <h4 class="grey-text text-darken-2" style="margin-top: 20px; line-height: 1.8;">
                            {{ $bulletin->content }}
                        </h4>

                        <h6 class="right-align grey-text text-lighten-1" style="margin-top: 30px;">
                            {{ $bulletin->created_at->format('Y-m-d H:i') }}
                        </h6>
                    @else
                        <h4 class="card-title">
                            <i class="material-icons left">info_outline</i>目前沒有公告
                        </h4>

                        <h4 class="grey-text text-darken-2" style="margin-top: 20px; line-height: 1.8;">
                            敬請期待最新公告資訊。
                        </h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
