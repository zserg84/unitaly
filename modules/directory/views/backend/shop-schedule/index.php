<?php

use modules\directory\Module as DirectoryModule;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\web\View;
use vova07\themes\admin\widgets\Box;
use modules\translations\models\Lang;
use kartik\nav\NavX;

$this->title = DirectoryModule::t('shop-schedule', 'BACKEND_INDEX_TITLE');
$this->params['subtitle'] = DirectoryModule::t('shop-schedule', 'BACKEND_INDEX_SUBTITLE');
$this->params['breadcrumbs'] = [
    [
        'label' => $this->title,
        'url' => ['shop/index'],
    ],
    $this->params['subtitle']
];
Pjax::begin(['id' => 'pjax-schedule-container', 'enablePushState'=>false]);

Pjax::end();

$boxButtons[] = '{cancel}';
$boxButtons = !empty($boxButtons) ? implode(' ', $boxButtons) : null;
$buttons['cancel'] = [
    'url' => ['shop/index'],
    'icon' => 'fa-reply',
    'options' => [
        'class' => 'btn-default',
        'title' => Yii::t('vova07/themes/admin/widgets/box', 'Cancel')
    ]
];
?>
<div class="row">
    <div class="col-xs-12">
        <?php Box::begin(
            [
                'title' => $this->params['subtitle'],
                'bodyOptions' => [
                    'class' => 'table-responsive'
                ],
                'buttonsTemplate' => $boxButtons,
                'buttons' => $buttons,
            ]
        ); ?>
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">
                <?
                $languages = Lang::find()->all();
                $items = [];
                foreach($languages as $language){
                    $item = [
                        'label' => $language->name,
                        'url' => Url::toRoute(['', 'shopId'=>$model->id, 'lang'=>$language->id]),
                        'active' => $language->id == $langId,
                    ];
                    $items[] = $item;
                }

                echo NavX::widget([
                    'options'=>['class'=>'nav nav-pills'],
                    'items' => $items
                ]);
                ?>
            </div>
<!--            <div class="panel-body">-->
<!--                <p>-->
<!--                    -->
<!--                </p>-->
<!--            </div>-->
            <table class="table">
                <tr>
                    <td><?=DirectoryModule::t('shop', 'IDENTIFIER')?></td>
                    <td><?=$model->id?></td>
                </tr>
                <?foreach($schedules as $schedule):?>
                <tr data-schedule="<?=$schedule->id?>">
                    <td>
                        <?
                        $dateInfo = Yii::$app->getFormatter()->asDate($schedule->date_from);
                        $dateInfo .= $schedule->date_to ? ' - ' . Yii::$app->getFormatter()->asDate($schedule->date_to) : '';
                        ?>
                        <?=$dateInfo?>
                        <br />
                        <?=Html::a(DirectoryModule::t('shop-schedule', 'EDIT'), Url::toRoute(['shop-schedule/update', 'id'=>$schedule->id, 'lang'=>$langId]), ['class'=>'schedule-update'])?>
                    </td>
                    <td><?=$schedule->text?></td>
                </tr>
                <?endforeach;?>
            </table>
            <div class="panel-footer">
                <?= Html::a(DirectoryModule::t('shop-schedule', 'BLOCK_CREATE'), Url::toRoute(['shop-schedule/create', 'lang'=>$langId]), [
                    'class' => 'schedule-create',
                ]);?>
            </div>
        </div>
        <?php Box::end(); ?>
    </div>
</div>
<?
$this->registerJs('
    $(".schedule-create").on("click", function() {
        $.pjax({
            url: $(this).attr("href"),
            container: "#pjax-schedule-container",
            data: {shopId: '.$model->id.'},
            push: false,
        });
        return false;
    });
    $(".schedule-update").on("click", function() {
        var scheduleId = $(this).closest("tr").data("schedule");
        $.pjax({
            url: $(this).attr("href"),
            container: "#pjax-schedule-container",
            data: {id: scheduleId},
            push: false,
        });
        return false;
    });
    ',  View::POS_END
);

/*
 * Fake elements (which are used in modal)
 * */
\kartik\date\DatePicker::widget(['name'=>'fake']);
\yii\bootstrap\ActiveForm::widget();