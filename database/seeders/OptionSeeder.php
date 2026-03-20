<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Prize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    public function run(): void
    {
        /*Prize::create([
            'title' => 'KarSU DevCUP: I season',
            'desc' => [
                'uz' => '10 haftalik marafonda ishtirok eting, hafta qaharmoni va turnir g‘oliblari uchun belgilangan sovg‘alarni qo‘lga kiritish imkoniyatiga ega bo‘ling. O‘z mahoratingizni ko‘rsating, dasturchilikga katta qadamlar bilan!',
                'kaa' => '10 háptelik marafonda qatnasıń, hápte qaharmanı hám turnir jeńimpazları ushın belgilengen sawǵalardı qolǵa kiritiw imkániyatına iye bolıń. Óz sheberligińizdi ko‘rsetiń, programmistlikke úlken adımlar menen!',
                'ru' => 'Примите участие в 10-недельном марафоне, получите шанс выиграть призы для еженедельных победителей и участников турнира. Продемонстрируйте свои навыки и сделайте большой шаг к программированию!',
            ],
            'image' => 'https://img.freepik.com/free-photo/young-redhead-woman-holding-christmas-gift-box-money-smiling-pleased-standing-blue-backgrou_1258-181255.jpg',
            'actual' => '1',
        ]);*/
        Option::create([
            'key' => 'language',
            'value' => 'uz',
        ]);
        Option::create([
            'key' => 'per_page',
            'value' => '15',
        ]);
        Option::create([
            'key' => 'title',
            'value' => 'translate',
            'translate' => [
                'uz' => 'Dasturchi talabalar maktabi',
                'kaa' => 'Programmist studentler mektebi',
                'ru' => 'Школа для студентов-программистов',
                'en' => 'Programming Student School',
            ],
        ]);
        Option::create([
            'key' => 'description',
            'value' => 'translate',
            'translate' => [
                'uz' => 'Dasturlash bo‘yicha turnirlarda qatnash, o‘z mahoratingni ko‘rsat va eng yaxshilardan bo‘l!',
                'kaa' => 'Programmalastırıw boyınsha turnirde qatnas, óz sheberligińdi kórset hám eń zorlardan bol!',
                'ru' => 'Принимайте участие в турнирах по программированию, демонстрируйте свои навыки и станьте одним из лучших!',
                'en' => 'Participate in programming tournaments, show off your skills, and become one of the best!',
            ],
        ]);
        Option::create([
            'key' => 'meta_description',
            'value' => 'translate',
            'translate' => [
                'uz' => 'Talabalar o‘rtasida dasturlash bo‘yicha haftalik marafoni. O‘z mahoratingizni ko‘rsating va eng yaxshilardan bo‘ling! Turnirda g‘olib bo‘lib qimmat baho sovg‘alar va vaucherlar yutib oling.',
                'kaa' => 'Studentler arasındaǵı programmalastırıw boyınsha háptelik marafonı. Óz sheberligińizdi kórsetiń hám eń zorlardıń qatarında bolıń! Turnirda jeńimpaz bolıp qımbat bahalı sawǵalar hám vaucherler iyesine aylanıń.',
                'ru' => 'Еженедельный марафон программирования среди студентов. Продемонстрируйте свои навыки и станьте одним из лучших! Выиграйте ценные призы и ваучеры, победив в турнире.',
                'en' => 'A weekly programming marathon among students. Show off your skills and be one of the best! Win valuable prizes and vouchers by winning the tournament.',
            ],
        ]);
    }
}
