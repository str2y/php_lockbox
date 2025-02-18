<?php

namespace App\Controllers\Notas;

use App\Models\Nota;

class IndexController
{
    public function __invoke()
    {
        $notas = Nota::all(request()->get('pesquisar'));

        if (!$notaSelecionada = $this->getNotaSelecionada($notas)) {
            return view('notas/nao-encontrada');
        }

        return view(
            'notas/index',
            [
                'notas' => $notas,
                'notaSelecionada' => $notaSelecionada
            ]
        );
    }

    private function getNotaSelecionada($notas)
    {
        $id = request()->get('id', (sizeof($notas) > 0 ? $notas[0]->id : null));
        $filtro = array_filter($notas, function ($n) use ($id) {
            return $n->id == $id;
        });
        return array_pop($filtro);
    }
}
