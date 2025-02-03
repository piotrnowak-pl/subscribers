<?php
namespace App\Factory;


class NotificationByEmail implements NotificationInterface  {
    public function send($message) :bool {
        // Symulacja wysyłki email
        return true;
    }
}