<?php

namespace app\modules\feedback\models;

use Yii;

/**
 * This is the model class for table "feedback".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $message
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Feedback extends \yii\db\ActiveRecord
{

    public $verifyCode;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feedback';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'message'], 'required'],
            [['message'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'email'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 15],
            ['name', 'match', 'pattern' => "/^[а-яА-ЯёЁa-zA-Z\s'`]+$/iu", 'message' => 'Недопустимое имя'],
            ['email', 'email', 'message' => "Электронная почта неверна"],
            ['phone', 'match', 'pattern' => "/^[\+]?[(]?[998]{3}[)]?[0-9]{9}$/i", 'message' => 'Недопустимое номер (например: +998941112233)'],
            ['message', 'filter', 'filter' => function ($value) {
                return strip_tags($value);
            }],
            ['verifyCode', 'captcha', 'captchaAction' => '/feedback/send/captcha']
        ];
    }

    public function beforeSave($insert)
    {
        $this->created_at = Yii::$app->formatter->asTimestamp(date('Y-d-m h:i'));
        return parent::beforeSave($insert);
    }


    public function afterFind()

    {
        $this->created_at = date('Y-m-d / h:i', $this->created_at);
        parent::afterFind();

    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'message' => 'Message',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'verifyCode' => "Verification code"
        ];
    }
}
