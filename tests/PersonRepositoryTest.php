<?php
namespace app\tests;

use app\db\DatabaseAdapter;
use app\repository\PersonRepository;
use PHPUnit\Framework\TestCase;

class PersonRepositoryTest extends TestCase {
    private $dbAdapter;
    private $personRepository;

    protected function setUp(): void {
        
        $dbConfig = require 'config/db.php';
        $dbConfig['dbname'] = $dbConfig['dbname'].'_test';

        $this->dbAdapter = new DatabaseAdapter($dbConfig);
        $this->personRepository = new PersonRepository($this->dbAdapter);

        // Przygotowanie bazy danych (np. wyczyść tabelę przed testami)
        $this->dbAdapter->query("DELETE FROM osoby");

    }

    //  Sprawdzenie dodania użytkownika - poprawne
    public function testAddUserValid() {
        $this->personRepository->add('Jan', 'Kowalski', 'jan@example.com', '123456789');
        $users = $this->personRepository->getAll();

        $this->assertCount(1, $users);
        $this->assertEquals('Jan', $users[0]['imie']);
        $this->assertEquals('Kowalski', $users[0]['nazwisko']);
        $this->assertEquals('jan@example.com', $users[0]['email']);
        $this->assertEquals('123456789', $users[0]['telefon']);
    }

    // Sprawdzenie dodania użytkownika - bez adresu email
    public function testAddUserWithoutEmail() {
        $this->expectException(\InvalidArgumentException::class);
        $this->personRepository->add('Jan', 'Kowalski', '', '123456789');
    }

    // Sprawdzenie usunięcia użytkownika
    public function testDeleteUser() {
        // Dodaj użytkownika
        $this->personRepository->add('Jan', 'Kowalski', 'jan@example.com', '123456789');
        $users = $this->personRepository->getAll();
        $userId = $users[0]['id'];

        // Usuń użytkownika
        $this->personRepository->delete($userId);

        // Sprawdź, czy użytkownik został usunięty
        $usersAfterDelete = $this->personRepository->getAll();
        $this->assertCount(0, $usersAfterDelete);
    }

}
