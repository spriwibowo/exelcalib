<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\helper;

use Yii;

/**
 * Description of MailSpooler
 *
 * @author aqge
 */
class MailSpooler {

    //put your code here
    public static function getAgent() {
        $mailobject = Yii::$app->mailer;
        $transport = $mailobject->getTransport();

        $address = self::getSender();

        $transport->setHost($address['host']);
        $transport->setUsername($address['username']);
        $transport->setPassword($address['password']);
        $mailobject->setTransport($transport);

        return $mailobject;
    }

    private static function getSender() {

        $address = [
            ['host' => 'sisfomedika.com',
                'username' => 'agent@sisfomedika.com',
                'password' => 'CFzcPi;8I4f7'],
            ['host' => 'gen.belongto.my.id',
                'username' => 'aspak@gen.belongto.my.id',
                'password' => 'AspakSenderEmail'],
            ['host' => 'smtp.gmail.com',
                'username' => 'testingemailku2@gmail.com',
                'password' => '#C0b4t35t']
        ];

        $all = count($address) - 1;
        $i = rand(0, $all);
        return $address[$i];
    }

}
