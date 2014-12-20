<?php
function plugin_edit_page($page){
    if(!$_SESSION["spezi"] == 1){
        return '<h1>Sie dürfen dieses Plugin nicht ausführen!</h1>';
    }
    if(isset($_GET['edit_page'])){
        $page = $_GET['edit_page'];
        $html = "<script type='text/javascript' src='ckeditor/ckeditor.js'></script>
                 <form action='index.php?site=i_spezi&amp;preview_site=$page' method='post'>
                 <div style='position:absolute;width:1000px;'>
                 <textarea cols='100' id='editor1' name='editor1' rows='100'>";
        
        if(startswith($_GET['edit_page'], "i_")){
            $html = $html . file_get_contents('intern/' . $_GET['edit_page']);
        }else{
            $html = $html . file_get_contents('content/' . $_GET['edit_page']);
        }
        $html = $html . "</textarea></div><script type='text/javascript'>
			    var editor = CKEDITOR.replace('editor1',{
			        contentsCss : ['styles/default.css', 'styles/html.css'],
			        height : '800px',
			        width : '1000px',
			        enterMode : CKEDITOR.ENTER_BR
			    });
		    </script>
	    </form>";
	
        return $html;
    }elseif(isset($_GET['preview_site'])){
        $page = $_GET['preview_site'];
        $html = "<div style='position:absolute;border:1px solid red;width:250px;'>Vorschau
                 <a href='index.php?site=i_spezi&amp;save_site=$page'>Speichern</a></div>";

        if(get_magic_quotes_gpc()){
	    $value = stripslashes($_POST['editor1']);
        }else{
            $value = $_POST['editor1'];
        }

        $_SESSION['site_preview'] = $value;
        $html = $html . $value;
        return $html;
        
    }elseif(isset($_GET['save_site'])){
        if(startswith($_GET['save_site'], "i_")){
            $local = 'intern/';
        }else{
            $local = 'content/';
        }
        $old = file_get_contents($local . $_GET['save_site']);
        $count = 0;
        while(true){
            if(!file_exists($local . $_GET['save_site'] . "_$count")){
                break;
            }
            $count++;
        }
        file_put_contents($local . $_GET['save_site'] . "_$count", $old);
        file_put_contents($local . $_GET['save_site'], $_SESSION['site_preview']);
        $empfaenger = "AH2@gmx.de";
        $absendername = "PHP";
        $absendermail = "webmaster@sev-kuernbach.de";
        $betreff = "Die Seite " . $_GET['save_site'] . ' wurde bearbeitet';
        $text = "Die Seite " . $_GET['save_site'] . " wurde bearbeitet.\nDie Name der alten Datei lautet: $local" . $_GET['save_site'] . "_$count";
        
        mail($empfaenger, $betreff, $text, "From: $absendername <$absendermail>");
        return 'Seite gespeichert, es wurde eine E-Mail an der Webmaster versand';
        
    }else{
        $html = "<h3>Seite Bearbeiten:</h3>
                 <ul>
                    <li><a href='index.php?site=i_spezi&amp;edit_page=index'>Startseite</a></li>
                    <li>Neuigkeiten<ul>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=next_day'>--nächster Fahrtag</a></li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=news_hp'>--Homepage</a></li>
                    </ul></li>
                    <li><a href='index.php?site=i_spezi&amp;edit_page=days'>Fahrtage</a></li>
                    <li>Anlage<ul>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=anlage'>--Die Anlage</a></li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=drive'>--Anfahrt</a></li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=info_ticket'>--Fahrpreise</a></li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=virtual_tour'>--Virtuelle Rundfahrt</a></li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=line_construction'>--Trassenbau</a></li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=track_construction'>--Gleisbau</a></li>
                    </ul></li>
                    <li>Fahrzeuge<ul>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=association_lo'>--Vereinslokomotiven</a></li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=harz_extra'>--Sonderseite Harzkamel</a></li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=steam_lo'>--Private Dampflok´s</a></li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=e_lo'>--Private E-Lok´s</a></li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=d_lo'>--Private Diesellok´s</a></li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=vt_lo'>--Private VT's u.a</a></li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=waggon'>--Wagen</a></li>
                    </ul></li>
                    <li>Instandhaltungs- arbeiten<ul>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=work_lo'>--bei Fahrzeugen</a></li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=work_anlage'>--an der Anlage</a></li>
                    </ul></li>
                    <li>Webcam</li>
                    <li>Bilder/Videos<ul>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=all_vids'>--alle Videos</a></li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=days_pic'>--Fahrtagsbilder</a></li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=pic_360'>--360° Anlagenbild</a></li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=dampffestarchiv'>--Dampffestarchiv</a></li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=bilderarchiv'>--Bilderarchiv</a></li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=pic_press'>--Bilder für die Presse</a></li>
                    </ul></li>
                    <li>Dampffest<ul>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=act_dampffest'>--Informationen</a></li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=join_dampf'>--Online-Anmeldung</a></li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=last_dampffest'>--Letztes Dampffest</a></li>
                    </ul></li>
                    <li>Über uns / Kontakt<ul>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=verein'>--Der Verein</a></li>
                        <li>--Kontakt</li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=become_member'>--Mitglied werden</a></li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=e_mail_list'>--E-Mail-Liste</a></li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=in_memory'>--Im Gedenken</a></li>
                    </ul></li>
                    <li>Gästebuch</li>
                    <li><a href='index.php?site=i_spezi&amp;edit_page=links'>Links</a></li>
                    <li><a href='index.php?site=i_spezi&amp;edit_page=downloads'>Downloads</a></li>
                    <li>Bauanleitungen<ul>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=diy_1'>--Feldbahnlok 5''</a></li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=diy_2'>--Feldbahnloren</a></li>
                    </ul></li>
                    <li>Intern<ul>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=i_main'>--Übersicht</a></li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=i_todo'>--Termine - Arbeiten auf der Anlage</a></li>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=i_vereinsheim'>--Belegung Vereinsheim</a></li>
                    </ul></li>
                    <li><a href='index.php?site=i_spezi&amp;edit_page=market'>Börse</a></li>
                    <li>Webseite<ul>
                        <li><a href='index.php?site=i_spezi&amp;edit_page=impressum'>--Impressum</a></li>
                    </ul></li>
                 </ul>";
        return $html;
    }
}
?>
