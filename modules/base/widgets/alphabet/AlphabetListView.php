<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 01.06.15
 * Time: 15:05
 */

namespace modules\base\widgets\alphabet;

use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\widgets\ListView;

class AlphabetListView extends ListView
{

    const DEFAULT_Q = 'А';

    public $alphabet;

    public $q = self::DEFAULT_Q;

    public $columnNumber = 3;

    public $editUrl = 'update';

    public $fieldId = 'id';

    public $fieldName = 'name';

    public $fieldNameDisplay;

    public $layout = "{items}\n{pager}";

    public function init(){
        $this->alphabet = $this->alphabet ? $this->alphabet : [
            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ы', 'Э', 'Ю', 'Я'
        ];

        $this->q = $this->q ? $this->q : \Yii::$app->getRequest()->get('q', current($this->alphabet));

        $this->fieldNameDisplay = $this->fieldNameDisplay ? $this->fieldNameDisplay : $this->fieldName;

        /*
         * Если запрос не обрезан по букве алфавита, обрезаем его принудительно
         * */
//        $query = $this->dataProvider->query;
//        $query->andFilterWhere(['like', $this->fieldName, $this->q]);
//        $dataProvider = clone $this->dataProvider;
//        $dataProvider->query = $query;
//        $dataProvider->prepare();
//        $this->dataProvider = $dataProvider;

        $models = $this->dataProvider->getModels();
        $itogModels = [];
        foreach($models as $k=>$model){
            if(mb_strtoupper(mb_substr($model[$this->fieldNameDisplay],0,1,'utf-8'), 'UTF-8') != mb_strtoupper($this->q, 'UTF-8'))
                continue;
            $itogModels[] = $model;
        }
        $this->dataProvider->setModels($itogModels);
    }

    public function renderItems()
    {
        echo $this->render('alphabet', [
            'dataProvider' => $this->dataProvider,
            'alphabet' => $this->alphabet,
            'q' => $this->q,
            'columnNumber' => $this->columnNumber,
            'editUrl' => $this->editUrl,
            'fieldId' => $this->fieldId,
            'fieldNameDisplay' => $this->fieldNameDisplay,
        ]);
    }

    public function renderEmpty()
    {
        echo $this->renderItems();
        return parent::renderEmpty();
    }
} 