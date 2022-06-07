<?php

// 親クラス
abstract class ProductAbstract{
    public function echoProduct(){
        echo '親クラスです';
    }

    abstract public function getProduct();
}


class Product extends ProductAbstract{
    private $product = [];

    function __construct($product){
        $this->product = $product;
    }

    public function getProduct(){
        echo $this->product;
    }

    public function addProduct($item){
        $this->product .= $item;
        echo $this->product;
    }

    public static function getStaticProduct($str){
        echo $str;
    }
}

$instance = new Product('初期テキスト');

echo '<pre>';
var_dump($instance);
echo '</pre>';

$instance->getProduct();
echo '<br>';

$instance->echoProduct();
echo '<br>';

$addtext = '追加テキスト';
$instance->addProduct($addtext);
echo '<br>';

// 静的インスタンスの呼び出し、インスタンス化なしに　クラス名::メソッド名
$static = '静的インスタンスからの呼び出し';
Product::getStaticProduct($static);

