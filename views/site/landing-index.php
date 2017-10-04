<?
use yii\helpers\Html;
use app\components\LandingFormCreateWidget;

$this->title = Yii::t('app', 'Home Finance');
$this->params['fullpageParams'] = "{anchors:['home', 'finanalysis', 'opportunities']}";
$this->params['nav_links'] = [
	['label' => 'Финучет - язык мировой экономики', 'url' => '#finanalysis'],
	['label' => 'Возможности', 'url' => '#opportunities'],
	['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']],
	['label' => Yii::t('app', 'Register'), 'url'=>['/user/create'], 'linkOptions'=>['class'=>'btn btn-success btn-sm']],
];
?>
<p class="text-center" style="position:fixed;bottom:10px;width:100%;"><span class="glyphicon glyphicon-arrow-down"></span></p>
<div class="section">
	<div class="row">
	<div class="text-center col-lg-10 col-lg-offset-1">
		<h1 class="text-center"><?= $this->title ?></h1>
		<p><span class="h3">Новая возможность для решения стратегических финансовых задач</span>
		<div class="row lead">
			<div class="col-lg-4"><div class="well well-lg">купить машину сразу или оформить кредит в банке?</div></div>
			<div class="col-lg-4"><div class="well well-lg">продолжать работать на текущем месте или уйти?</div></div>
			<div class="col-lg-4"><div class="well well-lg">прикоснуться к мировому опыту управления финансами!</div></div>
		</div>
		</p>
		<p><?= Html::a('Зарегистрироваться и начать!', ['user/create'], ['class'=>'btn btn-success']) ?></p>
		<p class="text-center">Регистрация бесплатна и не отнимет больше 10 секунд</p>
	</div>
	</div>
</div>
<div class="section">
	<div class="row">
	<div class="col-lg-10 col-lg-offset-1">
		<p class="h1 text-center">Финучет - язык мировой экономики</p>
		<div class="lead text-justify">
			<p>Финансовый учет - это единый язык современных корпораций, независимо от их национальности. Это язык, на котором разговаривает вся мировая экономика. Базовое понимание этого языка дает ключ к пониманию общих экономических тенденций и позволяет принимать более верные финансовые решения.</p>
			<p class="h2 text-center">...или увлекательный ребус?</p>
			<p>Разбираться в финансовых отчетах больших корпораций - это как собирать пазлы или решать ребусы: для того, чтобы увидеть общую картину происходящего в компании, надо долго поработать над маленькими кусочками, внимательно разбирая их по отдельности. Взять большую, известную корпорацию, найти ее финансовую отчетность (в большинстве случаев это - открытая информация), и изучить ее шаг за шагом, строка за строкой. Как, собирая пазл, можно видеть постепенно проявляющуюся картинку, так и, разбирая, скажем, баланс Mail.Ru Group, можно увидеть скрытые мотивы их недавней сделки.</p>
			<p>Точно те же инструменты по сути, но слегка упрощенные по форме можно использовать для управления собственными деньгами. Конечно, это не заменит чтения хорошей книги, но может дать общее представление об увлекательном мире финансов.</p>
		</div>
	</div>
	</div>
</div>
<div class="section">
	<div class="row">
	<div class="col-lg-10 col-lg-offset-1">
		<p class="h1 text-center">Возможности</p>
		<div>
			<p class="h2 text-center">Помощники старта</p>
			<p class="lead text-justify">Для быстрого старта есть несколько иллюстрированных процессов, которые в легкой форме расскажут основы финансового учета и планирования, а также помогут создать все нужные счета</p>
		</div>
		<div>
			<p class="h2 text-center">Баланс</p>
			<p class="lead text-justify">Центральное место, как и в жизни, занимает баланс - или обзор счетов. Он показывает текущее состояние финансов в таком же виде, как на него смотрят по утрам топ-менеджеры транс-национальных корпораций</p>
		</div>
		<div>
			<p class="h2 text-center">Загрузка и анализ транзакций</p>
			<p class="lead text-justify">Каждый месяц очень легко выгрузить транзакции из интернет-банка и загрузить их в автоматический анализатор, который распределит их по нужным счетам и категориям</p>
		</div>
	</div>
	</div>
</div>