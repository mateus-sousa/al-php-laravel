<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Serie extends Model
{
    public $timestamps = false;
    protected $fillable = ['nome', 'capa'];

    // uma função acessor ela é chamada como atributo escrevendo o que estiver entre Get e Attibute
    // em snake case.
    public function GetCapaUrlAttribute()
    {
    	if($this->capa){
    		return Storage::url($this->capa);
    	}
    	return Storage::url('serie/sem-imagem.jpg');
    }

    public function temporadas()
    {
        return $this->hasMany(Temporada::class);
    }
}
