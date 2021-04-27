<?php 
    session_start();
    include_once("./libDataBase.php");
    $connexion =  my_connect();

    if(!empty($_POST['email']) && !empty($_POST['password']))
    {
        $email = htmlspecialchars($_POST['email']);
        $passworde = htmlspecialchars($_POST['password']);
        $requette = "SELECT  pseudo, password FROM Utilisateurs WHERE email = \"".$email."\"";
        $resultat = mysqli_query($connexion,$requette);
        


        if($resultat == 1)
        {
            if(mysqli_num_rows($resultat) == 0){
                header('Location: ./connexion.php?error=account_not_found');
                exit();
            }
            else{
                $user = mysqli_fetch_object ($resultat);
                require("./password.php");
                if(password_verify($passworde,$user->password ))
                {                  
                    $_SESSION["user"] = $user->pseudo;
                    header('Location: ./index.php');                 
                    exit();
                }
                else{ 
                    header('Location: ./connexion.php?error=pass_word');
                    exit();                    
                }
            }   
        }else{
            echo "<p>Erreur dans l'exécution de la requette</p>";
            echo"message de mysqli:".mysqli_error($connexion);
            exit();  
         }
    }
