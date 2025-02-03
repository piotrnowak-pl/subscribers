<?php
namespace App\Factory;

class NotificationFactory {

    // Tworzenie obiektu powiadomienia
    public function create(int $person_id, string $type) {
        if ($type === 'email') {
            return new NotificationByEmail();
        } elseif ($type === 'sms') {
            return new NotificationBySMS();
        }
        throw new \Exception("Nieznany typ powiadomienia");
    }

    // Pobieranie dostępnych typów powiadomień
    public function getTypes() {
        return NotificationType::getTypes();
    }
}