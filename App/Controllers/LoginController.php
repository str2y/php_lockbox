<?php

namespace App\Controllers;

use Core\Database;
use Core\Validacao;
use App\Models\Usuario;

class LoginController
{
    public function index()
    {
        return view('login', null, 'guest');
    }
    public function login()
    {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $validacao = Validacao::validar([
            'email' => ['required', 'email'],
            'senha' => ['required']
        ], $_POST);

        if ($validacao->naoPassou()) {
            return view('login', null, 'guest');
        }

        $database = new Database(config('database'));

        $usuario = $database->query(
            "select * from usuarios
        where email = :email",
            Usuario::class,
            compact('email')
        )
            ->fetch();
        if (!($usuario && password_verify($_POST['senha'], $usuario->senha))) {
            flash()->push('validacoes', ['email' => ['Usuário ou senha estão incorretos']]);
            return view('login', null, 'guest');
        }
        $_SESSION['auth'] = $usuario;
        flash()->push('mensagem', 'Seja bem-vindo ' . $usuario->nome . '!');
        return redirect('/notas');
    }
}
