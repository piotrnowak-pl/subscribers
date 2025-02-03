<?php
namespace App\Tests;

use App\Db\DatabaseAdapter;
use App\Repository\PersonRepository;
use PHPUnit\Framework\TestCase;

class SubscriptionRepositoryTest extends TestCase {
    private $dbAdapter;
    private $personRepository;
    private $subscriptionRepository;

    protected function setUp(): void {
        
        $dbConfig = require 'config/db.php';
        $dbConfig['dbname'] = $dbConfig['dbname'].'_test';

        $subscribers_data_file = 'data/test_subscriptions.data';
        $this->dbAdapter = new DatabaseAdapter($dbConfig);
        $this->personRepository = new PersonRepository($this->dbAdapter);
        $this->subscriptionRepository = new \App\Repository\SubscriptionRepository($subscribers_data_file);

        // Przygotowanie 
        $this->dbAdapter->query("DELETE FROM osoby");
        unlink($subscribers_data_file);       

    }

    // Włączenie użytkownikowi subskrypcji typu SMS
    public function testAddSmsSubscription() {
        // Dodaj użytkownika
        $person_id = $this->personRepository->add('Jan', 'Kowalski', 'jan@example.com', '123456789');
        
        // Dodaj subskrypcję SMS
        $this->subscriptionRepository->set($person_id, 'sms');
        
        // Sprawdzenie subskrypcji i czy została dodana
        $subscriptions = $this->subscriptionRepository->getAll();
        $this->assertCount(1, $subscriptions);

        // Sprawdzenie czy subskrypcja została dodana dla użytkownika        
        $this->assertEquals(true, $subscriptions[$person_id]);

        // Sprawdzenie czy subskrypcja jest typu SMS
        $this->assertEquals('sms', $subscriptions[$person_id]);
    }
}