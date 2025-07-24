<div class="container animate__animated animate__fadeIn animate__delay-3s">
    <div class="center-align">
        <h3 class="brown-text text-darken-3 tm-section-title mb-4 animate__animated animate__fadeInDown animate__delay-4s">
            <b>資源發布獎勵</b>
        </h3>
    </div>
    <div class="card z-depth-3 hoverable">
        <div class="card-content">
            <table class="highlight centered responsive-table">
                <thead>
                    <tr class="brown-text">
                        <th class="center-align">資源名稱</th>
                        <th class="center-align">獎勵點數</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $resourceTypes = ['貼文', '文章', '投票', '作品', '影片', '檔案'];
                    @endphp
                    @foreach ($resourceTypes as $index => $type)
                        <tr class="animate__animated animate__fadeInUp" style="animation-delay: {{ 3 + $index * 0.2 }}s;">
                            <td class="center-align">{{ $type }}</td>
                            <td class="blue-text text-darken-2 center-align"><b>+10 點</b></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
