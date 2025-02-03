<?php 

namespace app\factory;

interface NotificationInterface {
    public function send($message) : bool;
}