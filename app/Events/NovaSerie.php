<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

//O evento recebe os parametros relativos ao negocio seu construtor e os atribui em suas propriedades para
// poderem ser ouvidas pelos listeners
class NovaSerie
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $nome_serie;

    public $qtd_temporadas;
    
    public $qtd_episodios;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($nomeSerie, $qtdTemporadas, $qtdEpisodios)
    {
        $this->nome_serie = $nomeSerie;
        $this->qtd_temporadas = $qtdTemporadas;
        $this->qtd_episodios = $qtdEpisodios;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
