<?php

namespace Database\Seeders;

use App\Models\RoutePackage;
use Illuminate\Database\Seeder;

class RoutePackageSeeder extends Seeder
{
    /**
     * Seed the "Our Route" packages shown on the homepage.
     * Idempotent: keyed on route name.
     */
    public function run(): void
    {
        // Every route uses the same six vehicle labels; only prices differ.
        $labels = [
            'Camry, Sonata (4 Seater)',
            'Hyundai H1 (7 Seater)',
            'GMC New Model (7 Seater)',
            'Hiace (11 Seater)',
            'Coaster (17 Seater)',
            'Bus (42 Seater)',
        ];

        // name => [six prices in label order]
        $routes = [
            'JEDDAH AIRPORT TO MAKKAH HOTEL'                => [250, 330, 430, 400, 600, 800],
            'MAKKAH HOTEL TO JEDDAH AIRPORT'               => [200, 300, 400, 350, 500, 800],
            'MAKKAH HOTEL TO MADINA HOTEL'                 => [400, 530, 850, 600, 1000, 1300],
            'MADINA HOTEL TO MAKKAH HOTEL'                 => [400, 530, 850, 600, 1000, 1300],
            'MADINA AIRPORT TO MADINA HOTEL'               => [150, 200, 300, 300, 500, 700],
            'MADINA HOTEL TO MADINA AIRPORT'               => [100, 150, 250, 200, 400, 600],
            'MAKKAH ZIYARAT'                               => [200, 300, 400, 350, 500, 700],
            'MADINA ZIYARAT'                               => [200, 250, 350, 300, 450, 600],
            'JEDDAH AIRPORT TO MADINA HOTEL'               => [450, 550, 900, 600, 1000, 1300],
            'MADINA HOTEL TO JEDDAH AIRPORT'               => [400, 530, 850, 600, 1000, 1300],
            'MAKKAH TO TAIF ZIARAH & RETURN MAKKAH'        => [450, 550, 850, 600, 1000, 1200],
            'MADINA HOTEL TO MAKKAH HOTEL VIA BADR'        => [600, 700, 1100, 800, 1300, 1600],
            'MADINA HOTEL TO BADR ZIYARAH TO MADINA HOTEL' => [450, 550, 800, 600, 900, 1200],
            'MADINA ZIYARAH + BADR ZIYARAH'                => [600, 750, 1100, 900, 1250, 1600],
            'MASJID-E-AYESHA MEEQAT'                       => [100, 150, 250, 250, 400, 550],
            'MASJID JURANA MEEQAT'                         => [125, 175, 250, 250, 450, 600],
            'MAKKAH HOTEL TO TAIF MEEQAT & BACK MAKKAH'    => [300, 400, 500, 450, 550, 700],
        ];

        $order = 0;
        foreach ($routes as $name => $prices) {
            $items = [];
            foreach ($labels as $i => $label) {
                $items[] = ['label' => $label, 'price' => (string) $prices[$i]];
            }

            RoutePackage::updateOrCreate(
                ['name' => $name],
                ['items' => $items, 'sort_order' => $order++, 'is_active' => true],
            );
        }

        $this->command?->info('Seeded ' . count($routes) . ' route packages.');
    }
}
