<?
use yii\helpers\Html;
use app\components\LandingFormCreateWidget;

$this->title = Yii::t('app', 'Home Finance');
$this->params['fullpageParams'] = "{
	menu: '.navbar-nav',
	sectionsColor: ['#4BBFC3', '#4BBFC3', '#4BBFC3'],
	anchors:['home', 'finanalysis', 'abilities']}";
$this->params['nav_links'] = [
	['label' => 'Финучет - язык мировой экономики', 
	'url' => '#finanalysis', 
	'linkOptions'=>['data-menuanchor'=>'finanalysis']],
	['label' => 'Возможности',
	'url' => '#abilities',
	'linkOptions'=>['data-menuanchor'=>'abilities']],
	['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']],
	['label' => Yii::t('app', 'Register'), 'url'=>['/user/create'], 'linkOptions'=>['class'=>'btn btn-success btn-sm']],
];
?>
<style>
.landing-1 {
	background: url('images/landing-1.jpg') no-repeat center bottom;
	background-size: cover;
}
.landing-1 .well .well {
	background-color: #4BBFC3;
	border-color: #4BBFC3;
}
.landing-2 {
	background: url('images/landing-2.png') no-repeat center bottom;
	background-size: cover;
}
.landing-2-1 {
	background: url('images/landing-2-1.jpg') no-repeat right bottom;
	background-size: cover;
}
.landing-3 {
	background: url('images/landing-3.jpg') no-repeat center bottom;
	background-size: cover;
}
</style>
<p class="text-center" style="position:fixed;bottom:10px;width:100%;"><span class="glyphicon glyphicon-arrow-down"></span></p>
<div class="section landing-1">
	<div class="text-center col-xs-10 col-xs-offset-1 well">
		<h1 class="text-center"><?= $this->title ?></h1>
		<p><span class="h3">Новая возможность для решения стратегических финансовых задач</span>
		<div class="row lead">
			<div class="col-lg-4"><div class="well well-lg">купить машину сразу или оформить кредит в банке?</div></div>
			<div class="col-lg-4"><div class="well well-lg">продолжать работать на текущем месте или уйти?</div></div>
			<div class="col-lg-4"><div class="well well-lg">прикоснуться к мировому опыту управления финансами!</div></div>
		</div>
		</p>
		<p><?= Html::a('Зарегистрироваться', ['user/create'], ['class'=>'btn btn-success']) ?></p>
		<p class="text-center">Регистрация бесплатна и не отнимет больше 10 секунд. Ваши данные защищены!</p>
	</div>
</div>
<div class="section">
	<div class="slide landing-2">
		<div class="col-xs-10 col-xs-offset-1 well">
			<h2 class="h1 text-center">Финучет - язык мировой экономики...</h2>
			<div class="lead text-justify">
				<p>Финансовый учет - это единый язык современных корпораций, независимо от их национальности. Это язык, на котором разговаривает вся мировая экономика. Базовое понимание этого языка дает ключ к пониманию общих экономических тенденций и позволяет принимать более верные финансовые решения.</p>
				<p class="h2 text-center">...или...</p>
			</div>
		</div>
	</div>
	<div class="slide landing-2-1">
		<div class="col-xs-10 col-xs-offset-1 well">
			<div class="lead text-justify">
				<p class="h2 text-center">... или увлекательный ребус?</p>
				<p>Разбираться в финансовых отчетах больших корпораций - это как собирать пазлы или решать ребусы: для того, чтобы увидеть общую картину происходящего в компании, надо долго поработать над маленькими кусочками, внимательно разбирая их по отдельности.</p>
				<p>Точно те же инструменты по сути, но слегка упрощенные по форме можно использовать для управления собственными деньгами. Конечно, это не заменит чтения хорошей книги, но может дать общее представление об увлекательном мире финансов.</p>
			</div>
		</div>
	</div>
</div>
<div class="section landing-3">
	<div class="text-center" style="position:absolute; bottom:30px; width:100%;">
		<p><?= Html::a('Зарегистрироваться', ['user/create'], ['class'=>'btn btn-success']) ?></p>
	</div>
	<div class="slide">
		<div class="col-xs-10 col-xs-offset-1 well">
			<div class="col-lg-6">
				<p class="h2 text-center">Возможности - Помощники старта</p>
				<p class="lead text-justify">Для быстрого старта есть несколько иллюстрированных процессов, которые в легкой форме расскажут основы финансового учета и планирования, а также помогут создать все нужные счета</p>
			</div>
			<img class="col-lg-6 col-xs-12" src="images/landing-3-1.png" />
		</div>
	</div><div class="slide">
		<div class="col-xs-10 col-xs-offset-1 well">
			<div class="lead text-justify col-lg-6">
				<p class="h2 text-center">Возможности - доступ с мобильных</p>
				В наше время удобная работа с приложением с экрана планшета или телефона - это просто необходимость
			</div><center>
			<img height="500px" class="visible-lg" src="images/landing-3-2.png" />
			<img height="200px" class="visible-xs text-center" src="images/landing-3-2.png" /></center>
		</div>
	</div><div class="slide">
		<div class="col-xs-10 col-xs-offset-1 well">
			<div class="col-lg-6">
				<p class="h2 text-center">Возможности - Баланс</p>
				<p class="lead text-justify">Центральное место в системе, как и в жизни, занимает баланс или обзор счетов. Он показывает текущее состояние финансов в таком же виде, как на него смотрят по утрам топ-менеджеры транс-национальных корпораций</p>
			</div>
			<img class="col-lg-6 col-xs-12" src="images/landing-3-3.png" />
		</div>
	</div><div class="slide">
		<div class="col-xs-10 col-xs-offset-1 well">
			<div class="col-lg-6">
				<p class="h2 text-center">Возможности - Загрузка и анализ транзакций</p>
				<p class="lead text-justify">Каждый месяц очень легко выгрузить транзакции из интернет-банка и загрузить их в автоматический анализатор, который распределит их по нужным счетам и категориям</p>
			</div>
			<img class="col-lg-6 col-xs-12" src="images/landing-3-4.png" />
		</div>
	</div><div class="slide">
		<div class="lead text-justify col-xs-10 col-xs-offset-1 well">
			<div class="col-lg-8">
				<p class="h2 text-center">Возможности - Безопасность</p>
				<p>Для обеспечения сохранности и приватности данных применяется ряд инструментов:</p>
				<ul>
				<li>Шифрование траффика до сайта - никто не сможет перехватить ваши данные на пути к нам</li>
				<li>Система разрешений на уровне приложения - никто, даже администратор, не может открыть чужие финансовые данные</li>
				<li>Шифрование данных - ничто не хранится на сервере в открытом виде</li>
				</ul>
				<p>Вам осталось только придумать надежный пароль или авторизоваться через Google+!</p>
			</div>
			<img class="col-lg-4 visible-lg" src="images/landing-3-5.jpg" />
		</div>
	</div>
</div>