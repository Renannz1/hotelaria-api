<?php

namespace App\Console\Commands;

use App\Models\Deilies;
use App\Models\Guest;
use App\Models\Hotel;
use App\Models\Payment;
use App\Models\Reserve;
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
            if ($xml->getName() === 'Hotels') {
                $this->importarXmlHotels($xml);
            } elseif ($xml->getName() === 'Rooms'){
                $this->importarXmlRooms($xml);
            } elseif ($xml->getName() === 'Reserves'){
                $this->importarXmlReserve($xml);
            }
        } catch (\Exception $e) {
            $this->error("erro ao importar os arquivos xml para o banco de dados." . $e->getMessage());
        }
    }

    private function importarXmlHotels(SimpleXMLElement $xml){
        foreach ($xml->Hotel as $hotel) {
            $hotelCode = (string) $hotel['id'];
            $name = (string) $hotel->Name;

            Hotel::updateOrCreate(
                ['id' => $hotelCode],
                ['name' => $name]
            );
        }
        $this->info("importacao do xml de hotels realizada com sucesso.");
    }

    private function importarXmlRooms(SimpleXMLElement $xml){
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
        $this->info("importacao do xml de rooms realizada com sucesso.");
    }

    private function importarXmlReserve(SimpleXMLElement $xml){
        foreach ($xml->Reserve as $reserve) {
            $reserveId = (int) $reserve['id'];
            $checkIn = (string) $reserve->CheckIn;
            $checkOut = (string) $reserve->CheckOut;
            $total = (float) $reserve->Total;
            $hotelId = (int) $reserve['hotelCode'];
            $roomCode = (int) $reserve['roomCode'];

            Reserve::updateOrCreate(
                ['id' => $reserveId],
                [
                    'hotel_id' => $hotelId,
                    'room_id' => $roomCode,
                    'check_in' => $checkIn,
                    'check_out' => $checkOut,
                    'total' => $total,
                ]
            );

            if(isset($reserve->Guests) && isset($reserve->Guests->Guest)) {
                foreach ($reserve->Guests->Guest as $guest) {
                    $name = (string) $guest->Name;
                    $lastName = (string) $guest->LastName;
                    $phone = (string) $guest->Phone;

                    Guest::updateOrInsert(
                        [
                            'phone' => $phone,
                            'reserve_id' => $reserveId
                        ],

                        [
                            'name' => $name,
                            'last_name' => $lastName,
                        ]
                    );
                }
            }

            if(isset($reserve->Dailies) && isset($reserve->Dailies->Daily)){
                foreach ($reserve->Dailies->Daily as $daily) {
                    $date = (string) $daily->Date;
                    $value = (float) $daily->Value;

                    Deilies::updateOrInsert(
                        [
                            'date' => $date,
                            'reserve_id' => $reserveId
                        ],
                        ['value' => $value]
                    );
                }
            }

            if(isset($reserve->Payments) && isset($reserve->Payments->Payment)){
                foreach ($reserve->Payments->Payment as $payment) {
                    $method = (int) $payment->Method;
                    $value = (float) $payment->Value;

                    Payment::create(
                        [
                            'reserve_id' => $reserveId,
                            'method' => $method,
                            'value' => $value
                        ]
                    );
                }
            }
        }
        $this->info("importacao do xml de reserves realizada com sucesso.");
    }
}

