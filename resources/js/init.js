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
					Home: '首頁',
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
		template:
		`<div class="container">
			<div class="container">
				<div class="center-align">
					<h3>社群規則</h3>
				</div>
				<div class="col s12 m12">
					<div class="card horizontal">
						<div class="card-stacked">
							<div class="card-content">
								<h5>
									<blockquote>
										<table>
                                            <thead>
                                                <tr>
                                                    <th>規則內容</th>
                                                    <th>處理方式</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                <td>禁止侵犯他人著作權<br><small>例如未經授權轉載文章、圖片、音樂、影片等</small></td>
                                                <td>封鎖帳號，並視情況配合相關法律處理</td>
                                                </tr>
                                                <tr>
                                                <td>禁止任何違法行為<br><small>包括但不限於詐騙、販毒、恐嚇、駭客攻擊等</small></td>
                                                <td>封鎖帳號，並視情節通報警方處理</td>
                                                </tr>
                                                <tr>
                                                <td>禁止發送仇恨言論、歧視、騷擾、暴力威脅<br><small>不限於種族、性別、宗教、國籍等</small></td>
                                                <td>封鎖帳號，並刪除相關內容</td>
                                                </tr>
                                                <tr>
                                                <td>禁止發布垃圾訊息與惡意連結<br><small>例如重複貼文、釣魚網站、病毒連結等</small></td>
                                                <td>封鎖帳號並清除相關訊息</td>
                                                </tr>
                                                <tr>
                                                <td>禁止宣傳未經授權的產品或服務<br><small>包括商業廣告、推銷活動、聯盟行銷連結等</small></td>
                                                <td>封鎖帳號</td>
                                                </tr>
                                                <tr>
                                                <td>禁止散佈不實訊息或陰謀論<br><small>例如假新聞、誤導性資訊</small></td>
                                                <td>警告一次，屢犯者封鎖帳號</td>
                                                </tr>
                                                <tr>
                                                <td>禁止冒充他人或假造身分資訊</td>
                                                <td>封鎖帳號</td>
                                                </tr>
                                                <tr>
                                                <td>尊重他人隱私<br><small>禁止公開或散布他人個資、對話紀錄、照片等</small></td>
                                                <td>封鎖帳號，嚴重者報警處理</td>
                                                </tr>
                                                <tr>
                                                <td>禁止濫用平台功能<br><small>例如利用漏洞、作弊、自動化機器人發送訊息等</small></td>
                                                <td>封鎖帳號，並修復系統問題</td>
                                                </tr>
                                                <tr>
                                                <td>違規累犯者或情節重大者<br><small>將永久停權，且不接受申訴</small></td>
                                                <td>永久封鎖帳號</td>
                                                </tr>
                                            </tbody>
                                        </table>
									</blockquote>
								</h5>
							</div>
						</div>
					</div>
				</div>
			</div>
	  	</div>`
	})

	app.component('privacy', {
		template:
		`<div class="container">
			<div class="container">
				<div class="center-align">
					<h3>隱私權聲明</h3>
				</div>
				<div class="col s12 m12">
					<div class="card horizontal">
						<div class="card-stacked">
							<div class="card-content">
								<h4>
									<blockquote>
										1.收集的個人資訊:
										<br>
										我們僅在您自願提供的情況下收集個人資訊，例如當您填寫聯絡表格或訂閱我們的通訊時。這些資訊將僅用於相應的用途，並不會分享給第三方。
										<br>
										2.Cookie使用:
										<br>
										我們使用Cookie來提供更好的用戶體驗。Cookie是一種小文本文件，用於記錄訪問者的設備和活動。您可以通過瀏覽器設置管理Cookie。
										<br>
										3.資訊安全:
										<br>
										我們採取安全措施以保護您提供的資訊。然而，請理解互聯網上傳輸的資訊無法保證百分之百的安全。
									</blockquote>
								</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>`
	})

	app.component('terms', {
		template:
		`<div class="container">
			<div class="container">
				<div class="center-align">
					<h3>使用者條款</h3>
				</div>
				<div class="col s12 m12">
					<div class="card horizontal">
						<div class="card-stacked">
							<div class="card-content">
								<h4>
									<blockquote>
										為了保障您的權益，請詳細閱讀本網站條款中的所有內容，尤其當您在完成註冊程序後，表示您已同意遵守會員條款的規範，並使用SWIFTFOX(本網站)所提供之服務。本站得視必要更新服務條款，不另特別通知。
									</blockquote>
								</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>`
	})

	app.component('serveterms', {
		template:
		`<div class="container">
			<div class="container">
				<div class="center-align">
					<h3>服務條款</h3>
				</div>
				<div class="col s12 m12">
					<div class="card horizontal">
						<div class="card-stacked">
							<div class="card-content">
								<h4>
									<blockquote>
										1.使用限制
										<br>
										1.1 您使用SwiftFox(以下稱本網站)必須遵守中華民國法律及網站的相關規定。
										<br>
										1.2 您不得利用本網站從事任何非法活動，包括但不限於傳播非法信息、侵犯他人權益等。
										<br>
										1.3 您必須尊重其他用戶的合法權益，不得在本網站上進行任何形式的侮辱、誹謗、威脅等行為。
										<br>
										2.使用風險與責任
										<br>
										2.1 您使用本網站所產生的任何風險和責任由您自行承擔，本網站不承擔任何責任。
										<br>
										2.2 您使用本網站時，應當注意保護個人隱私和資料安全，任何因您自身原因導致的資料泄露或其他損失，本網站不承擔責任。
										<br>
										3.免責聲明
										<br>
										3.1 本網站不承擔因使用本網站而產生的任何損失或損害責任，包括但不限於直接損失、間接損失、附帶損失、懲罰性損失等。
										<br>
										3.2 本網站不保證網站的可用性、可靠性、安全性、準確性、完整性和及時性。使用本網站的風險由您自行承擔。
										<br>
										4.修改與終止
										<br>
										4.1 本網站有權在任何時間修改本使用者條款，修改後的條款將立即生效。
										<br>
										4.2 本網站有權在任何時間終止網站的運營，終止後您將無法再使用本網站。
										<br>
										5.爭議解決
										<br>
										5.1 本使用者條款的解釋和適用，以及使用本網站產生的任何爭議，均受中華民國法律管轄。
										<br>
										5.2 任何因使用本網站產生的爭議，雙方應首先通過友好協商解決。如無法協商解決，任何一方均可向本網站所在地的有管轄權的法院提起訴訟。
										<br>
										6.其他條款
										<br>
										6.1 本使用者條款構成您與本網站之間的完整協議，並取代所有先前的口頭或書面協議。
										<br>
										6.2 如果本使用者條款中的任何條款被認定為無效或不可執行，該條款應被認為被取消，但該條款不影響其他條款的有效性和可執行性。
										<br>
										6.3 本使用者條款的標題僅作為參考之用，不具有法律效力。
										<br>
										如果您不同意本使用者條款的任何內容，請停止使用本網站。
									</blockquote>
								</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>`
	})

	app.component('slogan', {
	  	template:
		`<div class="row" id="slogan">
			<h1 class="center-align">
				<b>
					Swift Fox
				</b>
			</h1>
			<h3 class="center-align">
				<b>
					一個簡潔有力的社群軟體
				</b>
			</h3>
		</div>`
	})

	app.component('serve', {
	 	template:
		`<div class="container">
			<div class="row">
				<h3 class="center-align">主要服務</h3>
				<br>
				<div class="col s12 m4">
					<div class="icon-block">
						<h2 class="center light-brown-text"><i class="material-icons large">perm_media</i></h2>
						<h5 class="center"><b>提供學習資料</b></h5>
						<p class="center">提供優良的學習歷程檔案範例</p>
					</div>
				</div>
				<div class="col s12 m4">
					<div class="icon-block">
						<h2 class="center light-brown-text"><i class="material-icons large">comment</i></h2>
						<h5 class="center"><b>用戶經驗分享</b></h5>
						<p class="center">可以進行成果發表與討論分享</p>
					</div>
				</div>
				<div class="col s12 m4">
					<div class="icon-block">
						<h2 class="center light-brown-text"><i class="material-icons large">assessment</i></h2>
						<h5 class="center"><b>相關統計資料</b></h5>
						<p class="center">秉持透明、開放的態度，公開部分統計資料</p>
					</div>
				</div>
			</div>
		</div>`
	})

	app.component('developer', {
		template:
		`<div class="container">
			<div class="container">
				<div class="row">
					<h3 class="center-align">開發團隊</h3>
					<div class="col s12 m12">
						<div class="card horizontal">
							<div class="card-image">
								<img src="images/SWIFT FOX LOGO.png">
							</div>
							<div class="card-stacked">
								<div class="card-content">
									<h4>開發者:張皓明</h4>
									<h4>致力於學習各種後端開發技術</h4>
								</div>
								<div class="card-action">
									<a class="waves-effect waves-light btn brown right" href="https://github.com/Diego09182">Github</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>`
	})

	app.component('tool', {
	  	template:
		`<div class="fixed-action-btn horizontal click-to-toggle">
			<a class="btn-floating btn-large brown">
				<i class="material-icons">menu</i>
			</a>
			<ul>
				<li><a href="#modal2" class="btn-floating btn waves-effect waves-light blue modal-trigger"><i class="tooltipped" data-position="top" data-tooltip="註冊"><i class="material-icons">assignment</i></i></a></li>
				<li><a href="#modal1" class="btn-floating btn waves-effect waves-light blue modal-trigger"><i class="tooltipped" data-position="top" data-tooltip="登入"><i class="material-icons">assignment_ind</i></i></a></li>
			</ul>
		</div>`
	})

	app.use(router);

	const vm = app.mount('#app');
