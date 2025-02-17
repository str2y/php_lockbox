<?php

namespace App\Models;

use Core\Database;

class Nota
{
    public $id;
    public $usuario_id;
    public $titulo;
    public $nota;
    public $data_criacao;
    public $data_atualizacao;

    public function nota()
    {
        if (session()->get('mostrar')) {
            return $this->nota;
        }
        return str_repeat('*', rand(1, 99));
    }

    public static function all($pesquisar = null)
    {

        $db = new Database(config('database'));
        return $db->query(
            "select * from notas where usuario_id = :usuario_id " . ($pesquisar ? "and titulo like :pesquisar" : null),
            self::class,
            array_merge(['usuario_id' => auth()->id], $pesquisar ? ['pesquisar' => "%$pesquisar%"] : [])
        )->fetchAll();
    }

    public static function update($id, $titulo, $nota)
    {
        $set = "titulo = :titulo";
        if ($nota) {
            $set .= ", nota = :nota";
        }

        $db = new Database(config('database'));
        $db->query(
            "update notas
            set $set
            where id = :id",
            null,
            array_merge([
                'id' => $id,
                'titulo' => $titulo

            ], $nota ? ['nota' => $nota] : [])
        );
    }

    public static function delete($id)
    {
        $db = new Database(config('database'));
        $db->query(
            "delete from notas
            where id = :id",
            null,
            ['id' => $id]
        );
    }
}
