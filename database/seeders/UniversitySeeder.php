<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Medal;
use App\Models\System\University;
use Illuminate\Database\Seeder;

class UniversitySeeder extends Seeder
{
    public function run(): void
    {
        University::create([
            'id' => 346,
            'name' => [
                'uz' => 'Berdaq nomidagi Qoraqalpoq davlat universiteti',
                'kaa' => 'Berdaq atındaǵı Qaraqalpaq mámleketlik universiteti',
                'ru' => 'Каракалпакский государственный университет имени Бердаха'
            ],
            'logo' => 'https://hemis.karsu.uz/static/crop/2/5/250_250_90_2588838948.jpg',
            'client_id' => '5',
            'client_secret' => 'tb1BGJjAK8T3H-lUldeMGsGNDwmFpeWT-fVOjfKr',
            'hemis_url' => 'https://hemis.karsu.uz',
            'hemis_student_url' => 'https://student.karsu.uz',
            'status' => '1',
            'activated_to' => '2027-07-17',
        ]);

        Medal::create([
            'name' => [
                'uz' => 'Raxmat Sizga',
                'kaa' => 'Raxmet Sizge',
                'ru' => 'Спасибо Вам',
                'en' => 'Thanks You',
            ],
            'desc' => [
                'uz' => 'Tizimda verifikatsiya harakati uchun minnatdorchilik medali',
                'kaa' => 'Sistemadaǵı verifikaciya háreketi ushın minnetdarshılıq medalı',
                'ru' => 'Медаль благодарности за проверку данных в системе',
                'en' => 'Medal of appreciation for verification action in the system',
            ],
            'type' => 'verify',
            'image' => 'medals/verified.png',
        ]);
    }
}
