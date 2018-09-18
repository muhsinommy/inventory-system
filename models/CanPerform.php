<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "can_perform".
 *
 * @property int $access_id
 * @property int $role
 * @property int $action
 *
 * @property Role $role0
 */
class CanPerform extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'can_perform';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role', 'action'], 'required'],
            [['role', 'action'], 'integer'],
            [['role'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role' => 'role_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'access_id' => 'Access ID',
            'role' => 'Role',
            'action' => 'Action',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole0()
    {
        return $this->hasOne(Role::className(), ['role_id' => 'role']);
    }
}
