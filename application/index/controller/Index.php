<?php
namespace app\index\controller;
class Product{
    public $db;
    public function __construct(){
        $this->db=self::getDB();
    }
    public static function getDB() {
        $dsn = "sqlite:./Product.db";
        $pdo = new \PDO($dsn);
        return $pdo;
    }

    public function createProductTable() {
        $createTableSql = <<<EOF
        create table product(
            id int primary key not null,
            `name` varchar(100) not null,
            description varchar(200) not null
        );
EOF;
        $this->db->exec($createTableSql);
    }

    public function getProducts() {
        $result = $this->db->query('select * from product');
        if(is_object($result)){
            return $result->fetchAll();
        }else{
            $arr=array(
                ["id"=>"0","name"=>"Coca Cola X3D Model","description"=>"This is the X3D model of Coca Cola,to X3D for display online."],
                ["id"=>"1","name"=>"Sprite X3D Model","description"=>"This is the X3D model of Sprite bottle,to X3D for display online. "],
                ["id"=>"2","name"=>"Fenta X3D Model","description"=>"This is the X3D model of Fenta,to X3D for display online."],
            );
            return $arr;
        }

    }
    public function initProduct(){
        $arr=array(
            ["name"=>"Coca Cola X3D Model","description"=>"This is the X3D model of Coca Cola,to X3D for display online."],
            ["name"=>"Sprite X3D Model","description"=>"This is the X3D model of Sprite bottle,to X3D for display online. "],
            ["name"=>"Fenta X3D Model","description"=>"This is the X3D model of Fenta,to X3D for display online."],
        );
        foreach($arr as $key=>$item){
            $id=$key+1;
            $sql=<<<EOF
insert into product values ({$key},"{$item['name']}","{$item["description"]}");
EOF;
            dump($sql);
            $this->db->exec($sql);
        }
    }
}

class Index
{
    public function index()
    {
        if(isset($_GET["type"])&&$_GET["type"]=="model"){
            $p=new Product();
            $products=$p->getProducts();
            $product=$products[0];
            if(isset($_GET['cat'])){
                switch($_GET['cat']){
                    case "sprite":
                        $product=$products[1];
                        break;
                    case "fenta":
                        $product=$products[2];
                        break;
                }
            }
            return view("model",["product"=>$product]);
        }else{
            return view("index");
        }
    }
}
