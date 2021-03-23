<?php
include_once './Class/Conecta.php';
$conn = new Conecta();
$existe = false;
if(isset($_POST['cpf'])){
    if($conn->consultarUsersPorCPF($_POST['cpf'])){
        $existe = true;
    }
}else if(isset($_POST['cnpj'])){
    if($conn->consultarUsersPorCNPJ($_POST['cnpj'])){
        $existe = true;
    }
}else if(isset($_POST['email'])){
    if($conn->consultarUsersPorCNPJ($_POST['cnpj'])){
        $existe = true;
    }
}
if($existe){
    //Existe um registro com este cpf no banco
    echo "1";
}else{
    //Um novo registro
    echo "0";
}
?>