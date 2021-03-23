<?php

include_once 'ConfigDatabase.php';

class Conecta extends ConfigDatabase{
 var $pdo;
 
 function __construct(){
    $this->pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->db, $this->usuario, $this->senha); 
 }
 
 
 function consultarUsersPorCPF($reference){
     $stmt = $this->pdo->prepare("SELECT * FROM users where doc_cpf = :reference");
     $stmt->bindValue(":reference",$reference);
     $run = $stmt->execute();
     return $stmt->fetch(PDO::FETCH_ASSOC);
 }

 function consultarUsersPorCNPJ($reference){
     $stmt = $this->pdo->prepare("SELECT * FROM users where doc_cnpj = :reference");
     $stmt->bindValue(":reference",$reference);
     $run = $stmt->execute();
     return $stmt->fetch(PDO::FETCH_ASSOC);
 }

 function inserirNovoUser($user){

    $sql = "INSERT INTO users (";
    $sql = $sql . "email, password, name, role, active, first_login, confirmed_email, created, modified,";
    $sql = $sql . "english_level, purchasing_exp, acting_cat, bank_username, bank_cpf, bank_agency,";
    $sql = $sql . "bank_account, bank_name, corporate, birth_date, doc_cpf, doc_rg, telephone, cellphone,";
    $sql = $sql . "address_zipcode, address_street, address_number, address_complement, address_city,";
    $sql = $sql . "address_uf, address_neighborhood, token, confirmed_cellphone, img_profile, doc_cnpj, optout_email)";
    $sql = $sql . "VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    
    $stmt =  $this->pdo->prepare($sql);

    $stmt->bindValue(1,$user->email);
    $stmt->bindValue(2,$user->pass);
    $stmt->bindValue(3,$user->name);
    $stmt->bindValue(4,$user->role);
    $stmt->bindValue(5,$user->active);
    $stmt->bindValue(6,$user->first_login);
    $stmt->bindValue(7,$user->confirmed_email);
    $stmt->bindValue(8,$user->created);
    $stmt->bindValue(9,$user->modified);
    $stmt->bindValue(10,$user->english_level);
    $stmt->bindValue(11,$user->purchasing_exp);
    $stmt->bindValue(12,$user->acting_cat);
    $stmt->bindValue(13,$user->bank_username);
    $stmt->bindValue(14,$user->bank_cpf);
    $stmt->bindValue(15,$user->bank_agency);
    $stmt->bindValue(16,$user->bank_account);
    $stmt->bindValue(17,$user->bank_name);
    $stmt->bindValue(18,$user->corporate);
    $stmt->bindValue(19,$user->birth_date);
    $stmt->bindValue(20,$user->doc_cpf);
    $stmt->bindValue(21,$user->doc_rg);
    $stmt->bindValue(22,$user->telephone);
    $stmt->bindValue(23,$user->cellphone);
    $stmt->bindValue(24,$user->address_zipcode);
    $stmt->bindValue(25,$user->address_street);
    $stmt->bindValue(26,$user->address_number);
    $stmt->bindValue(27,$user->address_complement);
    $stmt->bindValue(28,$user->address_city);
    $stmt->bindValue(29,$user->address_uf);
    $stmt->bindValue(30,$user->address_neighborhood);
    $stmt->bindValue(31,$user->token);
    $stmt->bindValue(32,$user->confirmed_cellphone);
    $stmt->bindValue(33,$user->img_profile);
    $stmt->bindValue(34,$user->doc_cnpj);
    $stmt->bindValue(35,$user->optout_email);

    if( $stmt->execute() ){
        return true;
    }else{
        return $stmt->errorInfo();
    }
 }
}
?>