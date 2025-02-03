<?php
namespace App\Repository;

interface SubscriptionRepositoryInterface {
    public function getAll() : array;
    public function set($personId, $type) : bool;
    public function delete($personId) : bool;
}