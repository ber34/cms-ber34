<?php

function __autoload($classname)
{
   $filename = dirname(__FILE__) . '/lib/'.basename($classname .".php");
    include_once($filename);

    if(!class_exists($classname, false)) {
       $error = "Unable to load class: ".$classname;
    }   
}

if (class_exists('parse_UrlClass')) {
     $url   = new parse_UrlClass(); // Adres
}

if (class_exists('registerUserClass')) {
     $userRejestracja   = new registerUserClass(); // Register
}

if (class_exists('userSesionClass')) {
    $session     = new userSesionClass(); // Sesion
}

if (class_exists('chatClass')) {
       $chat    = new chatClass(); // Chat
}

if (class_exists('userClass')) {
    $user     = new userClass(); // User
}
   
 if (class_exists('databaseClass')) {
    $pdo  = new databaseClass(); // baza danych
}

if (class_exists('logClass')) {
    $log  = new logClass(); // baza danych
}

if(!empty($error))
   {
    echo $error;
   }
