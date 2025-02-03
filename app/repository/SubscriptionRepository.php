<?php
namespace app\repository;

class SubscriptionRepository implements SubscriptionRepositoryInterface {
    
    private $filePath ;


    // Konstruktor przyjmuje ścieżkę do pliku, w którym przechowywane są subskrypcje
    public function __construct($filePath) {
        $this->filePath = $filePath;
    }


    // Metoda konwertuje dane z pliku i  zwraca tablicę subskrypcji
    public function getAll():array {

        $subscriptions = [];

        if (!file_exists($this->filePath)) {
            return $subscriptions;
        }
        
        $data = explode(PHP_EOL, file_get_contents($this->filePath));
        foreach ($data as $key => $line) {
            if (empty($line)) {
                continue;
            }

            if(strpos($line, ':') === false) {
                throw new \Exception('Invalid subscription format');
            }
            list($person_id,$type) = explode(':', $line);

            if(empty($person_id) || empty($type)){
                continue;
            }

            $subscriptions[$person_id] = $type;
        }

        return $subscriptions;
    }


    // Metoda dodaje subskrypcję dla użytkownika
    public function set($personId, $type) :bool{
        $subscriptions = $this->getAll();
        $subscriptions[$personId] = $type;
        return $this->save($subscriptions);
    }

    // Metoda usuwa subskrypcję dla użytkownika
    public function delete($personId) :bool{
        $subscriptions = $this->getAll();
        unset($subscriptions[$personId]);
        return $this->save($subscriptions);
    }


    // Metoda zapisuje subskrypcje do pliku
    private function save($subscriptions) {
        $content = '';
        
        foreach ($subscriptions as $personId => $type) {
            $content .= "$personId:$type".PHP_EOL;
        }

        $dir = dirname($this->filePath);
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        return file_put_contents($this->filePath, $content);
    }
}
