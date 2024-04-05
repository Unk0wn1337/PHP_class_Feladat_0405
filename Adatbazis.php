<?php
    class Adatbazis {
        private $host = "localhost";
        private $felhasznalonev = "root";
        private $jelszo = "";
        private $adatbazisNeve = "magyarkartya";
        private $kapcsolat;
        public function __construct()
        {
            $this->kapcsolat = new mysqli(
                $this->host,
                $this->felhasznalonev,
                $this->jelszo,
                $this->adatbazisNeve
            );
        if ($this->kapcsolat->connect_errno){
            $siker = "Nem sikerült a kapcsolat";
        } else {
            $siker = "Sikerült a kapcsolat";      
            echo $siker;
               }
        }
        public function adatLeker($oszlop, $tabla){
            $sql = "SELECT $oszlop FROM $tabla";
            return $this-> kapcsolat->query($sql);
        }
        public function megjelenit($matrix){
            while($sor = $matrix->fetch_row()){
                echo "<img src=\"forras/$sor[0]\"alt=\"forras/$sor[0]\">";
            }
        }   

        public function rekordokSzama($tabla){
            $sql = "SELECT * FROM $tabla";
            return $this-> kapcsolat ->query($sql)->num_rows;
        }
        public function kartyaFeltolt(){
            $szinOsszeg = $this-> rekordokSzama("szin") + 1;
            $formaOsszeg = $this-> rekordokSzama("szin") + 1;
            for($szinIndex = 1; $szinIndex < $szinOsszeg; $szinIndex++){
                for($formaIndex = 1; $formaIndex < $formaOsszeg; $formaIndex++){
                    $sql = "INSERT INTO kartya(szinAzon, formaAzon) 
                    VALUES ('$szinIndex','$formaIndex')";
                    $this->kapcsolat->query($sql);
                }
            }
        }

        public function kapcsolatBezar(){
            $this->kapcsolat->close();
            
        } 
    }
?>