<?php
namespace app;

use app\factory\NotificationFactory;
use app\observer\NotificationObserver;
use app\repository\PersonRepositoryInterface;
use app\repository\SubscriptionRepositoryInterface;
use InvalidArgumentException;


// Klasa App odpowiada za obsługę żądań HTTP, przetwarzanie danych i wyświetlanie widoku.
class App {
    private $personRepository;
    private $subscriptionRepository;
    private $notificationFactory;
    private $notificationObserver;

    // Konstruktor klasy App
    public function __construct(
        PersonRepositoryInterface $personRepository,
        SubscriptionRepositoryInterface $subscriptionRepository,
        NotificationFactory $notificationFactory,
        NotificationObserver $notificationObserver
    ) {
        $this->personRepository = $personRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->notificationFactory = $notificationFactory;
        $this->notificationObserver = $notificationObserver;
    }

    // Metoda run() obsługuje żądania HTTP, główna metoda klasy App
    public function run() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->handlePostRequest();
        } 

        if(isset($_GET['action']) && $_GET['action'] === 'edit'){
            return $this->handleEditRequest();
        }
        
        return $this->renderView();
        
    }



    // Metoda handlePostRequest() obsługuje żądania POST
    private function handlePostRequest() {
        $action = $_POST['action'] ?? '';
        $id = $_POST['id'] ?? null;
        $imie = $_POST['imie'] ?? '';
        $nazwisko = $_POST['nazwisko'] ?? '';
        $email = $_POST['email'] ?? '';
        $telefon = $_POST['telefon'] ?? '';
     


        // Dodawanie, edycja i usuwanie osoby
        try{
            if ($action === 'add') {
                $this->personRepository->add($imie, $nazwisko, $email, $telefon);
            } elseif ($action === 'edit' && $id) {
                $this->personRepository->update($id, $imie, $nazwisko, $email, $telefon);
            } elseif ($action === 'delete' && $id) {
                if($this->personRepository->delete($id)){
                    $this->subscriptionRepository->delete($id);
                }
            }

            // Usunięcie błędu i danych z formularza
            unset($_SESSION['error']);
            unset($_SESSION['post']);

        }catch(InvalidArgumentException $e){
           
            if($action === 'add'){
                $_SESSION['post'] = $_POST;
            }
            
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        }
        

        // Ustawienie subskrypcji
        if($action === 'subscribe'){
            $personId = $_POST['personId'] ?? null;
            $type = $_POST['type'] ?? '';
            
            if(!$personId){
                echo json_encode(['status' => 'error', 'message' => 'Brak id osoby']);
                exit();
            }

            if(empty($type)){
                $result = $this->subscriptionRepository->delete($personId);
            }else{
                $result = $this->subscriptionRepository->set($personId, $type);
            }
            
            echo json_encode(['status' => 'ok', 'result' => $result]);
            exit();
        }


        
        // Wysyłanie powiadomień
        if (isset($_POST['send_notification'])) {

            $message = $_POST['message'] ?? '';
            if(empty($message)){
                $_SESSION['error']['message'] = "<b>Wiadomość</b> nie może być pusta.";
                header("Location: " . $_SERVER['REQUEST_URI']);
                exit();
            }

            $this->sendNotifications($message);
        }
        

        header("Location: index.php");
        exit();
    }



    // Metoda handleEditRequest() obsługuje żądania edycji
    private function handleEditRequest() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $person = $this->personRepository->getById($id);
            if ($person) {
                include 'app/views/edit.php';
                return;
            }
        }
        header("Location: index.php");
        exit();
    }


    // Metoda sendNotifications() wysyła powiadomienia do wszystkich subskrybentów
    private function sendNotifications($message) {
        $subscriptions = $this->subscriptionRepository->getAll();

        foreach ($subscriptions as $person_id => $type) {
            $notification = $this->notificationFactory->create($person_id, $type);
            $this->notificationObserver->attach($notification);
        }
        
        $sent = $this->notificationObserver->notify($message);
        if($sent === 0){
            $_SESSION['error']['message'] = 'Brak subskrypcji do powiadomień. Wybierz subskrypcje dla osób, do których chcesz wysłać powiadomienie.';
        }elseif($sent > 0){
            if($sent == 1){
                $_SESSION['success'] = 'Wysłano powiadomienia do <b>jednej</b> osoby';
            }else{
                $_SESSION['success'] = 'Wysłano powiadomienia do <b>' . $sent . '</b> osób';
            }
            
        }
        

        // Sprawdzenie, czy udało się wysłać powiadomienia do wszystkich osób z subskrypcją
        if($sent < count($subscriptions)){
            $_SESSION['error']['message'] = 'Nie udało się wysłać powiadomień do wszystkich osób!';
        }
    }


    // Metoda renderView() renderuje widok
    private function renderView() {
        $people = $this->personRepository->getAll();
        $subscriptions = $this->subscriptionRepository->getAll();

        $notificationTypes = $this->notificationFactory->getTypes();
        include 'app/views/index.php';
        
        unset($_SESSION['post']);        
        unset($_SESSION['error']);
        unset($_SESSION['success']);
    }

}