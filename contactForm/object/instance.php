<?php

class Product{
    
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

$addtext = '追加テキスト';
$instance->addProduct($addtext);
echo '<br>';

$static = '静的インスタンスからの呼び出し';
Product::getStaticProduct($static);