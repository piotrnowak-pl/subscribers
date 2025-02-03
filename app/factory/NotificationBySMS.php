<?php
namespace app\factory;

class NotificationBySMS implements NotificationInterface {
    public function send($message) :bool {
        // Symulacja wysyłki SMS
        return true;
    }
}
