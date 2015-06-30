<?
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="alphabet">
    <ul>
        <?
        foreach($alphabet as $k=>$v){
            $class = $q == $v ? 'active' : '';
            echo Html::beginTag('li', ['class'=>$class]);
            echo Html::a($v, Url::toRoute(['', 'q' => $v]));
            echo Html::endTag('li');
        }
        ?>
    </ul>
</div>
<div style="clear:both"></div>
<div class="alphabet-words">
    <?
    $models = $dataProvider->getModels();
    $cntInColumn = ceil(count($models)/$columnNumber);
    $k = 0;
    for($i=0; $i<$columnNumber; $i++){
        echo Html::beginTag('ul');
        for($j=$k; $j-$k < $cntInColumn; $j++){
            if(!isset($models[$j]))
                continue;
            $id = $models[$j][$fieldId];
            $name = $models[$j]->$fieldNameDisplay;

            echo Html::beginTag('li');
            $href = Url::toRoute([$editUrl, 'id'=>$id]);
            echo Html::a($name, $href);
            echo Html::endTag('li');
        }
        echo Html::endTag('ul');
        $k = $j;
    }
    ?>
</div>
<div style="clear:both"></div>