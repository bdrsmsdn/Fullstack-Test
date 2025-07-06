<?php

use Phalcon\Mvc\Model;
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\Uniqueness;

class Patients extends Model
{
    public $id;
    public $name;
    public $sex;
    public $religion;
    public $phone;
    public $address;
    public $nik;
    public $createdTime;
    public $updatedTime;

    public function initialize()
    {
        $this->setSource('patients');
    }

    public function columnMap(): array
    {
        return [
            'Id'           => 'id',
            'Name'         => 'name',
            'Sex'          => 'sex',
            'Religion'     => 'religion',
            'Phone'        => 'phone',
            'Address'      => 'address',
            'NIK'          => 'nik',
            'CreatedTime'  => 'createdTime',
            'UpdatedTime'  => 'updatedTime',
        ];
    }

    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'name',
            new PresenceOf([
                'message' => 'Name is required'
            ])
        );

        $validator->add(
            'sex',
            new PresenceOf([
                'message' => 'Sex is required'
            ])
        );

        $validator->add(
            'nik',
            new PresenceOf([
                'message' => 'NIK is required'
            ])
        );

        $validator->add(
            'nik',
            new Uniqueness([
                'message' => 'NIK must be unique'
            ])
        );

        return $this->validate($validator);
    }

    public function beforeCreate()
    {
        $this->createdTime = date('Y-m-d H:i:s');
        $this->updatedTime = date('Y-m-d H:i:s');
    }

    public function beforeUpdate()
    {
        $this->updatedTime = date('Y-m-d H:i:s');
    }
}