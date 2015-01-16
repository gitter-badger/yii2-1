<?php

namespace app\modules\user\models;

use Yii;
use yii\caching\DbDependency;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const STATUS_WAIT = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BLOCKED = 2;


    public $verifyPassword;
    public $password;

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function rules()
    {
        return [
            [['email', 'password', 'verifyPassword'], 'required', 'on'=>'register'],
            ['verifyPassword', 'compare', 'compareAttribute'=>'password'],
            ['email', 'email'],

            [['created_at', 'updated_at', 'lastvisit_at', 'status'], 'integer'],
            [['username'], 'string', 'max' => 25],
            [['email'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 60],
            [['role'], 'string', 'max' => 20],

            [['email'], 'unique'],

            [['username'], 'unique', 'on'=>'update'],
        ];
    }

    public static function getStatusesArray()
    {
        return [
            self::STATUS_BLOCKED => 'Заблокирован',
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_WAIT => 'Ожидает подтверждения',
        ];
    }

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

    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($insert == true){
                $this->uniqueUsername();
                $this->generateAuthKey();
                $this->generateEmailConfirmToken();
                $this->setPassword($this->password);
            }
            return true;
        } else {
            return false;
        }
    }

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

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
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
     * Finds user by username
     *
     * @param  string      $username
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
     * Validates password
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
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
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
}