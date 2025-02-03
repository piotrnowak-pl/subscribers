<?php
namespace app\observer;


// Klasa obserwatora powiadomień
class NotificationObserver {
    private $subscribers = [];

    // Dodawanie subskrybenta
    public function attach($subscriber) {
        $this->subscribers[] = $subscriber;
    }

    // Wysyłanie powiadomienia do wszystkich subskrybentów
    public function notify($message) {
        $sent = 0;
        foreach ($this->subscribers as $subscriber) {
            if($subscriber->send($message)){
                $sent++;
            }
        }

        return $sent;
    }
}