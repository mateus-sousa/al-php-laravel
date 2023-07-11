<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NovaSerie extends Mailable
{
    use Queueable, SerializesModels;

    public $nome;

    public $qtdTemporadas;

    public $qtdEpisodios;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nome, $qtdTemporadas, $qtdEpisodios)
    {
        $this->nome = $nome;
        $this->qtdTemporadas = $qtdTemporadas;
        $this->qtdEpisodios = $qtdEpisodios;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //markdown é igual a view, mas ao inves de trabalharmos com HTML, trabalhamos com linguagem de markdown
        return $this->markdown('mail.series.nova-serie');
    }
}
