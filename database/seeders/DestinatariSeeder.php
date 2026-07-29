<?php

namespace Database\Seeders;

use App\Models\Destinatario;
use App\Enum\StatoIscrizione;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DestinatariSeeder extends Seeder
{
    
    public function run(): void
    {
        //titolo e route
        $items = [
            [
                'nome' => 'Michele',
                'cognome' => 'Test',
                'email' => 'Michele@test',
                'stato' => StatoIscrizione::Iscritto
            ],
            [
                'nome' => 'Filippo',
                'cognome' => 'Test',
                'email' => 'Filippo@test',
                'stato' => StatoIscrizione::Iscritto
            ],
            [
                'nome' => 'Sofia',
                'cognome' => 'Test',
                'email' => 'Sofia@test',
                'stato' => StatoIscrizione::Disiscritto
            ],
        ];
        
        foreach ($items as $contatto) {
            Destinatario::create($contatto);
        }
    }
}
