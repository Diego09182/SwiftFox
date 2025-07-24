	$(document).ready(function(){
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('.fixed-action-btn').floatingActionButton({
			direction: 'left',
			hoverEnabled: false
		});
		$('.tabs').tabs();
		$('.parallax').parallax();
		$('.sidenav').sidenav();
		$('.carousel.carousel-slider').carousel({ fullWidth: true });
		$('.modal').modal();
		$('.materialboxed').materialbox();
		$('.tooltipped').tooltip();
		$('.chips').chips();
		$('.collapsible').collapsible();
		$('.carousel').carousel({
			fullWidth: true
		});
		$('.slider').slider({
			height: 300,
			duration: 500,
		});
		$('select').formSelect();
	});

	const About = {
	template:
		`<div>

			<developer></developer>

		</div>`
	}

	const Disclaimer = {
	template:
		`<div>

			<rule></rule>

			<privacy></privacy>

			<terms></terms>

			<serveterms></serveterms>

		</div>`
	}

	const Home = {
	template:
		`<div>

			<serve></serve>

			<slogan></slogan>

		</div>`
	}

	const router = VueRouter.createRouter({
    	history: VueRouter.createWebHashHistory(),
    	routes : [
			{ path: '/', component: Home },
			{ path: '/home', component: Home },
			{ path: '/about', component: About },
			{ path: '/disclaimer', component: Disclaimer },
		],
  	});

	const app = Vue.createApp({
		data() {
			return {
					Home: '首要頁面',
					About: '關於網站',
					Disclaimer: '網站聲明',
				};
			},
		methods: {},
		watch: {},
		computed: {},
		mounted() {},
	});

	app.component('rule', {
        template: `
        <div class="container">
            <div class="row">
                <div class="col s12 center-align">
                    <h3 class="brown-text text-darken-3 animate__animated animate__fadeInDown"><b>社群規則</b></h3>
                </div>
                <div class="col s12 animate__animated animate__fadeInUp">
                    <div class="card z-depth-2">
                        <div class="card-content">
                            <span class="card-title"><i class="material-icons left">gavel</i>社群行為準則</span>
                            <div class="responsive-table">
                                <table class="striped highlight centered" style="font-size: 2rem;">
                                    <thead>
                                        <tr>
                                            <th>規則內容</th>
                                            <th>處理方式</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>禁止侵犯他人著作權<br><small style="font-size: 2rem;">例如未經授權轉載文章、圖片、音樂、影片等</small></td>
                                            <td>封鎖帳號，並刪除內容</td>
                                        </tr>
                                        <tr>
                                            <td>禁止任何違法行為<br><small style="font-size: 2rem;">包括詐騙、販毒、駭客行為等</small></td>
                                            <td>封鎖帳號，並通報警方</td>
                                        </tr>
                                        <tr>
                                            <td>禁止仇恨言論、歧視、暴力威脅</td>
                                            <td>封鎖帳號，並刪除內容</td>
                                        </tr>
                                        <tr>
                                            <td>禁止發布垃圾訊息與惡意連結</td>
                                            <td>封鎖帳號並清除訊息</td>
                                        </tr>
                                        <tr>
                                            <td>禁止未經授權的商業宣傳</td>
                                            <td>封鎖帳號</td>
                                        </tr>
                                        <tr>
                                            <td>禁止散布不實資訊或陰謀論</td>
                                            <td>警告一次，屢犯封鎖</td>
                                        </tr>
                                        <tr>
                                            <td>禁止冒充他人或偽造身份</td>
                                            <td>封鎖帳號</td>
                                        </tr>
                                        <tr>
                                            <td>尊重隱私，勿公開他人個資</td>
                                            <td>封鎖帳號，嚴重者報警</td>
                                        </tr>
                                        <tr>
                                            <td>禁止濫用平台功能</td>
                                            <td>封鎖帳號，並修復漏洞</td>
                                        </tr>
                                        <tr>
                                            <td>違規累犯或重大事件</td>
                                            <td>永久封鎖帳號</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `
    });

    app.component('privacy', {
        template: `
        <div class="container">
            <div class="row">
                <div class="col s12 center-align">
                    <h3 class="brown-text text-darken-3 animate__animated animate__fadeInDown"><b>隱私權聲明</b></h3>
                </div>
                <div class="col s12 animate__animated animate__fadeInUp">
                    <div class="card-panel z-depth-2">
                        <blockquote>
                            <h4 style="font-size: 2.2rem;">1. 收集的個人資訊：</h4>
                            <h4>僅在您自願提供的情況下收集，僅限於聯絡與通訊用途，不會分享給第三方。</h4>
                            <h4 style="font-size: 2.2rem;">2. Cookie 使用：</h4>
                            <h4>用於改善體驗，您可透過瀏覽器設定關閉 Cookie。</h4>
                            <h4 style="font-size: 2.2rem;">3. 資訊安全：</h4>
                            <h4>我們採取合理保護措施，但無法保證網路百分之百安全。</h4>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
        `
    });

    app.component('terms', {
        template: `
        <div class="container">
            <div class="row">
                <div class="col s12 center-align">
                    <h3 class="brown-text text-darken-3 animate__animated animate__fadeInDown"><b>網站使用說明</b></h3>
                </div>
                <div class="col s12 animate__animated animate__fadeInUp">
                    <div class="card-panel z-depth-2">
                        <blockquote>
                            <h4>完成註冊即代表您同意遵守本網站條款。本站有權隨時更新條款，恕不另行通知。</h4>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
        `
    });

    app.component('serveterms', {
        template: `
        <div class="container">
            <div class="row">
                <div class="col s12 center-align">
                    <h3 class="brown-text text-darken-3 animate__animated animate__fadeInDown"><b>服務條款</b></h3>
                </div>
                <div class="col s12 animate__animated animate__fadeInUp">
                    <div class="card z-depth-2">
                        <div class="card-content">
                            <span class="card-title"><i class="material-icons left">description</i>服務條款細則</span>
                            <blockquote>
                                <h4 class="brown-text text-darken-2" style="font-size: 2.2rem;"><b>1. 使用限制</b></h4>
                                <ul class="browser-default" style="font-size: 1.5rem;">
                                    <li>1.1 您使用 SwiftFox（以下稱本網站）必須遵守中華民國法律及相關規定。</li>
                                    <li>1.2 您不得從事任何非法活動，包括但不限於散播非法資訊、侵犯他人權益等。</li>
                                    <li>1.3 您應尊重其他用戶，不得進行侮辱、誹謗、威脅等行為。</li>
                                </ul>
                                <h4 class="brown-text text-darken-2" style="font-size: 2.2rem;"><b>2. 使用風險與責任</b></h4>
                                <ul class="browser-default" style="font-size: 1.5rem;">
                                    <li>2.1 所有使用行為的風險與責任由您自行承擔，本網站不負責任。</li>
                                    <li>2.2 請注意保護個人資料，因您自身原因導致的損失本網站不負責。</li>
                                </ul>
                                <h4 class="brown-text text-darken-2" style="font-size: 2.2rem;"><b>3. 免責聲明</b></h4>
                                <ul class="browser-default" style="font-size: 1.5rem;">
                                    <li>3.1 本網站不承擔任何因使用網站所導致的直接或間接損失責任。</li>
                                    <li>3.2 本網站不保證可用性、準確性、安全性與即時性。</li>
                                </ul>
                                <h4 class="brown-text text-darken-2" style="font-size: 2.2rem;"><b>4. 修改與終止</b></h4>
                                <ul class="browser-default" style="font-size: 1.5rem;">
                                    <li>4.1 本網站有權隨時修改條款，修改後立即生效。</li>
                                    <li>4.2 本網站有權終止營運，終止後將無法繼續使用。</li>
                                </ul>
                                <h4 class="brown-text text-darken-2" style="font-size: 2.2rem;"><b>5. 爭議解決</b></h4>
                                <ul class="browser-default" style="font-size: 1.5rem;">
                                    <li>5.1 所有爭議適用中華民國法律。</li>
                                    <li>5.2 如無法協商解決，應向本網站所在地法院提出訴訟。</li>
                                </ul>
                                <h4 class="brown-text text-darken-2" style="font-size: 2.2rem;"><b>6. 其他條款</b></h4>
                                <ul class="browser-default" style="font-size: 1.5rem;">
                                    <li>6.1 本條款為完整協議，取代所有先前協議。</li>
                                    <li>6.2 如條款部分無效，其餘仍具效力。</li>
                                    <li>6.3 條款標題僅供參考，不具法律效力。</li>
                                </ul>
                                <p class="red-text text-darken-2" style="font-size: 1.5rem;"><b>⚠️ 若您不同意本服務條款任何內容，請停止使用本網站。</b></p>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `
    });

	app.component('slogan', {
	    template: `
        <div class="row" id="slogan">
            <div class="col s12">
                <div class="card-panel z-depth-3 center-align animate__animated animate__fadeInDown animate__delay-3s">
                    <h1 class="brown-text text-darken-3" style="font-weight: 700; font-size: 3.5rem; margin-bottom: 10px;">
                        Swift Fox
                    </h1>
                    <h4 class="grey-text text-darken-2" style="font-weight: 500;">
                        一個多功能的開源社群軟體
                    </h4>
                </div>
            </div>
        </div>
        `
    });

	app.component('serve', {
        template: `
        <div class="container">
            <h3 class="center-align brown-text text-darken-3 animate__animated animate__fadeInDown"><b>特色功能</b></h3>
            <div class="row">
                <div class="col s12 m4">
                    <div class="card hoverable animate__animated animate__fadeInUp animate__delay-1s">
                        <div class="card-content center-align">
                            <h2 class="brown-text text-darken-2"><i class="material-icons large">perm_media</i></h2>
                            <h4 class="brown-text text-darken-4"><b>提供學習資料</b></h4>
                            <h5>提供優良的學習歷程檔案範例</h5>
                        </div>
                    </div>
                </div>
                <div class="col s12 m4">
                    <div class="card hoverable animate__animated animate__fadeInUp animate__delay-2s">
                        <div class="card-content center-align">
                            <h2 class="brown-text text-darken-2"><i class="material-icons large">comment</i></h2>
                            <h4 class="brown-text text-darken-4"><b>用戶經驗分享</b></h4>
                            <h5>可以進行成果發表與討論分享</h5>
                        </div>
                    </div>
                </div>
                <div class="col s12 m4">
                    <div class="card hoverable animate__animated animate__fadeInUp animate__delay-3s">
                        <div class="card-content center-align">
                            <h2 class="brown-text text-darken-2"><i class="material-icons large">assessment</i></h2>
                            <h4 class="brown-text text-darken-4"><b>相關統計資料</b></h4>
                            <h5>秉持透明、開放的態度，公開部分統計資料</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `
    });

	app.component('developer', {
        template: `
        <div class="container">
            <div class="row">
                <div class="col s12 center-align">
                    <h3 class="brown-text text-darken-3 animate__animated animate__fadeInDown"><b>開發團隊</b></h3>
                </div>
                <div class="col s12 m12 animate__animated animate__fadeInUp">
                    <div class="card horizontal z-depth-3" style="border-radius: 15px; overflow: hidden;">
                        <div class="card-image">
                            <img src="images/SWIFT FOX LOGO.png" alt="Logo" style="max-width: 160px; max-height: 160px; object-fit: contain; margin: 20px;">
                        </div>
                        <div class="card-stacked">
                            <div class="card-content">
                                <h5 class="brown-text text-darken-3"><b>開發者：張皓明</b></h5>
                                <h5 class="brown-text text-darken-3">
                                    致力於學習各種後端開發技術，專注於 Laravel、API 串接與系統效能優化。
                                </h5>
                            </div>
                            <div class="card-action right-align" style="padding-right: 20px;">
                                <a class="btn waves-effect brown darken-2" href="https://github.com/Diego09182" target="_blank">
                                    <i class="material-icons left">code</i>Github
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `
    });

	app.use(router);

	const vm = app.mount('#app');
