<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    // não é necessário para a conexão, mas é uma boa prática
    protected $table = 'produtos';
    // fillable determina os campos preenchiveis da tabela
    protected $fillable = ['nome','descricao','valor','url_imagem'];
}
