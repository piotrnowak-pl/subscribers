<?php 

namespace App\Factory;

interface NotificationInterface {
    public function send($message) : bool;
}