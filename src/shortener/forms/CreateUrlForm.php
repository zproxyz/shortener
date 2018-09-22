<?php

namespace shortener\forms;

use yii\base\Model;

class CreateUrlForm extends Model
{
    public $url;
    public $expiration;


    public function rules()
    {
        return [
            [['url'], 'required'],
            [['expiration'], 'safe'],
            [['url'], 'string', 'max' => 255],
            ['url', 'trim'],
        ];
    }
}
