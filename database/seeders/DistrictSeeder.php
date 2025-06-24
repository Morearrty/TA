<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        District::create([
            'name' => 'Jakarta Pusat',
            'code' => 'JKP'
        ]);
        
        District::create([
            'name' => 'Jakarta Barat',
            'code' => 'JKB'
        ]);
        
        District::create([
            'name' => 'Jakarta Timur',
            'code' => 'JKT'
        ]);
    }
}
