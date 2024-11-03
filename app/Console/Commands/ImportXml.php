<?php

namespace App\Console\Commands;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use SimpleXMLElement;

class ImportXml extends Command
{

    protected $signature = 'command:import-xml-data {files*}';
    protected $description = 'Importa dados de um ou mais arquivo XML.';

    public function handle()
    {
        $files = $this->argument('files');

        foreach ($files as $file) {
            if(!file_exists($file)){
                $this->error("o arquivo {$file} nao foi encontrado.");
                return;
            }
            $this->importarDadosXML($file);
        }
    }

    private function importarDadosXML($file){
        $xmlConteudo = file_get_contents($file);
        $xml = new SimpleXMLElement($xmlConteudo);

        try {
            // importar xml hotels ------------
            if ($xml->getName() === 'Hotels') {
                foreach ($xml->Hotel as $hotel) {
                    $hotelCode = (string) $hotel['id'];
                    $name = (string) $hotel->Name;

                    Hotel::updateOrCreate(
                        ['id' => $hotelCode],
                        ['name' => $name]
                    );
                }
                $this->info("Importação dos dados do arquivo $file realizada com sucesso.");
            }
            // ------------------------------


            // importar xml rooms ------------
            elseif ($xml->getName() === 'Rooms') {
                foreach ($xml->Room as $room) {
                    $roomCode = (int) $room['id'];
                    $name = (string) $room->Name;
                    $hotelCode = (int) $room['hotelCode'];

                    Room::updateOrCreate(
                        ['id' => $roomCode],
                        [
                            'hotel_id' => $hotelCode,
                            'name' => $name
                        ]
                    );
                }
                $this->info("importacao dos dados do arquivo $file realizada com sucesso.");
            }
            // ------------------------------
        } catch (\Exception $e) {
            $this->error("erro ao importar os arquivos xml para o banco de dados." . $e->getMessage());
        }
    }
}
