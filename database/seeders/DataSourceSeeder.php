<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DataSource;

class DataSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sources = [
            'Website',
            'Messenger',
            'WhatsApp',
            'Hotline Call',
            'ToguMogu App',
            'Offline Center',
            'GP Star',
            'BL Orange',
            'Robi Elite',
            'Teachers Time',
            'Goofi',
            'GForms',
        ];

        foreach ($sources as $source) {
            DataSource::firstOrCreate(['name' => $source]);
        }
    }
}
