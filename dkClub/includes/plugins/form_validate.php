<?php
function check_email2($email){        
    if(preg_match('/^[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+(?:\.[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+)*\@[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+(?:\.[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+)+$/i', $email)){
        return true;
    }else{
        return false;
    }
}
function check_int2($int){
    if(is_numeric($int) === TRUE){
        if((int)$int == $int){
            return TRUE;
        }else{
            return FALSE;
        }
    }else{
        return FALSE;
    }
}
function validate($name, $field, $options){
    $ok = True;
    $errors = array();
    if($options['req']){
        if(isset($field)){
            if(empty($field)){
                $ok = False;
                array_push($errors, 'Eingabe erforderlich');
            }
        }else{
            $ok = False;
            array_push($errors, 'Eingabe erforderlich');
        }
    }
    if($options['type'] == 'mail'){
        if(!check_email2($field)){
            $ok = False;
            array_push($errors, 'Keine gültige E-Mail Adresse');
        }
    }elseif($options['type'] == 'int'){
        if(!check_int2($field)){
            $ok = False;
            array_push($errors, 'Keine gültige Zahl');
        }
    }elseif($option['type'] == 'ckeckbox'){
        if(!in_array($field, $options['choice'])){
            array_push($errors, 'Die Eingabe hat kein gültiges Format');
        }
    }
    if($options['min']){
        if(strlen($field) < $options['min']){
            $ok = False;
            array_push($errors, 'Eingabe zu kurz, minimale Länge ' . $options['min']);
        }
    }
    if($options['max']){
        if(strlen($field) > $options['max']){
            $ok = False;
            array_push($errors, 'Eingabe zu lang, maximale Länge ' . $options['max']);
        }
    }
    if(count($errors) != 0){
        $field = '';
    }
    $erg = array('field' => $name,
                 'ok' => $ok,
                 'errors' => $errors,
                 'value' => $field);
    return $erg;
}

function validate_form($form, $fields){
    # $form = $_GET oder $_POST
    # $fields = array('name' => array('reg' => True, 'min' => 3),
    #                 'usw.' => array('reg' => False))
    
    $validated = array();
    
    foreach($fields as $key => $value){
        if(isset($form[$key])){
            $erg = validate($key, $form[$key], $fields[$key]);
            $validated[$key] = $erg;
        }else{
            $options = $fields[$key];
            if(isset($options['default'])){
                $erg = array('field' => $key,
                             'ok' => True,
                             'errors' => array($options['default']),
                             'value' => False);
                             
                $validated[$key] = $erg;
            }else{
                $erg = array('field' => $key,
                             'ok' => False,
                             'errors' => array('Feld wurde im Formular nicht gefunden'),
                             'value' => False);
                             
                $validated[$key] = $erg;
            }
        }
    }
    return $validated;
}
?>
