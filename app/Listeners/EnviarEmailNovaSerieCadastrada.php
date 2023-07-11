<?php

namespace App\Listeners;

use App\Events\NovaSerie;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use Illuminate\Support\Facades\Mail;


// Implementando a interface ShouldQueue, o Laravel entende que deve colocar a execução deste listener para ser processado de forma assíncrona.
class EnviarEmailNovaSerieCadastrada implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    // Um listener não costuma receber parametros em seu construtor
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NovaSerie  $event
     * @return void
     */

    // Handle será o metodo que ira manusear acoes de um listener.
    public function handle(NovaSerie $event)
    {
        $nomeSerie = $event->nome_serie;
        $qtdTemporadas = $event->qtd_temporadas;
        $qtdEpisodios = $event->qtd_episodios;

        //Buscamos todos usuarios
        $users = User::all();

        foreach($users as $i => $user){
            $multiplicador = $i + 1;

            // Para cada usuário criamos uma nova instancia de Mail NovaSerie passando por parametro as informações necessarias.
            $email = new \App\Mail\NovaSerie($nomeSerie, $qtdTemporadas, $qtdEpisodios);

            // Informa qual o assunto do Mail
            $email->subject = "Nova serie cadastrada.";

            //Define quando o comando deve ser executado
            $quando = now()->addSecond($multiplicador * 10);

            //send() apenas tentaria enviar o email diretamente
            //queue() armazenaria os dados do email numa fila no banco para ser tratado la.
            //later armazena os dados do email numa fila no banco e faz um tratamento minimo definindo qual o intervalo de tempo sera executado o mesmo.
            Mail::to($user)->later($quando, $email);
        }
    }
}
