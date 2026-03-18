<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => [
                    'uz' => 'DevCup.uz qanday tizim?',
                    'kaa' => 'DevCup.uz qanday sistema?',
                    'ru' => 'Что представляет собой система DevCup.uz?',
                ],
                'answer' => [
                    'uz' => 'DevCup.uz — bu Qoraqalpoq davlat universiteti rektori B.Jollıbekov va O‘quv ishlari bo‘yicha prorektori O.Duysenbayevlarning qo‘llab-quvatlashi asosida universitet professor-o‘qituvchilari Kalbayev Allambergen va Qudaynazarov Muxammed tomonidan talabalar o‘rtasida semestr davomida dasturlash bo‘yicha haftalik turnir o‘tkazish uchun maxsus ishlab chiqarilgan platforma bo‘lib, unda ishtirokchilar har tur davomida algoritmlashga oid masalalarni yechish orqali o‘z mahoratlarini namoyish etadilar. Eng yaxshi natija ko‘rsatganlar talaba-yoshlar qimmat baholi sovg‘alar va maxsus vaucherlar bilan taqdirlanadi.',
                    'kaa' => 'DevCup.uz — bul Qaraqalpaq mámleketlik universiteti rektorı B.Jollıbekov hám Oqıw isleri boyınsha prorektori O.Duysenbayevlardıń qollap-quwatlawı tiykarında universitettiń professor-oqıtıwshıları Kalbaev Allambergen hám Qudaynazarov Muxammed tárepinen studentler arasında semestr dawamında programmalastırıw boyınsha háptelik turnir ótkeriw ushın arnawlı islep shıǵarılǵan platforma bolıp, onda qatnasıwshılar hár bir tur dawamında algoritmlewge baylanıslı máselelerdi sheshiw arqalı óz sheberliklerin kórsetedi. Eń jaqsı nátiyje kórsetken student-jaslar qımbat bahalı sawǵalar hám arnawlı vaucherler menen sıylıqlanadı.',
                    'ru' => 'DevCup.uz — это платформа, специально разработанная профессорско-преподавательским составом университета Калбаевым Алламбергеном и Кудайназаровым Мухаммадом при поддержке ректора Каракалпакского государственного университета Б.Жоллыбекова и проректора по учебной работе О.Дуйсенбаева для проведения еженедельного турнира по программированию среди студентов в течение семестра, где участники демонстрируют свои навыки, решая алгоритмические задачи в течение каждого тура. Студенты, показавшие лучшие результаты, будут награждены ценными подарками и специальными ваучерами.',
                ],
            ],
            [
                'question' => [
                    'uz' => 'Turnirda kimlar qatnashishi mumkin?',
                    'kaa' => 'Turnirde kimler qatnasıwı múmkin?',
                    'ru' => 'Кто может принять участие в турнире?',
                ],
                'answer' => [
                    'uz' => 'Hozirgi vaqtda turnirlarga Qoraqalpoq davlat universiteti talabasi bo‘lgan <i>(ta’lim shakli, kursi va mutaxassisligiga qaramasdan)</i> talabalar offline shaklda qatnashishi mumkin.',
                    'kaa' => 'Házirgi waqıtta turnirlerge Qaraqalpaq mámleketlik universiteti studenti bolǵan <i>(bilimlendiriw forması, kursı hám qánigeligine qaramastan)</i> studentler offlayn formada qatnasıwı múmkin.',
                    'ru' => 'В настоящее время студенты Каракалпакского государственного университета <i>(независимо от формы обучения, курса и специальности)</i> могут участвовать в турнирах в офлайн-формате.',
                ],
            ],
            [
                'question' => [
                    'uz' => 'Qaysi dasturlash tillaridan foydalanish mumkin?',
                    'kaa' => 'Qaysi programmalaw tillerinen paydalanıw múmkin?',
                    'ru' => 'Какие языки программирования можно использовать?',
                ],
                'answer' => [
                    'uz' => 'Tizimda mavjud bo‘lgan va yoki turnir tashkilotchisi tomonidan turnir uchun ruxsat etilgan dasturlash tillaridan ixtiyoriy bittasida yoki bir nechtasida foydalanish mumkin.',
                    'kaa' => 'Sistemada bar bolǵan hám yamasa turnir shólkemlestiriwshisi tárepinen turnir ushın ruxsat etilgen programmalastırıw tillerinen qálegen birewinde yamasa birneshesinde paydalanıw múmkin.',
                    'ru' => 'Можно использовать любой из доступных в системе и/или разрешенных организатором турнира языков программирования для турнира.',
                ],
            ],
            [
                'question' => [
                    'uz' => 'Tizimda kodni tekshirish statuslari qanday?',
                    'kaa' => 'Sistemada kodtı tekseriw statusları qanday?',
                    'ru' => 'Каковы статусы проверки кода в системе?',
                ],
                'answer' => [
                    'uz' => '<ul><li class="ql-align-justify"><span style="color: rgb(56, 189, 248);">Accepted:</span> Kodingiz barcha testlardan muvaffaqiyatli o‘tdi.</li><li class="ql-align-justify"><span style="color: rgb(56, 189, 248);">Wrong Answer:</span> Kodingiz qaytargan natija kutilgan natijaga mos kelmadi.</li><li class="ql-align-justify"><span style="color: rgb(56, 189, 248);">Time Limit Exceeded (TLE):</span> Kodingiz belgilangan vaqt cheklovidan sekinroq ishladi.</li><li class="ql-align-justify"><span style="color: rgb(56, 189, 248);">Memory Limit Exceeded (MLE):</span> Kodingiz ruxsat etilgan xotira miqdoridan ko‘p foydalandi.</li></ul>',
                    'kaa' => '<ul><li class="ql-align-justify"><span style="color: rgb(56, 189, 248);">Accepted:</span> Kodınız barlıq testlerden tabıslı ótti.</li><li class="ql-align-justify"><span style="color: rgb(56, 189, 248);">Wrong Answer:</span> Kodınız qaytarǵan nátiyje kútilgen nátiyjege sáykes kelmedi.</li><li class="ql-align-justify"><span style="color: rgb(56, 189, 248);">Time Limit Exceeded (TLE):</span> Kodınız belgilengen waqıt sheklewinen ásterek isledi.</li><li class="ql-align-justify"><span style="color: rgb(56, 189, 248);">Memory Limit Exceeded (MLE):</span> Kodıńıız ruqsat etilgen yadtan kóbirek paydalandı.</li></ul>',
                    'ru' => '<ul><li class="ql-align-justify"><span style="color: rgb(56, 189, 248);">Принято:</span> Ваш код успешно прошел все тесты.</li><li class="ql-align-justify"><span style="color: rgb(56, 189, 248);">Неверный ответ:</span> Ваш код вернул неожиданный результат.</li><li class="ql-align-justify"><span style="color: rgb(56, 189, 248);">Time Limit Exceeded (TLE):</span> Ваш код работал медленнее, чем установленный лимит времени.</li><li class="ql-align-justify"><span style="color: rgb(56, 189, 248);">Memory Limit Exceeded (MLE):</span> Ваш код использовал больше памяти, чем разрешено. Это было очень полезно.</li></ul>',
                ],
            ],
            [
                'question' => [
                    'uz' => 'Turnirda nimalar taqiqlanadi?',
                    'kaa' => 'Turnirde neler qadaǵan etiledi?',
                    'ru' => 'Что запрещено на турнире?',
                ],
                'answer' => [
                    'uz' => '<ol><li>Turnir vaqtida ishtirokchilar o‘zaro kod va g‘oyalar almashishi taqiqlanadi.</li><li>Tizimga zarar yetkazuvchi yoki shunga o‘xshash zararli kodlar yuborish taqiqlanadi.</li><li>Tizimda fayl ochish orqali yoki shunga o‘xshash cheating yo‘llar orqali masalani yechishga har qanday harakat qat’iyan taqiqlanadi.</li><li>Bir nechta profildan foydalanish taqiqlanadi, aniqlangan holatda barcha profillar bloklanadi.</li><li>Turnirda AI (ChatGPT, Copilot, Claude, Gemmi va boshqalar) botlardan foydalanish orqali qatnashish taqiqlanadi. Istisno holatlar mavjud emas va ma’lum tilda yozilgan kodni AI yordamida boshqasiga o‘tkazish ham mumkin emas.</li></ol>',
                    'kaa' => '<ol><li>Turnir waqtında qatnasıwshılar óz-ara kod hám ideyalar almasıwı qadaǵan etiledi.</li><li>Tizimge zıyan keltiretuǵın yamasa usıǵan uqsas zıyanlı kodlar jiberiw qadaǵan etiledi.</li><li>Tizimde fayl ashıw arqalı yamasa usıǵan uqsas shparing jolları arqalı máseleni sheshiwge hár qanday háreket qatań qadaǵan etiledi.</li><li>Bir neshe profilde paydalanıw qadaǵan etiledi, anıqlanǵan jaǵdayda barlıq profiller bloklanadı.</li><li>Turnirde AI (ChatGPT, Copilot, Claude, Gemmi hám basqa) botlardan paydalanǵan halda qatnasıw qadaǵan etiledi. Ayrıqsha jaǵdaylar joq hám belgili bir tilde jazılǵan kodtı AI járdeminde basqasına ótkeriw de múmkin emes.</li></ol>',
                    'ru' => '<ol><li>Запрещается обмен кодами и идеями между участниками во время турнира.</li><li>Запрещается отправлять вредоносные коды или аналогичные коды, которые могут нанести ущерб системе.</li><li>Категорически запрещается любая попытка решить проблему, открыв файл в системе или используя аналогичные способы обмана.</li><li>Запрещается использовать несколько профилей; в случае обнаружения, все профили будут заблокированы.</li><li>Запрещается участвовать в турнире, используя ботов с ИИ (ChatGPT, Copilot, Claude, Gemmi и другие). Исключений нет, и вы не можете перенести код, написанный на одном языке, на другой с помощью ИИ.</li></ol>',
                ],
            ],
            [
                'question' => [
                    'uz' => 'Reyting qanday hisoblanadi?',
                    'kaa' => 'Reyting qalay esaplanadı?',
                    'ru' => 'Как рассчитывается рейтинг?',
                ],
                'answer' => [
                    'uz' => '<p>Reyting ikki asosiy ko‘rsatkichga tayanadi:</p><ul><li>Ball (Score): Har bir to‘g‘ri yechilgan masala uchun beriladigan ballar yig‘indisi.</li><li>Jarima (Penalty): Masala yechishga sarflangan vaqt va xato urinishlar uchun beriladigan jarima ballari. Jarima qancha kam bo‘lsa, o‘rningiz shuncha yuqori bo‘ladi. Har bir muvaffaqiyatsiz urinish uchun 10 (o‘n) daqiqalik jarima bali beriladi.</li></ul>',
                    'kaa' => '<p>Reyting eki tiykarǵı kórsetkishke tiykarlanadı:</p><ul><li>Ball (Score): Hár bir durıs sheshilgen másele ushın beriletuǵın ballar qosındısı.</li><li>Jarima (Penalty): Másele sheshiwge jumsalǵan waqıt hám qáte urınıwlar ushın beriletuǵın járiyma balları. Járiyma qansha az bolsa, ornıńız sonsha joqarı boladı. Hár bir sátsiz urınıw ushın 10 (on) minutlıq járiyma balı beriledi.</li></ul>',
                    'ru' => '<p>Рейтинг основан на двух основных показателях:</p><ul><li>Балл (Score): сумма баллов, начисляемых за каждое правильное решение задачи.</li><li>Штраф (Penalty): штрафные баллы, начисляемые за время, затраченное на решение задачи, и за ошибочные попытки. Чем меньше штраф, тем выше ваше положение. За каждую неудачную попытку начисляется штрафное очко в размере 10 (десяти) минут.</li></ul>',
                ],
            ],
        ];
        $i = 1;
        foreach ($faqs as $faq) {
            Faq::create([
                'question' => $faq['question'],
                'answer' => $faq['answer'],
                'order' => $i,
            ]);
            $i++;
        }
    }
}
