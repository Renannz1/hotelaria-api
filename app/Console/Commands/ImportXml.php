<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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

        foreach($xml->Hotel as $hotel){
            echo $hotel->Name . "\n";
        }

    }


}
