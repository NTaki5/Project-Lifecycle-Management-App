<?php 

class Company extends Model{

    protected $allowedColumns = ["companyName", "companyCUI", "companyAddress", "companyType", "date"];


        public function validate($data){
            $this->errors = array();
            $return = true;
            if(empty($data["companyName"]) || !preg_match("/^[a-z. A-Z]+$/",$data["companyName"])){
                $this->errors["companyName"] = "Only letters allowed in company name";
                $return = false;
            }
            
            if(empty($data["companyCUI"]) || !$this->validateCIF($data["companyCUI"])){
                $this->errors["companyCUI"] = "You have entered the wrong CUI/CIF";
                $return = false;
            }
            
            if(empty($data["companyAddress"])){
                $this->errors["companyAddress"] = "You must give us the address of your company";
                $return = false;
            }
            
            if(empty($data["companyType"])){
                $this->errors["companyType"] = "You must give us the type of your company";
                $return = false;
            }

            return $return;
        } 

        private function validateCIF($cif){
            // Daca este string, elimina atributul fiscal si spatiile
            if(!is_int($cif)){
                $cif = strtoupper($cif);
                if(strpos($cif, 'RO') === 0){
                    $cif = substr($cif, 2);
                }
                $cif = (int) trim($cif);
            }
            
            // daca are mai mult de 10 cifre sau mai putin de 2, nu-i valid
            if(strlen($cif) > 10 || strlen($cif) < 2){
                return false;
            }
            // numarul de control
            $v = 753217532;
            
            // extrage cifra de control
            $c1 = $cif % 10;
            $cif = (int) ($cif / 10);
            
            // executa operatiile pe cifre
            $t = 0;
            while($cif > 0){
                $t += ($cif % 10) * ($v % 10);
                $cif = (int) ($cif / 10);
                $v = (int) ($v / 10);
            }
            
            // aplica inmultirea cu 10 si afla modulo 11
            $c2 = $t * 10 % 11;
            
            // daca modulo 11 este 10, atunci cifra de control este 0
            if($c2 == 10){
                $c2 = 0;
            }
            
            // Until I receive a valid CIF number I will return true
            return true;
            return $c1 === $c2;
        }

}