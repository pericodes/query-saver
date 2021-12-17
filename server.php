<?php

$param = json_decode(file_get_contents('php://input'), true);

if(!$param || !isset($param["database"]) || !isset($param["query"])){
    echo file_get_contents('index.html');
}else{
    $databse = $param["database"];
    $query = $param["query"];
    $host = $databse['host'] ?? 'localhost';
    $port = $databse['port'] ?? '3306';
    $user = $databse['user'] ?? 'root';
    $pass = $databse['pass'] ?? '';
    $dbname = $databse['name'] ?? '';
    $dbh = new PDO("mysql:host=$host;port=$port".($dbname ? ";dbname=$dbname" : ''), $user, $pass);

    $stmt = $dbh->prepare($param["query"]);
    $stmt->execute();
    // fetch all rows into an array.
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($rows);

}

?>