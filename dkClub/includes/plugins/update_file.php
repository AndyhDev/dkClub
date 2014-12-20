<?php
function plugin_update_file(){
    if(!$_SESSION["spezi"] == 1){
        return '<h1>Sie dürfen dieses Plugin nicht ausführen!</h1>';
    }
    if(isset($_GET['upload_file'])){
        if ($_FILES["file"]["error"] > 0){
            return "Leider ist beim Upload etwas schief gelaufen:<br/>" . $_FILES["file"]["error"] . "<br />";
        }else{
            $path = $_GET['upload_file'];
            $temp = $_FILES["file"]["tmp_name"];
            if(file_exists($path)){
                $new = file_get_contents($_FILES["file"]["tmp_name"]);
                $old = file_get_contents($path);
                
                $count = 0;
                while(true){
                    if(!file_exists($path . "_$count")){
                        break;
                    }
                    $count++;
                }
                file_put_contents($path . "_$count", $old);
                file_put_contents($path, $new);
                $empfaenger = "AH2@gmx.de";
                $absendername = "PHP";
                $absendermail = "webmaster@sev-kuernbach.de";
                $betreff = "Die Datei " . $path . ' wurde ersetzt';
                $text = "Die Datei " . $path . " wurde ersetzt.\nDie Name der alten Datei lautet: " . $path . "_$count";
                
                mail($empfaenger, $betreff, $text, "From: $absendername <$absendermail>");
                return 'Datei wurde ersetzt, es wurde eine E-Mail an der Webmaster versand';
            }else{
                return 'Die Datei existiert nicht';
            }
        }
    }elseif(isset($_GET['update_file'])){
        $path = $_GET['update_file'];
        $html = "<h3>PDF Dateien austauschen</h3><br/>
                 Bitte wählen sie die neue Datei als ersatzt für '$path' aus:<br/>
                 <form action='index.php?site=i_spezi&amp;upload_file=$path' method='post' enctype='multipart/form-data'>
                    <input type='file' name='file' id='file' /><br/>
                    <input type='submit' name='submit' value='ersetzten' />
                 </form>";
                 
        return $html;
    }else{
        $html = '<h3>PDF Dateien austauschen</h3><ul>';
        $paths = array('pdfs', 'intern/pdf');
        foreach($paths as $main_path){
            $files1 = scandir($main_path);
            foreach($files1 as $file){
                $path = $main_path . '/' . $file;
                if(pathinfo($path, PATHINFO_EXTENSION) == 'pdf'){
                    $html = $html ."<li><a href='index.php?site=i_spezi&amp;update_file=$path'>$path</a></li>";
                }
            }
        }
        $html = $html . '</ul>';
        return $html;
    }
    
}
?>