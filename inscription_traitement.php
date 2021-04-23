<?php 
    
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
    mysqli_set_charset($connexion, "utf8");
    if(!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_retype']))
    {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $email = htmlspecialchars($_POST['email']);
        $passworde = htmlspecialchars($_POST['password']);
        $password_retype = htmlspecialchars($_POST['password_retype']);

    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        if($passworde === $password_retype){

            require("password.php");
            $user = mysqli_fetch_object ($resultat);
            
            $mdp_hached = password_hash($passworde,PASSWORD_BCRYPT);

            
            $requette1="INSERT INTO `Utilisateurs`(`pseudo`, `email`, `password`) 
                            VALUES(\"".$pseudo."\", \"".$email."\", \"".$mdp_hached."\")";
            $resultat1 =  mysqli_query($connexion,$requette1);
            
            header('Location:inscription.php?reg_err=success');exit();
        }else{ header('Location: inscription.php?reg_err=password'); exit();}

    }
