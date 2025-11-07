<?php

class Database {

    private $server;
    private $user;
    private $password;
    private $database;
    private $port;

    private $connection;

    public function __construct() {
        $dataList = $this -> connectionData();
        foreach ($dataList as $key => $value) {
            $this -> server = $value['server'];
            $this -> user = $value['user'];
            $this -> password = $value['password'];
            $this -> database = $value['database'];
            $this -> port = $value['port'];
        }

        $dsn = "pgsql:host={$this -> server};port={$this -> port};dbname={$this -> database}";
        try {
            $this -> connection = new PDO($dsn, $this -> user, $this -> password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);
        } catch (PDOException $e) {
            echo "Something went wrong: (" . $e->getCode() . ") " . $e->getMessage();
            die();
        }
    }

    private function connectionData() {
        $path = dirname(__FILE__);
        $jsonData = file_get_contents($path . "/Config");
        return json_decode($jsonData, true);
    }

    private function convertUTF8($array) {
        array_walk_recursive($array, function(&$item, $key) {
            if(!mb_detect_encoding($item, 'utf-8', true)) {
                $item = utf8_encode($item);
            }
        });
        return $array;
    }

    public function retrieveData($sqlStr) {
        $results = $this -> connection -> query($sqlStr);
        $resultArray = array();
        foreach ($results as $key) {
            $resultArray[] = $key;
        }
        return $this -> convertUTF8($resultArray);
    }

    public function nonQuery($sqlStr) {
        $affected = $this -> connection -> exec($sqlStr);
        return ($affected === false) ? 0 : $affected;
    }

    public function nonQueryId($sqlStr) {
        $affected = $this -> connection -> exec($sqlStr);
        $rows = ($affected === false) ? 0 : $affected;
        if ($rows >= 1) {
            return $this -> connection -> lastInsertId();
        } else {
            return 0;
        }
    }





}

