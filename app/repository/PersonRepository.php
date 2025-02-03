<?php
namespace App\Repository;

use App\Db\DatabaseAdapter;
use InvalidArgumentException;

class PersonRepository implements PersonRepositoryInterface {
    private $dbAdapter;

    // Konstruktor z wstrzyknięciem zależności / Adapter bazy danych
    public function __construct(DatabaseAdapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }


    // Pobranie wszystkich osób
    public function getAll() : array {
        return $this->dbAdapter->fetchAll("SELECT * FROM osoby");
    }

     
    // Pobranie danych osoby po id
    public function getById($id) : array{
        return $this->dbAdapter->fetchOne("SELECT * FROM osoby WHERE id = ?", [$id]);
    }


    // Dodawanie nowej osoby
    public function add($imie, $nazwisko, $email, $telefon) :int{
        $this->validatePersonData($imie, $nazwisko, $email, $telefon);
        $sql = "INSERT INTO osoby (imie, nazwisko, email, telefon) VALUES (?, ?, ?, ?)";
        $this->dbAdapter->query($sql, [$imie, $nazwisko, $email, $telefon]);
        
        return $this->dbAdapter->lastInsertId();
    }


    // Aktualizacja danych osoby
    public function update($id, $imie, $nazwisko, $email, $telefon) :int {
        $this->validatePersonData($imie, $nazwisko, $email, $telefon);
        $sql = "UPDATE osoby SET imie = ?, nazwisko = ?, email = ?, telefon = ? WHERE id = ?";
        $this->dbAdapter->query($sql, [$imie, $nazwisko, $email, $telefon, $id]);
        
        return $this->dbAdapter->rowCount();
    }


    // Usuwanie osoby
    public function delete($id) :bool {
        $sql = "DELETE FROM osoby WHERE id = ?";
        $this->dbAdapter->query($sql, [$id]);

        return $this->dbAdapter->rowCount() > 0;
    }


    /**
     * Walidacja danych osoby.
     *
     * @param string $imie
     * @param string $nazwisko
     * @param string $email
     * @param string $telefon
     * @throws InvalidArgumentException Jeśli dane są nieprawidłowe.
     */
    private function validatePersonData($imie, $nazwisko, $email, $telefon) {
        
        $_SESSION['error'] = [];
        // Walidacja imienia (max 20 znaków)
        if (empty($imie) || strlen($imie) > 20) {
            $_SESSION['error']['imie'] = "<b>Imię</b> jest wymagane i może mieć maksymalnie 20 znaków.";
        }

        // Walidacja nazwiska (max 60 znaków)
        if (empty($nazwisko) || strlen($nazwisko) > 60) {
            $_SESSION['error']['nazwisko'] = "<b>Nazwisko</b> jest wymagane i może mieć maksymalnie 60 znaków.";
        }

        // Walidacja emaila (format i max 100 znaków)
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
            $_SESSION['error']['email'] = "Nieprawidłowy format <b>email</b> lub przekroczono limit 100 znaków.";
        }

        // Walidacja telefonu (tylko cyfry, max 12 znaków)
        if (!preg_match('/^\d{1,12}$/', $telefon)) {
            $_SESSION['error']['telefon'] = "<b>Telefon</b> może zawierać tylko cyfry i mieć maksymalnie 12 znaków.";
        }

        if(!empty($_SESSION['error'])){
            throw new InvalidArgumentException(strip_tags( implode(PHP_EOL,$_SESSION['error'])));
        }

    }
}