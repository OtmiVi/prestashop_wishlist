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

    public static function getProductIdsList()
    {
        $context = Context::getContext();
        $customerId = $context->customer->id;
        $sql = new DbQuery();
        $sql->select('id_product');
        $sql->from('wishlist', 'w');
        $sql->where('w.id_customer = ' . $customerId);
        $sql = Db::getInstance()->executes($sql);
        $list = [];
        foreach ($sql as $item){
            $list[] =$item['id_product'];
        }
        return $list;
    }

    public static function getProductFromWishlist($id_product)
    {
        $context = Context::getContext();
        $customerId = $context->customer->id;

        $sql = new DbQuery();
        $sql->select('id_wishlist');
        $sql->from('wishlist', 'w');
        $sql->where('w.id_product = ' . $id_product);
        $sql->where('w.id_customer = ' . $customerId);
        $sql = Db::getInstance()->executes($sql);

        return $sql;
    }
}
