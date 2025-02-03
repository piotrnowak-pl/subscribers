<?php
namespace App\Factory;

class NotificationBySMS implements NotificationInterface {
    public function send($message) :bool {
        // Symulacja wysyłki SMS
        return true;
    }
}
