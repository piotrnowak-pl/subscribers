<?php

session_start();

require_once 'vendor/autoload.php';
require_once 'app/helper/Global.php';

use app\db\DatabaseAdapter;
use app\factory\NotificationFactory;
use app\observer\NotificationObserver;
use app\repository\PersonRepository;
use app\repository\SubscriptionRepository;
use app\App;

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