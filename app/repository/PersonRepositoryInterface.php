<?php

namespace app\repository;


interface PersonRepositoryInterface {
    public function getAll() : array;
    public function getById($id) : array;
    public function add($imie, $nazwisko, $email, $telefon) : int;
    public function update($id, $imie, $nazwisko, $email, $telefon) : int;
    public function delete($id) : bool;
}
