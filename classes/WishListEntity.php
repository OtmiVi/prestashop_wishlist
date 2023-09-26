<?php

class WishListEntity extends ObjectModel
{

    public $id;

    public $id_product;

    public $id_customer;

    public $id_product_attribute;

    public static $definition = [
        'table' => 'wishlist',
        'primary' => 'id_wishlist',
        'fields' => [
            'id_product' => ['type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => true],
            'id_product_attribute' => ['type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => true],
            'id_customer' => ['type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => true],
        ],
    ];

    public static function getProductIdsList()
    {
        $context = Context::getContext();
        $customerId = $context->customer->id;
        $sql = new DbQuery();
        $sql->select('id_product, id_product_attribute');
        $sql->from('wishlist', 'w');
        $sql->where('w.id_customer = ' . $customerId);
        $list = Db::getInstance()->executes($sql);
        return $list;
    }

    public static function getProductFromWishlist($id_customer, $id_product, $id_product_attribute)
    {
        $sql = new DbQuery();
        $sql->select('id_wishlist');
        $sql->from('wishlist', 'w');
        $sql->where('w.id_product = ' . $id_product);
        $sql->where('w.id_product_attribute = ' . $id_product_attribute);
        $sql->where('w.id_customer = ' . $id_customer);
        $sql = Db::getInstance()->getRow($sql);

        return $sql;
    }
}
