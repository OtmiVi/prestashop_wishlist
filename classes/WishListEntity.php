<?php

class WishListEntity extends ObjectModel
{

    public $id;

    public $id_product;

    public $id_customer;

    public static $definition = [
        'table' => 'wishlist',
        'primary' => 'id_wishlist',
        'fields' => [
            'id_product' => ['type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => true],
            'id_customer' => ['type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => true],
        ],
    ];
}
