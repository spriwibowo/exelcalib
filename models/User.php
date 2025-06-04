<?php

namespace app\models;

use app\models\helper\MailSpooler;
use Yii;
use yii\db\Exception;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;

class User extends ActiveRecord implements IdentityInterface {

    public $password;
    public $source = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['username', 'email', 'full_name'], 'required'],
            ['username', 'trim'],
            [['username', 'email'], 'unique'],
            ['email', 'email'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['password', 'string', 'min' => 4],
            [['full_name', 'access_token', 'password', 'password_hash', 'reset_token'], 'string'],
            [['tipe', 'entity_id', 'faskes', 'isDeleted','expire_at'], 'integer']
        ];
    }

    public function beforeSave($insert) {

        if (empty($this->access_token)) {
            $this->generateAccessToken();
        }

        if ($this->isNewRecord && empty($this->password)) {
            $p = \app\models\helper\PasswordList::$default;
            $this->password =  $p;
        }


        if (isset($this->password)) {
            $this->setPassword($this->password);
        }


        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'isDeleted' => 0]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        $user = static::findOne(['access_token' => $token, 'isDeleted' => 0]);

        // if($user){
            
        //     $exist = Yii::$app->cache->get($token);
        //     if(!$exist){
        //         $durasi = 60 * 60 * 1;
        //         $time = time() + $durasi;
        //         $date_time = date('Y-m-d H:i:s',$time);
        //         $user->generateAccessToken();
        //         $user->save();

        //         Yii::$app->cache->set($user->access_token, $date_time, $durasi);
        //     }else{
        //         return $user;
        //     }
        // }

        // return false;
        return $user;

    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'isDeleted' => 0]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates access token
     */
    public function generateAccessToken() {
        $this->access_token = Yii::$app->security->generateRandomString(100) . '_' . time();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey() {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey) {
        return true;
    }


    public function getTitle() {
        $prefix = '';
        if ($this->isDeleted) {
            $prefix = '[X]';
        }

        return $prefix . $this->full_name;
    }

    public function getCreatedate() {
        return date('Y-m-d H:i', $this->created_at);
    }

    public static function ListTipe(){
        return [
            1=>'Administrator',
            2=>'User A',
            3=>'User B',
        ];
    }

    public function getTipe_text() {
        $list = self::ListTipe();
        return isset($list[$this->tipe])?$list[$this->tipe]:'-';
    }




    public $sender_email = 'noreplay@aspak.kemkes.go.id';

    public $domain_reset = 'http://localhost/exelcalib/web/';

    public function generateResetToken() {
        $this->reset_token = Yii::$app->security->generateRandomString(50);
    }

    public function removeResetToken() {
        $this->reset_token = null;
    }

    public function getUrl_reset() {
        return $this->domain_reset . 'site/resetpassword?token=' . $this->reset_token;
    }

    public function sendEmailReset($link) {

        $url_reset = $link . '?token=' . $this->reset_token;

        try {

//            $mailobject = Yii::$app->mailer;            
//            $transport = $mailobject->getTransport();
//            $transport->setHost('sisfomedika.com');
//            $transport->setUsername('agent@sisfomedika.com');
//            $transport->setPassword('CFzcPi;8I4f7');
//            $mailobject->setTransport($transport);

            $mailobject = MailSpooler::getAgent();
            $mailobject->compose(
                            ['html' => 'reset_password'], [
                        'url_reset' => $url_reset,
                            ]
                    )
                    ->setFrom($this->sender_email)
                    ->setTo($this->email)
                    ->setSubject('Reset Password')->send();
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    
      public function sendResetpassword($password) {

      
        try {

            $mailobject = MailSpooler::getAgent();
            $mailobject->compose(
                            ['html' => 'password_reseted'], [
                        'reseted' => $password,
                            ]
                    )
                    ->setFrom($this->sender_email)
                    ->setTo($this->email)
                    ->setSubject('Reset Password')->send();
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    
    

}
