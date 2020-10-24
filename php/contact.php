<?php 

    $array = array("firstname" => "", "name" => "", "email" => "", "phone" => "", "message" => "", "firstnameError" => "", 
    "nameError" => "", "emailError" => "", "phoneError" => "", "messageError" => "", "isSuccess" => false);

    $emailTo = "victor.cyprien@limayrac.fr";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $array["firstname"] = verifyInput($_POST['firstname']);
        $array["name"] = verifyInput($_POST['name']);
        $array["email"] = verifyInput($_POST['email']);
        $array["phone"] = verifyInput($_POST['phone']);
        $array["message"] = verifyInput($_POST['message']);
        $array["isSuccess"] = true;
        $emailText = "";
        
        if(empty($array["firstname"])){
            $array["firstnameError"] = "Je veux savoir ton prénom";
            $array["isSuccess"] = false;
        } else {
            $emailText .= "FirstName: {$array['firstname']}\n";
        }
        
        if(empty($array["name"])){
            $array["nameError"] = "Et oui, je veux savoir ton nom aussi";
            $array["isSuccess"] = false;
        } else {
            $emailText .= "Name: {$array['name']}\n";
        }

        if(!isEmail($array["email"])){
            $array["emailError"] = "C'est pas une adresse email valide ça...";
            $array["isSuccess"] = false;
        } else {
            $emailText .= "Email: {$array['email']}\n";
        }
        
        if(!isPhone($array["phone"])){
            $array["phoneError"] = "Uniquement des chiffres et des espaces s'il te plaît";
            $array["isSuccess"] = false;
        } else {
            $emailText .= "Phone: {$array['phone']}\n";
        }
        
        if(empty($array["message"])){
            $array["messageError"] = "J'aimerais savoir ce que tu veux me dire";
            $array["isSuccess"] = false;
        } else {
            $emailText .= "Message: {$array['message']}\n";
        }
        
        if($array["isSuccess"]){
            $headers = "From: {$array['firstname']} {$array['name']} <{$array['email']}>\r\nReply-to: {$array['email']}";
            mail($emailTo, "Un message du site", $emailText, $headers);
        }
           
        echo json_encode($array);
        
    }

    function isEmail($var){
        return filter_var($var, FILTER_VALIDATE_EMAIL);
    }

    function isPhone($var){
        return preg_match("/^[0-9 ]*$/", $var);
    }

    function verifyInput($var){
        $var = trim($var);
        $var = stripslashes($var);
        $var = htmlspecialchars($var);
        
        return $var;
    }

?>
