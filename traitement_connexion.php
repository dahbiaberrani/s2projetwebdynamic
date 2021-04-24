<?php 
    include_once("./libDataBase.php");
    $connexion =  my_connect();

    if(!empty($_POST['email']) && !empty($_POST['password']))
    {
        $email = htmlspecialchars($_POST['email']);
        $passworde = htmlspecialchars($_POST['password']);
        $requette = "SELECT   password FROM Utilisateurs WHERE email = \"".$email."\"";
        $resultat = mysqli_query($connexion,$requette);
        $user = mysqli_fetch_object ($resultat);


        if($resultat == 1)
        {
            require("./password.php");
                if(password_verify($passworde,$user->password ))
                {
                    session_start();
                    $_SESSION['user'] = $_POST['email'];
                    header('Location: ./index.php');
                   
                    exit();
                }else{ 
                    header('Location: ./connexion.php?error=pass_word');                    
                 }
          
        }else{
            echo"le compte n'exite pas ";
         }
    }
