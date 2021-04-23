<?php 
    session_start();
    $connexion=mysqli_connect('mi-mariadb.univ-tlse2.fr','dahbia.berrani-eps-h','Akbou_2021');
    if (!$connexion){
        echo ("désolé,connexion au serveur impossible\n");
        exit;
    }

    //selection de la base donnees

    if (!mysqli_select_db($connexion,'20_L2M_dahbia_berrani_eps_haddad')) {
        echo("Désolé, accès à la base  impossible\n");
        exit;
    }

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
                    $_SESSION['user'] = $_POST['email'];
                   // header('Location: landing.php');
                   
                    exit();
                }else{ 
                    echo"mots de passe incorect";
                    
                 }
          
        }else{
            echo"compte ne exite pas ";
         }
    }
