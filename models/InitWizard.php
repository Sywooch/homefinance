<?php

namespace app\models;

use Yii;
use \yii\helpers\Json;

class InitWizard extends BasicProcess
{
	public $code = 'init';
	public $title = 'Быстрый старт';
	public $description = 'Этот мастер поможет вам быстро настроить счета вашего бухгалтерского баланса';
	public $finishMessage = 'Спасибо за использование мастера.';
	public $finishLink = ['Перейти к заполнению баланса', ['balance-item/index']];
	public $steps = [
		[
			'code'=>'init1',
			'title'=>'Введение',
			'stage'=>'Введение',
			'type_id'=>'',
			'message'=>'
В основе бухгалтерского учета - разделение активов и пассивов. Если коротко, то в теории:<br/>
 - <strong>Актив</strong> - это то, как вы используете ваши деньги, использование должно быть выгодным, т.е. активы во многих случаях определяют ваши доходы;<br/>
 - <strong>Пассив</strong> - это источники ваших денег, многие из которых не бесплатны, т.е. пассивы во многих случаях определяют ваши расходы.</br/></br/>
Основные характеристики актива - это <strong>сумма, доходность и ликвидность</strong>. Основные характеристики пассива - это <strong>сумма, стоимость и срочность</strong>. И ликвидность активов, и срочность пассивов имеют по три градации: высоко-, средне- и низколиквидные активы и кратко-, средне- и долгосрочные пассивы.<br/>
Общая сумма всех активов всегда равна общей сумме всех пассивов.
',
		],
		[
			'code'=>'init2',
			'title'=>'Наличные деньги',
			'stage'=>'Активы - Высоколиквидные',
			'type_id'=>'1',
			'message'=>'Наличные деньги, как правило, самый плохой вариант с точки зрения накопления и инвестиций. Однако, наличные бывают нужны, если нет быстрого доступа к деньгам на карте или, например, в качестве НЗ в банковской ячейке (не на счете).<br/>Если у вас есть и наличные, и карта, на которую не начисляются проценты, возможно, нет смысла учитывать их по отдельности.',
			'buttons'=>'yesno',
		],
		[
			'code'=>'init3',
			'title'=>'Счета без процентов',
			'stage'=>'Активы - Высоколиквидные',
			'type_id'=>'1',
			'message'=>'Счета без процентов, к сожалению, все еще являются очень распространенной банковской практикой, хотя и не имеют экономического смысла: вы отдаете свои деньги банку, чтобы он их использовал в своих краткосрочных операциях для получения прибыли, а он вам за это ничего не платит.',
			'buttons'=>'yesno',
		],
		[
			'code'=>'init4',
			'title'=>'Счета под проценты',
			'stage'=>'Активы - Высоколиквидные',
			'type_id'=>'1',
			'message'=>'Счета под проценты - самый современный способ хранения текущих денег: позволяет совместеть высокую доступность денег с их инвестированием. Это может быть либо дебетовая карта, где начисляется процент на остаток, или накопительный счет с возможностью мгновенного снятия и пополнения.',
			'buttons'=>'yesno',
		],
		[
			'code'=>'init5',
			'title'=>'Вклады',
			'stage'=>'Активы - Среднеликвидные',
			'type_id'=>'2',
			'message'=>'Вклады - это первый шаг к инвестированию. С одной стороны они требуют более высокого уровня планирования своих финансовых потоков, т.к. по сути замораживают часть средств, но с другой стороны, обеспечивают более высокую доходность, чем карточные или накопительные счета. Это дает шанс хотя бы сравняться с инфляцией.',
			'buttons'=>'yesno',
		],
		[
			'code'=>'init6',
			'title'=>'Другие инвестиции',
			'stage'=>'Активы - Среднеликвидные',
			'type_id'=>'2',
			'message'=>'Вы можете применять любые инвестиционные инструменты и детализировать счета так, как вам удобно. Можете отдельно завести акции, облигации, структурные продукты или форекс, если занимаетесь всеми этими инструментами. А можете сгруппировать их все в один счет для простоты.',
			'buttons'=>'yesno',
		],
		[
			'code'=>'init7',
			'title'=>'Имущество',
			'stage'=>'Активы - Низколиквидные',
			'type_id'=>'3',
			'message'=>'Низколиквидные активы - это имущество, например, машина или квартира. Строго говоря, если имущество куплено не в кредит, то лучше его выводить за рамки учета (бухгалтерский термин - <strong>забалансовые активы</strong>), если только они не были куплены с целью перепродажи.',
			'buttons'=>'yesno',
		],
		[
			'code'=>'init8',
			'title'=>'Текущий остаток',
			'stage'=>'Пассивы - Свои средства',
			'type_id'=>'4',
			'message'=>'Текущий остаток - это счет, относящийся к капиталу, ближайшим аналогом которого является <strong>счет №84 бухгалтерского плана “Нераспределенная прибыль (непокрытый убыток)”</strong>, который по сути является балансиром между активами и пассивами, показывающим, хватает ли вам пассивов, чтобы обеспечить все активы. Поэтому этот счет является обязательным и служит базовым показателем качественного управления своими деньгами.',
			'buttons'=>'submit',
		],
		[
			'code'=>'init9',
			'title'=>'Капитал',
			'stage'=>'Пассивы - Свои средства',
			'type_id'=>'11',
			'message'=>'Базовый капитал - это счет, ближайшим аналогом которого, хоть и весьма отдаленным, является <strong>счет №80 “Уставный капитал”</strong>; в рамках системы используется в основном в корреспонденции с низколиквидными активами (имуществом).',
			'buttons'=>'yesno',
		],
		[
			'code'=>'init10',
			'title'=>'Отпуск',
			'stage'=>'Пассивы - Резервы',
			'type_id'=>'5',
			'message'=>'Всем нужно отдыхать, и на отдых часто нужны деньги. Источником денег для отпуска могут быть кредиты, но лучше формировать резеры. <strong>Резервы</strong> - это специальные счета, показывающие, что часть своих денег вы решили потратить на что-то конкретное, при этом не ограничивая текущее использование этих денег.<br/>Классический банковский продукт - целевой накопительный счет - позиционируется для решения той же задачи, но он, являясь активом, подменяет собой понятие резерва (пассива), что приводит к невозможности использовать те же деньги более эффективно.',
			'buttons'=>'yesno',
		],
		[
			'code'=>'init11',
			'title'=>'Резервный фонд',
			'stage'=>'Пассивы - Резервы',
			'type_id'=>'6',
			'message'=>'Резервный фонд - это деньги, используемые строго в консервативных инструментах (с высокой надежностью и низким риском, например, банковские вклады). Основная задача - обеспечение сохранения уровня жизни в случае любых неудач по более рискованным инвестициям. Хорошим показателем будет иметь такой резерв в размере трехкратных месячных затрат.',
			'buttons'=>'yesno',
		],
		[
			'code'=>'init12',
			'title'=>'Долгосрочные цели',
			'stage'=>'Пассивы - Резервы',
			'type_id'=>'7',
			'message'=>'Долгосрочные резервы целиком и полностью зависят от ваших жизненных целей, например, накопить на покупку машины, квартиры, на ремонт, на обучение пятерых детей в Оксфорды и т.п. Вы можете детализировать эти резервы или использовать один общий счет.',
			'buttons'=>'yesno',
		],
		[
			'code'=>'init13',
			'title'=>'Кредитные карты',
			'stage'=>'Пассивы - Краткосрочные обязательства',
			'type_id'=>'8',
			'message'=>'Кредитные карты - это, как правило, самый дорогой из возможных источников средств. При правильном использовании, конечно, можно свести стоимость этих денег к нулю (если не выходить из grace period), но это не изменяет факта, что процентная ставка по картам одна из самых высоких.',
			'buttons'=>'yesno',
		],
		[
			'code'=>'init14',
			'title'=>'Текущие кредиты',
			'stage'=>'Пассивы - Среднесрочные обязательства',
			'type_id'=>'9',
			'message'=>'Если у вас есть текущие кредиты кроме карт и ипотеки, например, кредит на ремонт или на машину, их можно учитывать здесь.',
			'buttons'=>'yesno',
		],
		[
			'code'=>'init15',
			'title'=>'Ипотека',
			'stage'=>'Пассивы - Долгосрочные обязательства',
			'type_id'=>'10',
			'message'=>'Ипотека - долгосрочный кредит на приобретение недвижимости.',
			'buttons'=>'yesno',
		],
	];
	
	public function getView($view) {
		if ($view == 'perform') return 'perform_init';
		return $view;
	}
	
	public function performStep($step)
	{
		if (parent::performStep($step)) {
			// ...custom code here...
			if ($step->code == 'init1') {
				//init two months on the first step
				$model = new BalanceSheet();
				$model->prepareNext();
				if($model->save()) $model->initAmounts();
				$model = new BalanceSheet();
				$model->prepareNext();
				if($model->save()) $model->initAmounts();
			}
			return $this->createBalanceItem($step);
		} else {
			return false;
		}
	}
	
	private function createBalanceItem($step)
	{
		if ($step->type_id > '') {
			// create balance item
			$model = new BalanceItem();
			$model->prepareNew();
			$model->name = $step->title;
			$model->immutable = $step->buttons != 'yesno' ? 1 : 0;
			$model->balance_type_id = $step->type_id;
			// save balance item
			if ($model->save()) {
				// create accounts and amounts (balance sheets already exist)
				$result = $model->initAccounts();
				if ($result) {
					// if accounts were not created
					$step->error = Json::encode($result);
					return false;
				} else {
					// if success, fill in the amount
					$model->accounts[0]->balanceAmounts[1]->amount = 0 + $_POST['init_value'];
					// save amount
					if(!$model->accounts[0]->balanceAmounts[1]->save()) {
						// if failed
						$step->error = Json::encode($model->accounts[0]->balanceAmounts[1]->errors);
						return false;
					}
				}
			} else {
				// if balance item was not saved
				$step->error = Json::encode($model->errors);
				return false;
			}
		}
		return true;
	}
}
?>