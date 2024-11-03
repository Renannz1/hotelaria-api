<?php

namespace App\Console\Commands;

use App\Models\Hotel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use SimpleXMLElement;

class ImportXml extends Command
{

    protected $signature = 'command:import-xml-data {file}';
    protected $description = 'Importa dados de um arquivo XML.';

    public function handle()
    {
        $file = $this->argument('file');

        if(!file_exists($file)){
            $this->error("o arquivo {$file} nao foi encontrado.");
            return;
        }

        $xmlConteudo = file_get_contents($file);
        $xml = new SimpleXMLElement($xmlConteudo);

        // var_dump($xmlConteudo);
        // var_dump($xml);

        foreach ($xml->Hotel as $hotel) {
            echo $hotel->Name . "\n";
        }

        try {
            DB::beginTransaction();
            foreach ($xml->Hotel as $hotel) {
                $name = (string) $hotel->Name;

                Hotel::create([
                    'name' => $name,
                ]);
            }
            DB::commit();
            $this->info("Importação dos dados do arquivo XML realizada com sucesso.");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Erro ao importar os dados do arquivo XML para o banco de dados.");
        }
    }
}
