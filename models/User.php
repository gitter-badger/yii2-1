<?php

namespace app\models;

use Yii;
use yii\caching\DbDependency;

/**
 * This is the model class for table "y_user".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $auth_key
 * @property string $email_confirm_token
 * @property string $role
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $lastvisit_at
 * @property integer $status
 *
 * @property Profile $profile
 */

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const STATUS_WAIT = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BLOCKED = 2;

    /** @var string */
    public $password;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique'],

            ['password', 'required'],
            ['password', 'string', 'max' => 60],

            ['username', 'string', 'max' => 25],
            ['username', 'unique'],

            [['email', 'password'], 'required', 'on'=>'register'],
            ['email', 'email'],

            ['created_at', 'integer'],

            ['updated_at', 'integer'],

            ['lastvisit_at', 'integer'],

            ['status', 'integer'],

            ['role', 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Пароль',
            'verifyPassword' => 'Повторите пароль',
            'role' => 'Role',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'lastvisit_at' => 'Lastvisit At',
            'status' => 'Status',
        ];
    }

    /**
     * Безопасные поля
     *
     * @return array
     */
    public function fields() {
        return [
            'id',
            'email',
            'firstName' => $this->profile->first_name,
            'lastName' => $this->profile->last_name,
            'fullName' => function ($model) {
                return $model->profile->first_name . ' ' . $model->profile->last_name;
            },
            'email_confirm_token',
            'auth_key',
            'status'
        ];
    }

    /**
     * @inheritdoc
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }

    /**
     * Все доступные пользователю статусы
     * @return array
     */
    public static function getStatusesArray()
    {
        return [
            self::STATUS_BLOCKED => 'Заблокирован',
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_WAIT => 'Ожидает подтверждения',
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($insert == true){
                $this->status = self::STATUS_WAIT;
                $this->generateAuthKey();
                $this->generateEmailConfirmToken();
                $this->setPassword();
                $this->sendEmailConfirm();
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Устанавливает уникальный username пользователю
     * @param null $username
     */
    public function uniqueUsername( $username = null ){
        if($username == null) $username = $this->username;
        $user = self::find()->where(['username' => $username])->one();
        if($user){
            $names = explode('_', $username);
            $n = array_pop( $names );
            if(is_numeric($n)){
                $names[] = (int)$n +1;
                $this->uniqueUsername( implode("_", $names) );
            } else {
                $this->uniqueUsername( $username . "_1" );
            }
        } else {
            $this->username = $username;
        }
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * Поиск пользователя по id
     *
     * @param int|string $id
     * @return User|null
     */
    public static function findIdentity($id)
    {
        $dependency = new DbDependency([
            'sql' => 'SELECT MAX(updated_at) FROM {{%user}}',
        ]);
        $user = (new \yii\db\Query())
            ->select('*')
            ->from( self::tableName() )
            ->where('id=:id AND status=:status', [':id' => (int)$id, ':status' => self::STATUS_ACTIVE])
            ->createCommand()
            ->cache(Yii::$app->db->schemaCacheDuration, $dependency)
            ->queryOne();
        return $user ? new static($user) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('findIdentityByAccessToken is not implemented.');
    }

    /**
     * Поиск пользователя по username
     *
     * @param  string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $dependency = new DbDependency([
            'sql' => 'SELECT MAX(updated_at) FROM {{%user}}',
        ]);
        $user = (new \yii\db\Query())
            ->select('*')
            ->from( self::tableName() )
            ->where('username=:username', [':username' => $username])
            ->createCommand()
            ->cache(Yii::$app->db->schemaCacheDuration, $dependency)
            ->queryOne();
        return $user ? new static($user) : null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Валидация пароля
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     */
    public function setPassword()
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @param string $email_confirm_token
     * @return static|null
     */
    public static function findByEmailConfirmToken($email_confirm_token)
    {
        return static::findOne(['email_confirm_token' => $email_confirm_token, 'status' => self::STATUS_WAIT]);
    }

    /**
     * Generates email confirmation token
     */
    public function generateEmailConfirmToken()
    {
        $this->email_confirm_token = Yii::$app->security->generateRandomString();
    }

    /**
     * Removes email confirmation token
     */
    public function removeEmailConfirmToken()
    {
        $this->email_confirm_token = null;
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Отправка письма для подтрерждения email адреса при регистрации
     * @return bool
     */
    public function sendEmailConfirm(){
        $confirmLink = Yii::$app->urlManager
            ->createAbsoluteUrl(['user/default/confirm-email', 'token' => $this->email_confirm_token]);
        return Yii::$app->mailer
            ->compose('confirmEmail', ['confirmLink' => $confirmLink, 'username' => $this->username ])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setTo($this->email)
            ->setSubject('Подтверждения email адреса ' . Yii::$app->name)
            ->send();
    }

    /**
     * Подтверждение имейла из письма высланного на email при регистрации
     * @params string $token
     * @return array - статус и сообщение о результате
     */
    public static function confirmEmail($token){
        if (empty($token) || !is_string($token))
            return [
                'status' => false,
                'message' => 'Отсутствует код подтверждения.'
            ];
        $user = self::findByEmailConfirmToken($token);
        if (!$user)
            return [
                'status' => 'error',
                'message' => 'Неверный токен.'
            ];
        if($user->status == self::STATUS_ACTIVE)
            return [
                'status' => 'success',
                'message' => 'Ваш акаунт активен.'
            ];
        if($user->status == self::STATUS_BLOCKED)
            return [
                'status' => 'error',
                'message' => 'Ваш акаунт заблокирован администрацией.'
            ];
        $user->status = self::STATUS_ACTIVE;
        if($user->save(false))
            return [
                'status' => 'success',
                'message' => 'Email успешно подтвержден и акаунт активирован.'
            ];
        else
            return [
                'status' => 'error',
                'message' => 'Произошла ошибка активации акаунта. Попробуйте еще раз или напишите нам.'
            ];
    }
}