<?php

namespace modules\directory\models\search;


use modules\directory\models\Room;
use yii\data\ActiveDataProvider;

class RoomSearch extends Room
{
    public function rules()
    {
        return [
            [['id', 'desc_short'], 'safe'],
        ];
    }

    public function search($params = null)
    {
        $query = self::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->lang();

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'desc_short' => [
                    'asc' => ['room_lang.desc_short' => SORT_ASC],
                    'desc' => ['room_lang.desc_short' => SORT_DESC],
                    'default' => SORT_ASC
                ],
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            $query->innerJoinWith(['roomLangs']);
            return $dataProvider;
        }

        $query->andFilterWhere(['=', 'room.id', $this->id]);

        $query->innerJoinWith(['roomLangs' => function ($q) {
            if ($this->desc_short)
                $q->where('room_lang.desc_short LIKE "%' . $this->name . '%"');
        }]);

        return $dataProvider;
    }
}
