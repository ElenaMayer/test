<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $email
 * @property string|null $password
 * @property string|null $authKey
 * @property string|null $accessToken
 * @property string|null $name
 * @property string|null $surname
 * @property string|null $phone
 * @property string|null $sex
 * @property string|null $birthday
 * @property int|null $created_at
 */


use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{

    public $birthday_day;
    public $birthday_month;
    public $birthday_year;

    public $confirm;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'birthday_day', 'birthday_month', 'birthday_year', 'name', 'surname', 'phone'], 'required'],
            [['birthday', 'birthday_day', 'birthday_month', 'birthday_year'], 'safe'],
            [['created_at'], 'integer'],
            [['email', 'name', 'surname', 'phone', 'sex'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['password'], 'string', 'max' => 60],
            [['authKey', 'accessToken'], 'string', 'max' => 32],
            ['confirm', 'required', 'requiredValue' => 1, 'message' => 'Ознакомьтесь с правилами.'],
            ['email', 'unique'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'phone' => 'Телефон',
            'sex' => 'Пол',
            'birthday' => 'Дата рождения',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function validatePassword($password)
    {

        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            $this->birthday = $this->birthday_day . '.' . $this->birthday_month . '.' . $this->birthday_year;
            if ($insert) {
                $password = Yii::$app->security->generateRandomString(6);
                $this->setAttribute('password', Yii::$app->security->generatePasswordHash($password));

                $this->sendEmail("Ваши данные для входа: эл. почта - $this->email, пароль - $password", $this->email, 'Добро пожаловать');
                return true;
            }
        } else {
            return false;
        }
    }

    public function sendEmail($body, $email, $subject){
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([Yii::$app->params['adminEmail']])
            ->setSubject($subject)
            ->setTextBody($body)
            ->send();
    }

    public static function getDateList(){
        $list = [];
        for ($i=1;$i<=31;$i++){
            $list[$i] = $i;
        }
        return $list;
    }

    public static function getMonthList(){
        return [
            1 => 'Январь',
            2 => 'Февраль',
            3 => 'Март',
            4 => 'Апрель',
            5 => 'Май',
            6 => 'Июнь',
            7 => 'Июль',
            8 => 'Август',
            9 => 'Сентябрь',
            10 => 'Октябрь',
            11 => 'Ноябрь',
            12 => 'Декабрь',
        ];
    }

    public static function getYearList(){
        $list = [];
        for ($i=date('Y');$i>1920;$i--){
            $list[$i] = $i;
        }
        return $list;
    }
}
