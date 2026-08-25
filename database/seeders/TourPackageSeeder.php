<?php

namespace Database\Seeders;

use App\Models\TourPackage;
use Illuminate\Database\Seeder;

class TourPackageSeeder extends Seeder
{
    /**
     * Seed the "Packages" (tour/Umrah) cards shown on the homepage.
     * Idempotent: keyed on package name.
     */
    public function run(): void
    {
        $staria = '/wp-uploads/2025/11/car-1.png';
        $gmc = '/wp-uploads/2025/11/pic-3.png';

        $packages = [
            ['Package 1', 'Hyundai Staria', '8 Seater 8 Luggage', ['Jeddah Airport to Makkah', 'Makkah Hotel to Medina Hotel', 'Medina Hotel to Medina Airport'], '1200', $staria],
            ['Package 2', 'Hyundai Staria', '8 Seater 8 Luggage', ['Jeddah Airport to Makkah', 'Makkah Ziarat', 'Makkah Hotel to Medina Hotel', 'Medina Ziarat', 'Medina Hotel to Jeddah Airport'], '1600', $staria],
            ['Package 3', 'Hyundai Staria', '8 Seater 8 Luggage', ['Jeddah Airport to Makkah', 'Makkah Ziarat', 'Makkah Hotel to Medina Hotel', 'Medina Ziarat', 'Medina Hotel to Jeddah Airport'], '1550', $staria],
            ['Package 4', 'Hyundai Staria', '8 Seater 8 Luggage', ['Madina Airport to Madina Hotel', 'Madina Hotel to Makkah Hotel', 'Makkah Hotel to Jeddah Airport'], '1150', $staria],
            ['Package 5', 'Hyundai Staria', '8 Seater 8 Luggage', ['Madina Airport to Madina Hotel', 'Madina Hotel to Makkah Hotel', 'Makkah Hotel to Madina Airport'], '1200', $staria],
            ['Package 6', 'Hyundai Staria', '8 Seater 8 Luggage', ['Madina Airport to Madina Hotel', 'Madina Ziarat', 'Madina Hotel to Makkah Hotel', 'Makkah Ziarat', 'Makkah Hotel to Jeddah Airport'], '1600', $staria],
            ['Package 7', 'Hyundai Staria', '8 Seater 8 Luggage', ['Madina Airport to Madina Hotel', 'Madina Ziarat', 'Madina Hotel to Makkah Hotel', 'Makkah Ziarat', 'Makkah Hotel to Madina Airport'], '1550', $staria],
            ['Package 8', 'Via Train', '8 Seater Hyundai Staria', ['Jeddah Airport to Makkah Hotel', 'Makkah Hotel to Makkah Train Station', 'Madina Train Station to Madina Hotel', 'Madina Hotel to Madina Airport'], '1100', $staria],
            ['Package 9', 'Via Train', '8 Seater Hyundai Staria', ['Jeddah Airport to Makkah Hotel', 'Makkah Hotel to Makkah Train Station', 'Madina Train Station to Madina Hotel', 'Madina Hotel to Jeddah Airport'], '1300', $staria],
            ['Package 10', 'Via Train', '8 Seater Hyundai Staria', ['Madina Airport to Madina Hotel', 'Madina Hotel to Madina Train Station', 'Makkah Train Station to Makkah Hotel', 'Makkah Hotel to Jeddah Airport'], '1100', $staria],
            ['Package 11', 'Via Train', '8 Seater Hyundai Staria', ['Madina Airport to Madina Hotel', 'Madina Hotel to Madina Train Station', 'Makkah Train Station to Makkah Hotel', 'Makkah Hotel to Madina Airport'], '1200', $staria],
            ['Super Package 1', 'Staria / GMC', 'Premium Combined Ziarat', ['Jeddah Airport to Makkah', 'Makkah Ziarat + Taif Ziarat (Combine)', 'Makkah Hotel to Madina Hotel', 'Madina Ziarat + Badar Ziarat (Combine)', 'Madina Hotel to Madina Airport'], '2000', $gmc],
            ['Super Package 2', 'Staria / GMC', 'Grand Umrah Package', ['Jeddah Airport to Makkah Hotel', 'Makkah Ziarat', 'Makkah to Taif Ziarat to Madina', 'Madina Ziarat', 'Madina Hotel to Badar Ziarat to Jeddah Airport'], '2500', $gmc],
            ['Super Package 3', 'Staria / GMC', 'Grand Umrah Package', ['Madina Airport to Madina Hotel', 'Madina Ziarat', 'Madina Hotel to Badar Ziarat to Makkah Hotel', 'Makkah Ziarat', 'Makkah Hotel to Taif Ziarat to Jeddah Airport'], '2500', $gmc],
            ['Mega Package 1', 'Luxury Transport', 'Complete Tour Package', ['Madina Airport to Madina Hotel', 'Madina Ziarat', 'Badar Ziarat', 'Madina Hotel to Makkah Hotel', 'Makkah Ziarat', 'Taif Ziarat', 'Makkah Hotel to Madina Airport'], '2800', $gmc],
            ['Mega Package 2', 'Luxury Transport', 'Complete Tour Package', ['Madina Airport to Madina Hotel', 'Madina Ziarat', 'Badar Ziarat', 'Madina Hotel to Makkah Hotel', 'Makkah Ziarat', 'Taif Ziarat', 'Makkah Hotel to Jeddah Airport'], '2900', $gmc],
            ['Mega Package 3', 'Luxury Transport', 'Complete Tour Package', ['Jeddah Airport to Makkah', 'Makkah Ziarat', 'Taif Ziarat', 'Makkah Hotel to Madina Hotel', 'Madina Ziarat', 'Badar Ziarat', 'Madina Hotel to Madina Airport'], '2800', $gmc],
        ];

        foreach ($packages as $order => [$name, $badge, $capacity, $trips, $price, $image]) {
            TourPackage::updateOrCreate(
                ['name' => $name],
                [
                    'badge'       => $badge,
                    'capacity'    => $capacity,
                    'trips'       => implode("\n", $trips),
                    'price'       => $price,
                    'image'       => $image,
                    'footer_note' => 'Full-car options for every trip',
                    'sort_order'  => $order,
                    'is_active'   => true,
                ],
            );
        }

        $this->command?->info('Seeded ' . count($packages) . ' tour packages.');
    }
}
