<?
use yii\helpers\Html;
use app\components\LandingFormCreateWidget;
use app\components\LightroomSingle;

$this->title = Yii::t('app', 'Home Finance');
$this->params['fullpageParams'] = "{
	menu: '.navbar-nav',
	sectionsColor: ['#4BBFC3', '#4BBFC3', '#4BBFC3'],
	anchors:['home', 'finanalysis', 'abilities']}";
$this->params['nav_links'] = [
	['label' => 'Главная', 
	'url' => '#home', 
	'linkOptions'=>['data-menuanchor'=>'home']],
	['label' => 'О чем это?', 
	'url' => '#finanalysis', 
	'linkOptions'=>['data-menuanchor'=>'finanalysis']],
	['label' => 'Зачем это?',
	'url' => '#abilities',
	'linkOptions'=>['data-menuanchor'=>'abilities']],
	['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']],
	['label' => Yii::t('app', 'Register'), 'url'=>['/user/create'], 'linkOptions'=>['class'=>'btn btn-success btn-sm']],
];
?>
<style>
    .modal-dialog {
        margin-left:10%;
        width:80%;
    }
    .landing-1 {
            background: url('images/landing-1.jpg') no-repeat center bottom;
            background-size: cover;
    }
    .landing-1 .well .well {
            background-color: #fcee81;
            border-color: #fcee81;
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
    .arrow-down {
        position: absolute;
        bottom: 15px;
        border-width: 34px 38.5px 0 38.5px;
        border-color: #fff transparent transparent transparent;
        cursor: pointer;
        width: 0;
        height: 0;
        border-style: solid;
        margin-left: -38px;
        z-index:4;
    }
</style>
<div class="section landing-1">
	<p class="text-center" style=""><span class=" arrow-down"></span></p>
	<div class="text-center col-xs-10 col-xs-offset-1 well">
		<h1 class="text-center"><?= $this->title ?></h1>
		<p><span class="h3">Новая возможность для решения стратегических финансовых задач</span>
		<div class="row lead">
			<div class="col-lg-4"><div class="well well-lg well-lg-only">Купить машину за наличные или оформить кредит в банке?</div></div>
			<div class="col-lg-4"><div class="well well-lg well-lg-only">Продолжать работать на текущем месте или искать новое?</div></div>
			<div class="col-lg-4"><div class="well well-lg well-lg-only">Прикоснуться к мировому опыту управления финансами.</div></div>
		</div>
		</p>
		<p><?= Html::a('Зарегистрироваться', ['user/create'], ['class'=>'btn btn-success']) ?></p>
		<p class="text-center">Регистрация бесплатна и не отнимет больше 10 секунд. Ваши данные защищены.</p>
	</div>
</div>
<div class="section">
	<div class="slide landing-2">
		<div class="col-xs-10 col-xs-offset-1 well">
			<h2 class="h1 text-center">Финансовый учет - язык мировой экономики...</h2>
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
			</div>
		</div>
	</div>
</div>
<div class="section landing-3">
	<div class="slide">
		<div class="col-xs-10 col-xs-offset-1 well">
			<p class="h2 text-center">Возможности: Помощники старта</p><br/>
			<div class="col-lg-6">
				<p class="lead text-justify">Для быстрого старта есть несколько иллюстрированных процессов, которые в легкой форме расскажут основы финансового учета и планирования, а также помогут создать все нужные счета.</p>
			</div>
                        <?= LightroomSingle::widget([
                            'header_title' => 'Помощники старта',
                            'image_url'=>'images/landing-3-1.png', 
                            'toggle_options'=>['class'=>'col-lg-6 col-xs-12 visible-lg']
                        ]) ?>
		</div>
	</div><div class="slide">
		<div class="col-xs-10 col-xs-offset-1 well">
			<p class="h2 text-center">Возможности: доступ с мобильных</p><br/>
			<div class="lead text-justify col-lg-6">
				В наше время удобная работа с приложением с экрана планшета или телефона - это не особенность, это просто необходимость. Все интерфейсы системы адаптированы для удобного доступа с платшета и приемлемого доступа с телефона. Как ни крути, но посмотреть отчет по баласу на телефоне все равно трудно.
			</div><center>
                        <img class="visible-lg" height="200px" src="images/landing-3-2.png" /></center>
		</div>
	</div><div class="slide">
		<div class="col-xs-10 col-xs-offset-1 well">
			<p class="h2 text-center">Возможности: Баланс</p><br/>
			<div class="col-lg-6">
				<p class="lead text-justify">Центральное место в системе занимает баланс или обзор счетов. Он показывает текущее состояние финансов в таком же виде, как на него смотрят по утрам топ-менеджеры транс-национальных корпораций.</p>
			</div>
                        <?= LightroomSingle::widget([
                            'header_title' => 'Баланс - обзор счетов',
                            'image_url'=>'images/landing-3-3.png', 
                            'toggle_options'=>['class'=>'col-lg-6 col-xs-12 visible-lg']
                        ]) ?>
		</div>
	</div><div class="slide">
		<div class="col-xs-10 col-xs-offset-1 well">
			<p class="h2 text-center">Возможности: Загрузка и анализ транзакций</p><br/>
			<div class="col-lg-6">
				<p class="lead text-justify">Когда вы оплачиваете что-то по карте, ваш банк сохраняет эту информацию и может предоставить ее в виде электронной таблицы. Такой вид можно легко прочитать и загрузить, чтобы сравнить данные по транзакциям с изменениями в балансе.</p>
			</div>
                        <?= LightroomSingle::widget([
                            'header_title' => 'Загрузка и анализ транзакций',
                            'image_url'=>'images/landing-3-4.png', 
                            'toggle_options'=>['class'=>'col-lg-6 col-xs-12 visible-lg']
                        ]) ?>
		</div>
	</div><div class="slide">
		<div class="lead text-justify col-xs-10 col-xs-offset-1 well">
			<p class="h2 text-center">Безопасность</p><br/>
			<div class="col-lg-8">
				<p>Для обеспечения сохранности и приватности данных используется:</p>
				<ul>
				<li>Шифрование канала до сайта<span class="visible-lg"> - никто не сможет перехватить ваши данные на пути к нам<span></li>
				<li>Система разрешений на уровне приложения<span class="visible-lg"> - никто, даже администратор, не может открыть чужие финансовые данные<span></li>
				<li>Шифрование данных<span class="visible-lg"> - ничто не хранится на сервере в открытом виде<span></li>
				</ul>
				<p>Вам осталось только придумать надежный пароль или авторизоваться через Google+!</p>
			</div>
			<img class="col-lg-4 visible-lg" src="images/landing-3-5.jpg" />
		</div>
	</div>
	
	<div class="text-center" style="z-index:10; position:absolute; bottom:30px; width:100%;">
		<p class="text-center"><?= Html::a('Зарегистрироваться', ['user/create'], ['class'=>'btn btn-success']) ?></p>
	</div>
</div>