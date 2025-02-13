<?php

use Core\Database;
use Core\Validacao;
use App\Models\Usuario;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database(config('database'));

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $validacao = Validacao::validar([
        'email' => ['required', 'email'],
        'senha' => ['required']
    ], $_POST);

    if ($validacao->naoPassou()) {
        view('login');
        exit();
    }

    $usuario = $database->query(
        "select * from usuarios
    where email = :email",
        Usuario::class,
        compact('email')
    )
        ->fetch();

    if ($usuario && password_verify($_POST['senha'], $usuario->senha)) {

        $_SESSION['auth'] = $usuario;
        flash()->push('mensagem', 'Seja bem-vindo ' . $usuario->nome . '!');
        header('location: /');
        exit();
    } else {
        flash()->push('validacoes', ['email' => ['Usuário ou senha estão incorretos']]);
        view('login');
        exit();
    }
}

view('login');
