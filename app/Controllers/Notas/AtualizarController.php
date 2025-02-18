<?php

namespace App\Controllers\Notas;

use Core\Database;
use Core\Validacao;
use App\Models\Nota;

class AtualizarController
{
    public function __invoke()
    {
        $validacao = Validacao::validar(
            array_merge([
                'titulo' => ['required', 'min:3', 'max:255'],
                'id' => ['required']
            ], session()->get('mostrar') ? ['nota' => ['required']] : []),
            request()->all()
        );

        if ($validacao->naoPassou()) {
            return redirect('/notas?id=' . request()->post('id'));
        }

        Nota::update(
            request()->post('id'),
            request()->post('titulo'),
            request()->post('nota'));

        flash()->push('mensagem', 'Registro atualizado com sucesso.');
        return redirect('/notas');
    }
}
