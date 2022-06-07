<?php

trait ProductTrait{

    public function getProduct(){
        echo 'プロダクト';
    }
}

trait NewsTrait{

    public function getNews(){
        echo 'ニュース';
    }
}

class Product{

    use ProductTrait;
    use NewsTrait;

    public function getInformation(){
        echo 'クラスです';
    }
}

$instance = new Product;

$instance->getInformation();
echo '<br>';
$instance->getProduct();
echo '<br>';
$instance->getNews();
echo '<br>';

