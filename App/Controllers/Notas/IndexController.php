<?php

namespace App\Controllers\Notas;

class IndexController
{
    public function __invoke()
    {
        return view('notas');
    }
}
