<?php
session_start();
require_once 'vendor/autoload.php';
require_once 'app/helper/Global.php';

use App\Db\DatabaseAdapter;
use App\Factory\NotificationFactory;
use App\Observer\NotificationObserver;
use App\Repository\PersonRepository;
use App\Repository\SubscriptionRepository;
use App\App;

// Konfiguracja połączenia z bazą danych

$dbConfig = require 'config/db.php';

// Inicjalizacja adaptera bazy danych
$dbAdapter = new DatabaseAdapter($dbConfig);


// Inicjalizacja repozytoriów
$personRepository = new PersonRepository($dbAdapter);
$subscriptionRepository = new SubscriptionRepository('data/subscriptions.data');

// Inicjalizacja fabryki powiadomień
$notificationFactory = new NotificationFactory();

// Inicjalizacja obserwatora powiadomień
$notificationObserver = new NotificationObserver();

// Inicjalizacja aplikacji
$app = new App(
    $personRepository,
    $subscriptionRepository,
    $notificationFactory,
    $notificationObserver
);

// Uruchomienie aplikacji
$app->run();