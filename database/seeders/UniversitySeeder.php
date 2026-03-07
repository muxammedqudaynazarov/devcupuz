<?php

namespace Database\Seeders;

use App\Models\System\University;
use Illuminate\Database\Seeder;

class UniversitySeeder extends Seeder
{
    public function run(): void
    {
        University::create([
            'id' => 346,
            'name' => 'Berdaq nomidagi Qoraqalpoq davlat universiteti',
            'logo' => 'https://hemis.karsu.uz/static/crop/2/5/250_250_90_2588838948.jpg',
            'client_id' => '5',
            'client_secret' => 'tb1BGJjAK8T3H-lUldeMGsGNDwmFpeWT-fVOjfKr',
            'hemis_url' => 'https://hemis.karsu.uz',
            'hemis_student_url' => 'https://student.karsu.uz',
            'status' => '1',
            'activated_to' => '2027-07-17',
        ]);
    }
}
