<?php
/**
 * Created by Digital-Solution web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */
namespace modules\user\models;

use framework\components\user\DbUser;
use framework\components\user\UserInterface;
use framework\core\Application;

class User extends DbUser implements UserInterface
{
    public $captcha = '';
    public $currentPassword = '';
    public $newPassword = '';
    public $repeatNewPassword = '';

    const SCENARIO_REGISTER = 'register';
    const SCENARIO_MANAGER = 'manager';
    const SCENARIO_EDIT_PROFILE = 'profile';
    const SCENARIO_UPLOAD_PHOTO = 'photo';
    const SCENARIO_CHANGE_PASSWORD = 'change_password';

    public function attributeLabels()
    {
        return array_merge(
            [
                'username' => 'Имя пользователя',
                'password' => 'Пароль',
                'currentPassword' => 'Текущий пароль',
                'newPassword' => 'Новый пароль',
                'repeatNewPassword' => 'Повторите новый пароль',
                'email' => 'E-Mail',
                'name' => 'Имя',
                'status' => 'Статус',
                'last_visit' => 'Последняя активность',
                'created_at' => 'Аккаунт создан',
                'captcha' => 'Код с картинки',
            ],
            parent::attributeLabels()); // TODO: Change the autogenerated stub
    }

    public function getShortName()
    {
        if(isset($this->_attributes['name']))
            return $this->_attributes['name'];
        else
            return '_Unknown';
    }


    public function rules()
    {
        return [
            [$this->getFields(), 'safe', ['on' => [self::SCENARIO_SYSTEM, self::SCENARIO_MANAGER]]],
            ['captcha', 'captcha', ['on' => self::SCENARIO_REGISTER]],
            ['username', 'length', ['range' => [4, 15], 'on' => self::SCENARIO_REGISTER]],

            ['currentPassword', 'passwordCheck', ['on' => [self::SCENARIO_CHANGE_PASSWORD]]],
            ['newPassword', 'length', ['range' => [6, 20],  'on' => [self::SCENARIO_CHANGE_PASSWORD]]],
            ['newPassword', 'repeat', ['repeat' => 'repeatNewPassword', 'on' => [self::SCENARIO_CHANGE_PASSWORD]]],
            ['password', 'length', ['range' => [6, 20],  'on' => [self::SCENARIO_REGISTER, self::SCENARIO_CHANGE_PASSWORD]]],

            ['email', 'email', ['on' => [self::SCENARIO_REGISTER, self::SCENARIO_EDIT_PROFILE]]],
            ['name', 'required', ['on' => [self::SCENARIO_REGISTER, self::SCENARIO_EDIT_PROFILE]]],
            ['username', 'unique', ['targetClass' => static::class, 'targetField' => 'username', 'on' => [self::SCENARIO_REGISTER, self::SCENARIO_SYSTEM, self::SCENARIO_MANAGER]]],
            ['email', 'unique', ['targetClass' => static::class, 'targetField' => 'email', 'on' => [self::SCENARIO_REGISTER, self::SCENARIO_EDIT_PROFILE]]],
            [$this->getFields(), 'safe', ['on' => static::SCENARIO_SYSTEM]]
        ];
    }

    public function passwordCheckValidator($value)
    {
        if($this->password == $this->hash($value))
            return $value;
        else
            return false;
    }

    // После валидации
    public function afterValidate($fields)
    {
        if(!empty($fields['newPassword'])) // Поле нового пароля прошло валидацию
            $fields['password'] = $fields['newPassword'];

        return $fields;
    }


    // Перед сохранением
    public function beforeSave($updateFields)
    {
        if($this->isNewRecord)
        {
            $updateFields['created_at'] = date('Y-m-d H:i:s');
        }

        return parent::beforeSave($updateFields); // TODO: Change the autogenerated stub
    }
}