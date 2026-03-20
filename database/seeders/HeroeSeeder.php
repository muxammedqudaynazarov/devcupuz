<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Heroe;
use App\Models\Tournament;
use App\Models\User;
use App\Models\Week;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class HeroeSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => json_encode([
                'short' => 'Qudaynazarov M.',
                'full' => 'Qudaynazarov Mukhammed',
            ]),
            'username' => 'muxammed',
            'password' => Hash::make('Muxammed-1222'),
            'phone' => '998999593938',
            'pos' => 'user',
            'rol' => json_encode(['user', 'super_admin']),
            'university_id' => 346,
            'status' => '1',
        ]);
        $user->assignRole('user');

        $tournament = Tournament::create([
            'name' => 'KarSU DevCUP: I season',
            'desc' => [
                'uz' => '<h1>DevCUP: 1st season turniri</h1><p>&nbsp;</p><p>Házirshe tek ǵana test qılıw ushın ashılǵan, sayttaǵı hámme maǵlıwmatlar óshiriliwi itimallıǵı bar ekenligin esapqa alıń</p>',
                'ru' => '<h1>DevCUP: 1st season turniri</h1><p>&nbsp;</p><p>Házirshe tek ǵana test qılıw ushın ashılǵan, sayttaǵı hámme maǵlıwmatlar óshiriliwi itimallıǵı bar ekenligin esapqa alıń</p>',
                'kaa' => '<h1>DevCUP: 1st season turniri</h1><p>&nbsp;</p><p>Házirshe tek ǵana test qılıw ushın ashılǵan, sayttaǵı hámme maǵlıwmatlar óshiriliwi itimallıǵı bar ekenligin esapqa alıń</p>',
            ],
            'started' => '2026-03-16 16:00:00',
            'finished' => '2026-03-16 19:00:00',
            'deadline' => '2026-03-16 15:40:00',
            'status' => '1',
            'home' => '1',
        ]);

        $week = Week::create([
            'name' => [
                'uz' => 'Kirish',
                'ru' => '',
                'kaa' => 'Kirisiw',
            ],
            'tournament_id' => $tournament->id,
            'week_number' => 1,
            'started' => '2026-03-08 15:05:00',
            'finished' => '2026-03-27 14:00:00',
        ]);
        Heroe::create([
            'user_id' => 1,
            'week_id' => $week->id,
            'points' => 60,
            'image' => 'https://s1.q4cdn.com/104539020/files/doc_multimedia/PROX2-Landscape-21.jpg',
            'desc' => [
                'uz' => '12.02.2026 kuni o‘tkazilgan turda eng yaxshi natija ko‘rsatgani uchun «Hafta qaharmoni» sovrindori bo‘ldi va esdalik uchun «LogiTech Superlite mouse» esdalik sovg‘a sifatida taqdirlandi.',
                'ru' => 'Он был удостоен награды «Герой недели» за лучшее выступление в раунде, состоявшемся 12.02.2026, и получил в подарок мышь LogiTech Superlite.',
                'kaa' => '12.02.2026 kúni ótkerilgen turda eń jaqsı nátiyje kórsetkeni ushın "Hápte qaharmanı" sıylıǵı iesi boldı hám estelik ushın "LogiTech Superlite mouse" estelik sawǵası sıpatında sıylıqlandı.',
            ]
        ]);
        Heroe::create([
            'user_id' => 1,
            'week_id' => $week->id,
            'points' => 85,
            'image' => 'https://s1.q4cdn.com/104539020/files/doc_multimedia/PROX2-Landscape-21.jpg',
            'desc' => [
                'uz' => '16.03.2026 kuni o‘tkazilgan turda eng yaxshi natija ko‘rsatgani uchun «Hafta qaharmoni» sovrindori bo‘ldi va esdalik uchun «LogiTech Superlite mouse» esdalik sovg‘a sifatida taqdirlandi.',
                'ru' => 'Он был удостоен награды «Герой недели» за лучшее выступление в раунде, состоявшемся 16.03.2026, и получил в подарок мышь LogiTech Superlite.',
                'kaa' => '16.03.2026 kúni ótkerilgen turda eń jaqsı nátiyje kórsetkeni ushın "Hápte qaharmanı" sıylıǵı iesi boldı hám estelik ushın "LogiTech Superlite mouse" estelik sawǵası sıpatında sıylıqlandı.',
            ]
        ]);

        Comment::create([
            'user_id' => 1,
            'user_work' => 'QQDU talabasi',
            'text' => 'Ushbu turnir orqali algoritmlash bo‘yicha bilimlarimni amalda sinab ko‘rish imkoniyatiga ega bo‘ldim. Har haftalik qiyinlashib boruvchi masalalar juda qiziqarli!',
            'rating' => 5,
            'status' => '1',
        ]);
        Comment::create([
            'user_id' => 1,
            'user_work' => 'NDTU talabasi',
            'text' => 'Raqobat ruhi juda kuchli. Reytingda o‘z ismimni yuqorida ko‘rish uchun har kuni qo‘shimcha o‘qib, o‘rganishga harakat qilyapman. Tashkilotchilarga rahmat.',
            'rating' => 4,
            'status' => '1',
        ]);
    }
}
