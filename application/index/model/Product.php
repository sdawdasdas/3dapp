<?php
namespace app\index\model;
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
        dump($result->fetchAll());
        return $result->fetchAll();
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