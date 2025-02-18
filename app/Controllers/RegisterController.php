<?php

namespace App\Controllers;

use AllowDynamicProperties;
use Core\Database;
use Core\Validacao;

class RegisterController
{
    public function index()
    {
        return view('registrar', null, 'guest');
    }
    public function register()
    {
        $validacao = Validacao::validar([
            'nome' => ['required'],
            'email' => ['required', 'email', 'confirmed', 'unique:usuarios'],
            'senha' => ['required', 'min:8', 'max:32', 'strong']
        ], request()->all());

        if ($validacao->naoPassou()) {
            return view('registrar', null, 'guest');
        }
        $database = new Database(config('database'));

        $database->query(
            "insert into usuarios ( nome, email, senha ) values ( :nome, :email, :senha )",
            null,
            [
                'nome' => request()->post('nome'),
                'email' => request()->post('email'),
                'senha' => password_hash(request()->post('senha'), PASSWORD_BCRYPT)
            ]
        );
        flash()->push('mensagem', 'Registrado com sucesso!');
        return redirect('/login');
    }
}
