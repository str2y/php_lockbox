<?php

function base_path($path){
    return __DIR__ . '/../' . $path;
}

function redirect($uri){
    return header('location: '.$uri);
}

function view($view, $data=[], $template = 'app')
{
    foreach ($data as $key => $value) {
        $$key = $value;
    }
    require base_path("views/template/$template.php");
}

function dd(...$dump)
{
    dump($dump);
    die();
};

function dump(...$dump){
    echo '<pre>';
    var_dump($dump);
    echo '</pre>';
}

function abort($code)
{
    http_response_code($code);
    view($code);
    die();
}

function flash(){
   return new Core\Flash;
}

function config($chave = null){
    $config = require base_path('config/config.php');

    if(strlen($chave)>0){
        return $config[$chave];
    }
    return $config;
}

function auth(){
    if (!isset($_SESSION['auth'])){
        return null;
    }
    return $_SESSION['auth'];
}

function old($campo){
    $post = $_POST;

    if(isset($post[$campo])){
        return $post[$campo];
    }
    return '';
}