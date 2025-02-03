# subscribers
Przykład kompozycji aplikacji w PHP z użyciem wzorców fabryki, obserwatora i adaptera

## Instalacja
Utworzenie bazy danych MySQL

### Baza danych
CREATE TABLE `osoby` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imie` varchar(20) NOT NULL,
  `nazwisko` varchar(60) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefon` varchar(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


### Instalacja pakietów
composer install


