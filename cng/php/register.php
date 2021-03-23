<?php
if(isset($_POST['role'])){
    include_once './Class/Conecta.php';
    $conn = new Conecta();
    //Montar Array dados do User
    $data = new DateTime();
    $user = (object) [
        'email' => $_POST['email'],
        'pass' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'name' => $_POST['name'],
        'role' => $_POST['role'],
        'active' => 1,
        'first_login' => 0,
        'confirmed_email' => 0,
        'created' => $data->format('Y-m-d H:i:s'),
        'modified' => $data->format('Y-m-d H:i:s'),
        'english_level' => $_POST['english_level'],
        'purchasing_exp' => $_POST['purchasing_exp'],
        'acting_cat' => $_POST['acting_cat'],
        'bank_username' => $_POST['bank_username'],
        'bank_cpf' => $_POST['bank_cpf'],
        'bank_agency' => $_POST['bank_agency'],
        'bank_account' => $_POST['bank_account'],
        'bank_name' => $_POST['bank_name'],
        'corporate' => null,
        'birth_date' => null,
        'doc_cpf' => isset($_POST['doc_cpf']) == true ? $_POST['doc_cpf'] : null,
        'doc_rg' => null,
        'telephone' => null,
        'cellphone' => null,
        'address_zipcode' => null,
        'address_street' => null,
        'address_number' => null,
        'address_complement' => null,
        'address_city' => null,
        'address_uf' => null,
        'address_neighborhood' => null,
        'token' => null,
        'confirmed_cellphone' => null,
        'img_profile' => null,
        'doc_cnpj' => isset($_POST['doc_cnpj']) == true ? $_POST['doc_cnpj'] : null,
        'optout_email' => null
      ];
      //$data = json_encode($user);
      // echo '<pre>';
      // // echo var_dump($user);
      // // //echo $conn->inserirNovoUser($user);
      // echo var_dump($conn->inserirNovoUser($user));
      // echo '</pre>';
      if( $conn->inserirNovoUser($user) ){
        echo "<script>window.location.href='../obrigado.php'</script>";
      }else{
        echo "<script>window.location.href='../index.php?erro=1'</script>";
      }
}

?>