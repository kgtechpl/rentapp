<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Narzędzia budowlane', 'icon' => 'fas fa-hammer', 'description' => 'Młoty, wiertarki, szlifierki i inne narzędzia budowlane.', 'sort_order' => 1],
            ['name' => 'Sprzęt ogrodowy', 'icon' => 'fas fa-seedling', 'description' => 'Kosy, kosiarki, glebogryzarki i inne narzędzia ogrodnicze.', 'sort_order' => 2],
            ['name' => 'Maszyny budowlane', 'icon' => 'fas fa-truck', 'description' => 'Betoniarki, zagęszczarki, rusztowania.', 'sort_order' => 3],
            ['name' => 'Sprzęt elektryczny', 'icon' => 'fas fa-bolt', 'description' => 'Agregaty prądotwórcze, przedłużacze, rozdzielnice.', 'sort_order' => 4],
        ];

        foreach ($categories as $data) {
            Category::firstOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}
