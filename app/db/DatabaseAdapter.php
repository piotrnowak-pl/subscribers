<?php
namespace App\Db;

use PDO;
use PDOException;

class DatabaseAdapter {

    // Połączenie z bazą danychs
    /** @var PDO */
    private $connection;


    // Konstruktor
    public function __construct($config) {
        $dsn = "mysql:host={$config['ip']};port={$config['port']};dbname={$config['dbname']}";
        try {
            $this->connection = new PDO($dsn, $config['username'], $config['password']);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Błąd połączenia z bazą danych: " . $e->getMessage());
        }
    }


    // Wykonanie zapytania
    public function query($sql, $params = []) {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    // Pobranie wszystkich rekordów
    public function fetchAll($sql, $params = []) {
        return $this->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }


    // Pobranie jednego rekordu
    public function fetchOne($sql, $params = []) {
        return $this->query($sql, $params)->fetch(PDO::FETCH_ASSOC);
    }


    //  Pobranie ostatniego ID
    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }

    // Pobranie liczby rekordów z ostatniego zapytania UPDATE, DELETE, INSERT, zwraca ilość zmienionych rekordów
    public function rowCount() {
        $result = $this->connection->query("SELECT ROW_COUNT()");
        return $result->fetchColumn();
    }
}