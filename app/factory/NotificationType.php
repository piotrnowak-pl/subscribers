<?php
namespace app\factory;

class NotificationType {
    const SMS = 'sms';
    const EMAIL = 'email';
    

    // Pobieranie dostępnych typów powiadomień
    public static function getTypes() {
        return [
            self::SMS => self::SMS,
            self::EMAIL => self::EMAIL
        ];
    }
}