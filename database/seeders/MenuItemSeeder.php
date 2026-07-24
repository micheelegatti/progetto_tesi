<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    
    public function run(): void
    {
        //titolo e route
        $items = [
            [
                'title' => 'Campagna',
                'route' => 'campagna',
            ],
            [
                'title' => 'Template',
                'route' => 'template',
            ],
            [
                'title' => 'Destinatari',
                'route' => 'destinatari',
            ],
        ];
        
        foreach ($items as $menuItem) {
            MenuItem::create($menuItem);
        }
    }
}
