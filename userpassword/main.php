<?php

    if(isset($_POST['username'], $_POST['password'])){

        //salvo l utente inserito
        $user = $_POST['username'];

        //salvo la password inserita
        $password = $_POST['password'];

        //queste sono le credenziali che servono per accedere (hardcoded)
        $user_valido = "admin";
        $password_valida = "12345";

        //verifica delle credenziali inserite
        if($user === $user_valido && $password === $password_valida){

            echo "<p>Accesso riuscito!</p>";
        }else{

            echo "<p>Credenziali errate!</p>";
        }
    }
?>