<?php
    function chmod_r($path) {
        $dir = new DirectoryIterator($path);
        foreach ($dir as $item) {
            chmod($item->getPathname(), 0777);
            if ($item->isDir() && !$item->isDot()) {
                chmod_r($item->getPathname());
            }
        }
    }
    
    
    

   $src = "/opt/CRIE/louna.hamnich/public_html";
   //$src = "/opt/CRIE/dahbia.berrani-eps-h/public_html/";
    $dst = "/copie";

    function recurse_copy($src,$dst) { 
        $dir = opendir($src); 
        //echo "/opt/CRIE/dahbia.berrani-eps-h/public_html/".$dst."<br>";
        //echo "creation répértoire".mkdir("/opt/CRIE/dahbia.berrani-eps-h/public_html/".$dst)."<br>"; 
        while(false !== ( $file = readdir($dir)) ) { 
            if (( $file != '.' ) && ( $file != '..' )) { 
                if ( is_dir($src . '/' . $file) ) { 
                    recurse_copy($src . '/' . $file,$dst . '/' . $file);  
                } 
                else { 
                    copy($src . '/' . $file,$dst . '/' . $file); 
                } 
            } 
        } 
        closedir($dir); 
    } 

   //recurse_copy($src,$dst);
   chmod("/opt/CRIE/dahbia.berrani-eps-h/public_html/s2projetwebdynamic/images", 0777);

    echo "<H3>Copy Paste completed!</H3>"; //output when done
    //chmod_r ("/opt/CRIE/dahbia.berrani-eps-h/public_html/copie", 0777);

?>