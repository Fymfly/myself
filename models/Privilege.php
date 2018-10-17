<?php
namespace models;

class Privilege extends Model{

    public function index() {

        $stmt = self::$pdo->prepare("SELECT * FROM privilege");
        $stmt->execute();
        $data = $stmt->fetchAll( \PDO::FETCH_ASSOC );

        return $data;
    }
}