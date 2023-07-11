<?php
namespace App\Services;

use App\{Serie, Temporada, Episodio};
use Illuminate\Support\Facades\DB;
use App\Events\SerieApagada;
use App\Jobs\ExcluirCapaSerie;

class RemovedorDeSerie
{
    public function removerSerie(int $serieId): string
    {
        $nomeSerie = '';
        DB::transaction(function () use ($serieId, &$nomeSerie) {
            $serie = Serie::find($serieId);
            //A variável do Model só armazena o ID do registro, então, quando ela vai buscar o ID no banco de dados e ele não existe, uma exception é emitida e o processo é dado como falhado.
            //Nesse caso convertemos a nossa model para um objeto simples do PHP.
            $serieObj = (object) $serie->toArray();
            $nomeSerie = $serie->nome;

            $this->removerTemporadas($serie);
            $serie->delete();
           
            $evento = new SerieApagada($serieObj);
            event($evento);

            ExcluirCapaSerie::dispatch($serieObj);
        });

        return $nomeSerie;
    }

    /**
     * @param $serie
     */
    private function removerTemporadas(Serie $serie): void
    {
        $serie->temporadas->each(function (Temporada $temporada) {
            $this->removerEpisodios($temporada);
            $temporada->delete();
        });
    }

    /**
     * @param Temporada $temporada
     */
    private function removerEpisodios(Temporada $temporada): void
    {
        $temporada->episodios->each(function (Episodio $episodio) {
            $episodio->delete();
        });
    }
}
