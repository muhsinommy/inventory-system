<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "action".
 *
 * @property int $action_id
 * @property string $route
 */
class Action extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'action';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['route'], 'required'],
            [['route'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'action_id' => 'Action ID',
            'route' => 'Route',
        ];
    }
}
