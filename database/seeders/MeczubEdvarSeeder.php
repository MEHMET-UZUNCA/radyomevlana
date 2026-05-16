<?php

namespace Database\Seeders;

use App\Models\EditorPost;
use Illuminate\Database\Seeder;

class MeczubEdvarSeeder extends Seeder
{
    public function run(): void
    {
        $posts = $this->posts();
        $total = count($posts);

        foreach ($posts as $i => $post) {
            // En yeni tarih = ilk yazı (okuma sırası: 1→21)
            $publishedAt = now()->setTime(21 - $i, 0, 0);

            EditorPost::create([
                'title'        => $post['title'],
                'excerpt'      => $post['excerpt'],
                'content'      => $post['content'],
                'is_published' => true,
                'published_at' => $publishedAt,
            ]);
        }
    }

    private function posts(): array
    {
        return [
            // 1
            [
                'title'   => 'Nefsin Mertebeleri ve Mânâ Yolunun Sırları',
                'excerpt' => 'Bu yol, yalnızca okunan bir bilgi yolu değildir; yaşanan, taşınan, sabırla pişilen bir mânâ yoludur.',
                'content' => '<p>Selâmün aleyküm aziz talebem…</p>
<p>Bu yol, yalnızca okunan bir bilgi yolu değildir; yaşanan, taşınan, sabırla pişilen bir mânâ yoludur. Nefsini tanımayan, kalbinin kapısını bilemez. Kalbinin kapısını bilmeyen de rüyanın, yakazanın, keşfin ve zikrin hakikatini ayırt edemez.</p>
<p>İnsan sandığın gibi yalnız etten, kemikten ve nefesten ibaret değildir. İnsanın içinde katman katman perdeler, merkezler, sırlar ve imtihanlar vardır. Her mertebe bir kapıdır. Her kapının ardında başka bir hâl, başka bir imtihan, başka bir edep vardır.</p>
<p>Evladım, bu yolun başı edep, ortası sabır, sonu ise yokluktur. Kim bu yola "bir şey olmak" için girerse, nefsinin tuzağına düşer. Kim "hiç olmak" için girerse, Allah\'ın izniyle kapılar ona açılır.</p>',
            ],
            // 2
            [
                'title'   => 'Nefs-i Emmâre: Kötülüğü Emreden Nefs',
                'excerpt' => 'Nefsin ilk ve en karanlık mertebesi emmâredir. Bu nefs, kötülüğü yalnızca istemez; ondan zevk de alır.',
                'content' => '<p>Evladım, nefsin ilk ve en karanlık mertebesi emmâredir. Bu nefs, kötülüğü yalnızca istemez; ondan zevk de alır. Kibir, benlik, hırs, şehvet, kıskançlık, cimrilik, kin, intikam ve hiddet bu mertebenin gölgeleridir.</p>
<p>Bu hâlde insan kendini haklı, başkasını kusurlu görür. Hatasını savunur, günahına mazeret bulur, nefsinin sesini hakikat zanneder. Kalp daralır, ruh sıkılır, huzur uzaklaşır. Rüyalar çoğu zaman karışık, korkulu, karanlık ve nefsânî olur.</p>
<p>Bu kapıda ilk ilaç tevbedir. Dil istiğfar eder, kalp "Lâ ilâhe illallah" ile benliği kırmaya başlar. Çünkü bu kelime, yalnızca bir zikir değil; nefsin tahtını yıkan ilâhî bir kılıçtır.</p>
<p>Bil ki bu mertebede büyük hâller aranmaz. Tayy-i mekân, keşif, yakaza beklenmez. Önce nefsin zinciri gevşemelidir. Emmâre kapısında talebeye düşen şey; tevbe, istiğfar, sabır ve mürşid terbiyesine teslimiyettir.</p>',
            ],
            // 3
            [
                'title'   => 'Nefs-i Levvâme: Kendini Kınayan Nefs',
                'excerpt' => 'Levvâme mertebesinde nefs artık uyanmaya başlar. Kötülük yaptığında pişman olur, kendini kınar, tevbe eder.',
                'content' => '<p>Levvâme mertebesinde nefs artık uyanmaya başlar. Kötülük yaptığında pişman olur, kendini kınar, tevbe eder. Fakat henüz tam kuvvet bulamadığı için tekrar düşer. İyilik ile kötülük arasında gider gelir.</p>
<p>Bu hâl kötü değildir evladım. Çünkü pişmanlık, rahmetin kalpteki ilk yankısıdır. İnsan günahından rahatsız oluyorsa, kalbinde hâlâ bir nur kıvılcımı var demektir.</p>
<p>Bu mertebede gizli riya, makam arzusu, kendini beğenme ve çekişme hâlâ bulunabilir. Fakat artık talebe hakkı hak, bâtılı bâtıl görmeye başlar. Hastalığını bilir ama henüz ondan tamamen kurtulamaz.</p>
<p>Levvâme\'nin âlemi berzah gibidir. Uyku ile uyanıklık arasında mânâlar belirmeye başlar. Rüyalar sembolleşir. Bazen uyarılar, bazen ışıklar, bazen mürşid yüzü, bazen ezan ve zikir sesleri görülür ya da işitilir.</p>
<p>Bu makamda talebe zikrini artırır, rabıtasını kuvvetlendirir ve ölümü tefekkür eder. Çünkü ölümü unutanın nefsi güçlenir; ölümü hatırlayanın kalbi yumuşar.</p>',
            ],
            // 4
            [
                'title'   => 'Nefs-i Mülhime: İlham Alan Nefs',
                'excerpt' => 'Cenâb-ı Hak, Şems sûresinde nefse fücurunu ve takvâsını ilham ettiğini bildirir. İşte mülhime mertebesi, kalbin ilhama kabiliyet kazanmaya başladığı mertebedir.',
                'content' => '<p>Cenâb-ı Hak, Şems sûresinde nefse fücurunu ve takvâsını ilham ettiğini bildirir. İşte mülhime mertebesi, kalbin ilhama kabiliyet kazanmaya başladığı mertebedir.</p>
<p>Bu makamda talebe artık haramdan kaçmaya, hayra koşmaya başlar. Hayvanî arzular zayıflar. Kalpte ilim, tevazu, yumuşaklık, kanaat, sabır ve belaya tahammül gibi güzel sıfatlar belirir.</p>
<p>Ruh âleminin rüzgârı esmeye başlar. Bazen rüyalar berraklaşır. Bazen kalbe sözler doğar. Bazen insan, başkasının hâlini sezdiğini zanneder. Bazen içten bir koku, bir ses, bir işaret gelir.</p>
<p>Fakat evladım, en büyük tehlike de burada başlar. Çünkü nefs artık kaba arzularla değil, ince hilelerle saldırır. Talebeye "Sen oldun, sen seçildin, sen gördün, sen bildin" dedirtmek ister.</p>
<p>İşte burada mürşid himmeti şarttır. İlham ile vesvese birbirine karışabilir. Her kalbe gelen söz hakikat değildir. Her görülen şey rahmânî değildir. Mülhime makamındaki talebe sırlara meyleder; ama sırrın ardındaki kemalden perdelenebilir.</p>
<p>Bu sebeple evladım, bu makamda hâl saklanır, rüya hemen yorumlanmaz, keşif iddia edilmez. Mürşide arz edilir, edep ile beklenir.</p>',
            ],
            // 5
            [
                'title'   => 'Nefs-i Mutmainne: Huzura Ermiş Nefs',
                'excerpt' => 'Cenâb-ı Hak, Fecr sûresinde "Ey mutmain olmuş nefs" diye hitap eder. İşte bu mertebe, kalbin ıstıraptan huzura yöneldiği mertebedir.',
                'content' => '<p>Cenâb-ı Hak, Fecr sûresinde "Ey mutmain olmuş nefs" diye hitap eder. İşte bu mertebe, kalbin ıstıraptan huzura yöneldiği mertebedir.</p>
<p>Mutmainne nefis, şek ve şüpheden temizlenmeye başlamıştır. Kötü huylardan arınır, fenalığa arzusu zayıflar. Tevekkül, cömertlik, yumuşaklık, kusurları bağışlama, hamd, şükür, teslimiyet ve rıza hâli belirir.</p>
<p>Bu mertebede kalp zikrullah ile sükûna kavuşur. Talebe artık her şeyi kavga ederek değil, teslim olarak karşılamayı öğrenir. Rüya ile yakaza arasındaki perde incelir. Bazı mânâlar daha açık zuhur eder.</p>
<p>Fakat yine de evladım, hâl amaç değildir. Görmek makam değildir. Asıl ölçü; ahlâkın güzelleşmesi, günahın azalması, kalbin yumuşaması ve nefsin küçülmesidir.</p>
<p>Mutmainne mertebesine erişenler için velâyet kapısı açılır. Ama veli olmak, insanlardan üstün olmak değildir. Bilakis insanlara daha çok merhametle bakmaktır.</p>',
            ],
            // 6
            [
                'title'   => 'Nefs-i Râdıyye: Allah\'tan Razı Olan Nefs',
                'excerpt' => 'Râdıyye mertebesinde kul, Rabbinden gelen her şeye razı olmayı öğrenir. Bela ile sefa, darlık ile genişlik, keder ile sürur onun nazarında aynı kapıya çıkar.',
                'content' => '<p>Râdıyye mertebesinde kul, Rabbinden gelen her şeye razı olmayı öğrenir. Bela ile sefa, darlık ile genişlik, keder ile sürur onun nazarında aynı kapıya çıkar.</p>
<p>Bu hâle gelen talebe şöyle der:</p>
<blockquote><p>"Lütfun da hoş, kahrın da hoş. Senden gelen başım üstüne."</p></blockquote>
<p>Bu söz dilde kolaydır evladım; fakat kalpte tahakkuk etmesi büyük iştir. Çünkü insan nimet gelince razı olur, bela gelince şikâyete başlar. Râdıyye mertebesinde ise şikâyet azalır, teslimiyet derinleşir.</p>
<p>Bu makamda kalp artık "Neden böyle oldu?" demeyi bırakır. "Bunda Rabbimin muradı nedir?" diye bakar. İşte bu bakış, insanı fenâ kapısına yaklaştırır.</p>
<p>Ancak bu mertebede olanlar çoğu zaman kendi kemalleriyle meşguldür. Başkasını irşad vazifesi henüz tam açılmamış olabilir. Çünkü irşad yalnız hâl ile değil, izin ve emanet ile olur.</p>',
            ],
            // 7
            [
                'title'   => 'Nefs-i Mardıyye: Allah\'ın Razı Olduğu Nefs',
                'excerpt' => 'Mardıyye makamı, ariflerin makamıdır. Burada kul yalnız Allah\'tan razı olmakla kalmaz; Allah\'ın razı olduğu bir hâle de erişir.',
                'content' => '<p>Mardıyye makamı, ariflerin makamıdır. Burada kul yalnız Allah\'tan razı olmakla kalmaz; Allah\'ın razı olduğu bir hâle de erişir.</p>
<p>Dışarıdan bakıldığında diğer insanlardan farklı görünmeyebilir. Yer, içer, konuşur, çalışır, insanlar arasında yaşar. Fakat iç âleminde başka bir sır taşır. O artık mânâ âleminden aldığı marifeti, madde âlemine hizmet olarak indirir.</p>
<p>Bu makamda bekâbillâh sırrı tecelli eder. Kul fenâdan sonra bekâya döner. Artık yalnız kendi kurtuluşunu değil, başkalarının kalbine düşecek nuru da düşünür.</p>
<p>Hadis-i kudsîde bildirilen "Ben kulumun işiten kulağı, gören gözü olurum" mânâsı bu mertebede daha derin idrak edilir. Fakat evladım, burada da ölçü izindir. Mürşidinden izin almayan kimse, irşad iddiasına kalkışmaz.</p>
<p>Çünkü sır, ehline emanettir. Emanet ise ehliyetsiz elde ziyan olur.</p>',
            ],
            // 8
            [
                'title'   => 'Nefs-i Kâmile: Seçkin ve Tertemiz Nefs',
                'excerpt' => 'Kâmile mertebesi, Allah dostlarının en seçkinlerine ait yüce bir makamdır. Gavsların, kutupların ve büyük velilerin hâli burada anlaşılır.',
                'content' => '<p>Kâmile mertebesi, Allah dostlarının en seçkinlerine ait yüce bir makamdır. Gavsların, kutupların ve büyük velilerin hâli burada anlaşılır.</p>
<p>Bu mertebede kesrette vahdet, vahdette kesret müşahede edilir. Kul çokluk içinde birliği, birlik içinde çokluğu görür. Artık muradı kendi muradı değildir; Allah\'ın muradına teslim olmuştur.</p>
<p>Onların her hâli ibadet, her nefesi zikir, her bakışı merhamettir. İnsanların kusurlarına takılmazlar. Kırmazlar, incitmezler, küçümsemezler. Çünkü onlar bilirler ki, her kul kendi imtihanının içinde yürümektedir.</p>
<p>Evladım, bu makam anlatılmakla bilinmez. Çünkü burada söz biter, hâl konuşur. İddia susar, hakikat görünür.</p>',
            ],
            // 9
            [
                'title'   => 'Letâiflerin Uyanışı: İç Âlemin Haritası',
                'excerpt' => 'İnsan yalnız görünen bedenden ibaret değildir. İçinde latif merkezler vardır. Bunlar zorla açılmaz; zikir, edep, mürşid nazarı ve sabırla uyanır.',
                'content' => '<p>İnsan yalnız görünen bedenden ibaret değildir. İçinde latif merkezler vardır. Bunlar zorla açılmaz. Zikir, edep, mürşid nazarı ve sabırla uyanır.</p>
<h3>Kalp</h3>
<p>İlk uyanan merkez kalptir. Zikir burada kök salar. İlk huzur, ilk yanma, ilk sızlama burada hissedilir. Kalpte daralma bazen ceza değil, temizliktir. Çünkü içeriye nur girmeye başladığında eski karanlık rahatsız olur.</p>
<h3>Ruh</h3>
<p>Kalp temizlendikçe ruh genişler. İlhamlar burada belirir, aşk burada doğar. Gözyaşı, ferahlık, iç genişliği ve sebepsiz bir muhabbet hâli ruhun uyanış alametlerindendir.</p>
<h3>Sır</h3>
<p>Sır mertebesinde konuşma azalır. İnsan daha az anlatır, daha çok sezer. Hakikat, kalbe kelimesiz iner. Bu yüzden sır ehli çok konuşmaz; çünkü bilir ki fazla söz hâli incitir.</p>
<h3>Hafî</h3>
<p>Hafî merkezinde benlik çözülmeye başlar. Kul artık kendini merkeze koymaz. "Ben yaptım, ben gördüm, ben bildim" sözleri ağır gelir.</p>
<h3>Ahfâ</h3>
<p>Ahfâ en gizli merkezdir. Burada kul yokluğun eşiğine yaklaşır. Söz incelir, nefes sakinleşir, iddia kaybolur. Burada artık maksat görmek değil, Hakk\'ın muradına teslim olmaktır.</p>',
            ],
            // 10
            [
                'title'   => 'Rüya, Yakaza ve Keşif',
                'excerpt' => 'Yol ehlinin en çok aldandığı kapılardan biri rüya ve keşif kapısıdır. Çünkü insan gördüğünü hemen hakikat zanneder.',
                'content' => '<p>Evladım, yol ehlinin en çok aldandığı kapılardan biri rüya ve keşif kapısıdır. Çünkü insan gördüğünü hemen hakikat zanneder. Hâlbuki her görülen doğru değildir.</p>
<h3>Rüya</h3>
<p>Rüyalar üç kısma ayrılır:</p>
<p><strong>Rahmânî rüya</strong> huzur verir, sade ve nettir. Kalbi yumuşatır, tevazuyu artırır.</p>
<p><strong>Nefsânî rüya</strong> günlük düşüncelerin, arzuların ve bastırılmış isteklerin görüntüsüdür. Çoğu zaman insanı önemli hissettirir.</p>
<p><strong>Şeytânî veya vehmî rüya</strong> korku, sıkıntı, vesvese ve karışıklık doğurur.</p>
<p>Altın ölçü şudur: Gördüğün şey seni küçültüyor, tevazuya ve kulluğa çağırıyorsa üzerinde durulabilir. Seni büyütüyor, "Ben özelim" dedirtiyorsa nefsin kokusu vardır.</p>
<h3>Yakaza</h3>
<p>Yakaza, uyanıkken iç âlemden bazı görüntülerin, seslerin veya işaretlerin belirmesi hâlidir. Göz açıktır ama dikkat iç âleme yönelmiştir.</p>
<p>Fakat evladım, yakaza kapısı çok incedir. Burada konuşma, diyalog kurma, peşine düşme. Geleni çağırma, geleni kovma. Sadece şahit ol ve geç.</p>
<p>Çünkü yakazada üç kaynak olabilir: rahmânî işaret, nefsânî hayal veya vehmî karışıklık. Bunu ayırt etmeden hüküm vermek talebeyi yoldan çıkarabilir.</p>
<h3>Keşif</h3>
<p>Keşif, perdenin bir an aralanmasıdır. Kalp gözüyle bir mânâyı sezmek, bir hakikati içten bilmek veya bir işareti fark etmektir.</p>
<p>Ama keşfin de ölçüsü vardır. Eğer keşif seni edebe, ahlâka, tevazuya ve zikre götürüyorsa hayra işarettir. Eğer seni iddiaya, gösterişe ve üstünlük hissine sürüklüyorsa orada nefs devreye girmiştir.</p>
<p>Unutma evladım: Keşif değil, edep önemlidir. Görüntü değil, dönüşüm önemlidir. Hâl değil, ahlâk önemlidir.</p>',
            ],
            // 11
            [
                'title'   => 'Tayy-i Mekân ve Manevî Hareket',
                'excerpt' => 'Tayy-i mekân çok yanlış anlaşılan bir sırdır. Halk bunu çoğu zaman gösteri gibi düşünür. Hâlbuki bu hâller yolun hedefi değil, bazen yol üzerinde görülen işaretlerdir.',
                'content' => '<p>Tayy-i mekân çok yanlış anlaşılan bir sırdır. Halk bunu çoğu zaman gösteri gibi düşünür. Hâlbuki bu hâller yolun hedefi değil, bazen yol üzerinde görülen işaretlerdir.</p>
<p><strong>İlk hâller</strong> rüyada uzak yerlere gitmek, kendini başka mekânlarda görmek veya mânâ âleminde dolaşır gibi hissetmektir.</p>
<p><strong>Orta hâllerde</strong> yakaza sırasında yer kayması, zamanın yavaşlaması veya mekân algısının incelmesi gibi durumlar yaşanabilir.</p>
<p><strong>İleri hâllerde</strong> kul, mânâ âleminde daha derin hareketler sezebilir. Fakat evladım, bunların peşine düşen kaybolur. Çünkü nefs olağanüstü hâlleri sever. Hakikat ise gösteriyi sevmez.</p>
<p>Tayy-i mekân hedef yapılırsa nefs devreye girer. Hedef Allah\'ın rızası olursa, gerekirse hâl gelir; gerekmezse gelmez. Talebeye düşen hâl istemek değil, kulluğa devam etmektir.</p>',
            ],
            // 12
            [
                'title'   => 'Mürşid Yolu ve Zikir Sırrı',
                'excerpt' => 'Bu yol tek başına yürünmez. İnsan kendi nefsini her zaman göremez. Nefs bazen ilim kisvesine girer, bazen ilham gibi konuşur, bazen rüya ile kandırır.',
                'content' => '<p>Evladım, bu yol tek başına yürünmez. İnsan kendi nefsini her zaman göremez. Nefs bazen ilim kisvesine girer, bazen ilham gibi konuşur, bazen rüya ile kandırır.</p>
<p>Mürşid talebeyi yalnız sözle eğitmez. Bazen bakışıyla, bazen susuşuyla, bazen uzaklaştırmasıyla, bazen kalpte oluşturduğu sıkıntıyla terbiye eder. Bunların hepsi ceza değildir; bazen en derin temizlik, en sessiz terbiyedir.</p>
<p>Zikir de her talebede aynı şekilde açılmaz. Başlangıçta dil zikri nefsi kırar. Sonra kalp zikri başlar. Daha sonra zikir nefesle akar. Bir vakit gelir, talebe zikri yaptığını sanmaz; zikir onu yapar.</p>
<p>Fakat burada çok önemli bir edep vardır: Talebe kendisine verilen dersi gelişi güzel başkalarıyla paylaşmaz. Çünkü zikir, yalnız kelime değildir; hâl, izin, nisbet ve ölçüdür.</p>
<p>Zikir sayıyla başlar, devamlılıkla derinleşir, teslimiyetle meyve verir. Çok çekmek tek başına yetmez. Zikir ahlâkı değiştirmiyorsa, kalbi yumuşatmıyorsa, nefsi küçültmüyorsa, orada eksik bir edep vardır.</p>',
            ],
            // 13
            [
                'title'   => 'Mânâ Ameliyatı',
                'excerpt' => 'Mânâ ameliyatı, kalbin kirlerinden arınması, letâiflerin hareketlenmesi, nefsin bağlarının gevşemesi ve talebeye hâl geçmesidir.',
                'content' => '<p>Talebem, bu kısım izinsiz konuşulacak bir alan değildir; ama işaret kadar söyleyelim.</p>
<p>Mânâ ameliyatı, kalbin kirlerinden arınması, letâiflerin hareketlenmesi, nefsin bağlarının gevşemesi ve talebeye hâl geçmesidir. Bazen kalpte yanma olur, bazen titreme, bazen ağlama, bazen daralma, bazen de sebepsiz bir hafiflik belirir.</p>
<p>Bunlar her zaman aynı şekilde yaşanmaz. Her ağlama hâl değildir, her titreme işaret değildir. Ölçü yine aynıdır: Bu hâl seni Allah\'a yaklaştırıyor mu? Günahı azaltıyor mu? Kalbini yumuşatıyor mu? Nefsini küçültüyor mu?</p>
<p>Eğer cevap evetse, sus ve şükret. Eğer seni iddiaya götürüyorsa, hemen kendini toparla.</p>
<p>Çünkü izinsiz tasarruf iddiası tehlikelidir. Taklit eden yanılır, kendinden konuşan sapar. Mânâ yolu emanet yoludur.</p>',
            ],
            // 14
            [
                'title'   => 'Yolun Büyük Tehlikeleri',
                'excerpt' => 'Yolun tehlikelerini bilmeden yürüyen kişi her ışığı güneş zanneder.',
                'content' => '<p>Aziz talebem, yolun tehlikelerini bilmeden yürüyen kişi her ışığı güneş zanneder.</p>
<p><strong>En büyük düşman gizli kibirdir.</strong> "Ben gördüm, ben oldum, ben seçildim" cümleleri nefsin en tatlı zehridir.</p>
<p><strong>İkinci tehlike rüya ve keşfe aldanmaktır.</strong> Her gördüğünü hakikat sanan, hayalin peşine düşer.</p>
<p><strong>Üçüncü tehlike mürşidden kopmaktır.</strong> İnsan rehbersiz kaldığında hangi sesin rahmânî, hangi sesin nefsânî olduğunu ayırt etmekte zorlanır.</p>
<p><strong>Dördüncü tehlike güç aramaktır.</strong> Tayy-i mekân, keşif, yakaza, hâl, tesir ve tasarruf isteyen kişi çoğu zaman Hakk\'ı değil, kendi nefsinin saltanatını arıyordur.</p>
<p><strong>Beşinci tehlike sırrı açmaktır.</strong> Evladım, gördüğünü herkese anlatma. Hissettiğini pazar yerine çıkarma. Hâl anlatıldıkça incelir, sır yayıldıkça bereketi çekilir.</p>
<p>Bu yolun güvenli yürüyüşü şudur: Görsen de görmemiş gibi ol. Bilsen de bilmez gibi ol. Yaşasan da sus. Mürşidine arz et, zikrine devam et, günlük hayatını terk etme, insanlardan kopma.</p>',
            ],
            // 15
            [
                'title'   => '40 Kilit ve 40 Anahtar',
                'excerpt' => 'Her kilit bir perdedir. Her anahtar bir zikirdir. Fakat unutma: Anahtar edepsiz elde kapı açmaz.',
                'content' => '<p>Evladım, her kilit bir perdedir. Her anahtar bir zikirdir. Fakat unutma: Anahtar edepsiz elde kapı açmaz.</p>
<h3>Birinci Kapılar: Nefsi Kırmak İçin</h3>
<ul>
<li>Kibir için <strong>Yâ Zelîl</strong></li>
<li>Öfke için <strong>Yâ Halîm</strong></li>
<li>Şehvet için <strong>Yâ Tâhir</strong></li>
<li>Hırs için <strong>Yâ Ganî</strong></li>
<li>Haset için <strong>Yâ Adl</strong></li>
<li>Cimrilik için <strong>Yâ Kerîm</strong></li>
<li>Gurur için <strong>Yâ Hakîm</strong></li>
<li>Gaflet için <strong>Yâ Hayy</strong></li>
<li>Vesvese için <strong>Yâ Selâm</strong></li>
<li>Tembellik için <strong>Yâ Kaviyy</strong></li>
</ul>
<h3>İkinci Kapılar: Kalbi Temizlemek İçin</h3>
<ul>
<li>Kalp katılığına <strong>Yâ Latîf</strong></li>
<li>Riyaya <strong>Yâ Hakk</strong></li>
<li>Şüpheye <strong>Yâ Yakîn</strong></li>
<li>Korkuya <strong>Yâ Emîn</strong></li>
<li>Ümitsizliğe <strong>Yâ Rahmân</strong></li>
<li>Dağınıklığa <strong>Yâ Câmi</strong></li>
<li>İç sıkıntıya <strong>Yâ Fettâh</strong></li>
<li>Nefs sevgisine <strong>Yâ Vedûd</strong></li>
<li>Dünya bağına <strong>Yâ Zâhid</strong></li>
<li>İnada <strong>Yâ Reşîd</strong></li>
</ul>
<h3>Üçüncü Kapılar: Ruhun Açılması İçin</h3>
<ul>
<li>Perdeler için <strong>Yâ Nûr</strong></li>
<li>Manevî körlük için <strong>Yâ Basîr</strong></li>
<li>İşitmeyiş için <strong>Yâ Semî</strong></li>
<li>Hikmetsizlik için <strong>Yâ Alîm</strong></li>
<li>Sabırsızlık için <strong>Yâ Sabûr</strong></li>
<li>Kabz hâli için <strong>Yâ Bâsıt</strong></li>
<li>Daralma için <strong>Yâ Şâfî</strong></li>
<li>Sertlik için <strong>Yâ Raûf</strong></li>
<li>Ayrılık hissi için <strong>Yâ Vâhid</strong></li>
<li>Hicap için <strong>Yâ Zâhir</strong> ve <strong>Yâ Bâtın</strong></li>
</ul>
<h3>Son Kapılar: Sır Kapıları</h3>
<ul>
<li>Benlik — <strong>Lâ ilâhe illallah</strong> ile kırılır</li>
<li>Ayrılık — <strong>Allah</strong> ismiyle erir</li>
<li>İkilik — <strong>Hû</strong> ile incelir</li>
<li>Perdeli idrak — <strong>Hak</strong> ile açılır</li>
<li>Nefs kalıntısı — <strong>Hayy</strong> ile dirilir</li>
<li>Zaman algısı — <strong>Kayyûm</strong> ile çözülür</li>
<li>Mekân bağı — <strong>Kuddûs</strong> ile temizlenir</li>
<li>Varlık hissi — <strong>Sübhânallah</strong> ile arınır</li>
<li>Kendilik — <strong>Estağfirullah</strong> ile söner</li>
<li>Yokluk kapısı — sessizlikle açılır</li>
</ul>
<p>Burada artık zikir seni zikreder.</p>',
            ],
            // 16
            [
                'title'   => 'Sohbetlik Mânâ Atlası',
                'excerpt' => 'Mânâ yolunu bazen uzun kitaplar anlatamaz da bir cümle kalbe yıldırım gibi iner.',
                'content' => '<p>Evladım, mânâ yolunu bazen uzun kitaplar anlatamaz da bir cümle kalbe yıldırım gibi iner.</p>
<ul>
<li>Bu yol, arayanın değil, arananın yoludur.</li>
<li>Kalbin daralıyorsa, kapı zorlanıyordur.</li>
<li>Zikir dildeyse sestir, kalpteyse ateştir.</li>
<li>Nefs konuşur, ruh susar.</li>
<li>Her gördüğün hakikat değildir.</li>
<li>Günah sonrası pişmanlık rahmettir.</li>
<li>Düşmek değil, düşmeye razı olmak tehlikelidir.</li>
<li>Kendini beğenmek gizli zehirdir.</li>
<li>İlham imtihandır, rüya tuzaktır, yakaza sınavdır.</li>
<li>Sır, susana verilir. Konuşan kaybeder, dinleyen kazanır.</li>
<li>Edep kapıyı açar.</li>
<li>Teslimiyet, "neden" sorusunun ölmesidir.</li>
<li>Yalnızlık ağır gelmiyorsa, kalp içe dönmeye başlamıştır.</li>
<li>Görmek azalır, bilmek derinleşir.</li>
<li>Bilmek azalır, olmak başlar.</li>
<li>Olmak da biter, yokluk kalır.</li>
</ul>
<p>Ve hakikatin en sade sözü şudur:</p>
<blockquote><p>Sen susarsan, hakikat konuşur. Sen yok olursan, O görünür.</p></blockquote>',
            ],
            // 17
            [
                'title'   => 'Kıssalarla Yolun İncelikleri',
                'excerpt' => 'Bir talebe kapıya geldi ve "Beni alın" dedi. İçeriden ses geldi: "Sen varken alamayız."',
                'content' => '<p><em>Bir talebe kapıya geldi ve "Beni alın" dedi. İçeriden ses geldi: "Sen varken alamayız." Talebe gitti, yıllarca nefsini terbiye etti. Sonra döndü ve "Ben yokum" dedi. Kapı açıldı.</em></p>
<p><em>Bir talebe, "Çok zikir ediyorum" dedi. Mürşid cevap verdi: "Zikir seni değiştirmiyorsa, sen zikretmiyorsun."</em></p>
<p><em>Bir talebe, "Rüyamda uçtum" dedi. Mürşid sordu: "Kanatların var mı?" Talebe sustu. Mürşid dedi ki: "O hâlde uçtuğunu değil, nefsinin ne istediğini düşün."</em></p>
<p><em>Bir talebe, "Kalbim yanıyor" dedi. Mürşid buyurdu: "Temizlik başladı."</em></p>
<p><em>Bir talebe, "Kalbime söz geliyor" dedi. Mürşid sordu: "Onu söyleyen kim?" Çünkü her gelen söz ilham değildir; bazısı hırsız gibi gelir.</em></p>
<p><em>Bir talebe, "Nefsimi yenemedim" dedi. Mürşid dedi ki: "Onu yenmeye çalışma, önce beslemeyi bırak."</em></p>
<p><em>Bir talebe, "Yalnız kaldım" dedi. Mürşid tebessüm etti: "Kalabalığın fazlalığından kurtuldun."</em></p>
<p><em>Bir talebe, "Ne zaman olacak?" dedi. Mürşid cevap verdi: "Bu soru oldukça olmaz."</em></p>
<p>Evladım, acele eden kaybeder. Bekleyen pişer. Gören susar. Konuşan kaçırır. Edep yükseltir, sabır büyütür, zikir arındırır.</p>',
            ],
            // 18
            [
                'title'   => 'İlham, Keşif ve Vehim Ayrımı',
                'excerpt' => 'İlham, keşif ve vehim — en çok karıştırılan üç kapı.',
                'content' => '<p>Talebem, bu üçü en çok karıştırılan kapıdır.</p>
<p><strong>İlham</strong> kalbe sessizce doğar. Zorlama yoktur. Huzur, sadelik ve netlik bırakır.</p>
<p><strong>Keşif</strong> perde aralanmasıdır. Görme veya bilme olur. Fakat gerçek keşifte denge vardır; insanı sarsıp kibre düşürmez.</p>
<p><strong>Vehim</strong> ise çoğu zaman zorlamayla başlar. İnsan bir şeyi düşünür, büyütür, sonra onu gerçek zanneder. Sonunda karışıklık, huzursuzluk ve dağınıklık bırakır.</p>
<p>Ayırt etmenin yolu şudur: Gelen şey seni tevazuya mı götürüyor, yoksa büyütüyor mu? Kalbini yumuşatıyor mu, yoksa seni iddiaya mı sürüklüyor? Zikrine kuvvet mi veriyor, yoksa seni gösterişe mi çekiyor?</p>
<p>Ve en önemlisi: Mürşidine arz et. Çünkü insan kendi hâlinin hakemliğini her zaman doğru yapamaz.</p>',
            ],
            // 19
            [
                'title'   => 'Zikirde İleri Disiplin',
                'excerpt' => 'Zikir sayıyla başlar ama derinlikle ilerler. Her seviyenin kendine has hâli vardır.',
                'content' => '<p>Zikir sayıyla başlar ama derinlikle ilerler.</p>
<p><strong>İlk seviye dil zikridir.</strong> Ses vardır, tekrar vardır, nefsin kaba tarafı kırılmaya başlar.</p>
<p><strong>İkinci seviye kalp zikridir.</strong> Ses azalır, iç tekrar başlar. Kalp ısınır, iç âlem hareketlenir.</p>
<p><strong>Üçüncü seviye nefes zikridir.</strong> Zikir nefesle akar. Talebe artık zikri dışarıdan yapmaz; içten yaşar.</p>
<p><strong>Dördüncü seviye hâl zikridir.</strong> Zikir kendiliğinden olur. Talebe sadece şahit olur.</p>
<p><strong>Beşinci seviye fenâdır.</strong> Zikir de kaybolur, zikreden de kaybolur. Geriye yalnız zikredilenin mânâsı kalır.</p>
<p>Fakat evladım, sayı tek başına kapı açmaz. Devamlılık, ihlâs, edep ve teslimiyet olmazsa çok tekrar bile kabukta kalır.</p>',
            ],
            // 20
            [
                'title'   => 'Hâlden Hâle Geçişin Gerçek İşaretleri',
                'excerpt' => 'İnsanlar genellikle yanlış işaretlere bakar. Rüya, görüntü, farklı hisler… Hâlbuki bunlar ölçü değildir.',
                'content' => '<p>İnsanlar genellikle yanlış işaretlere bakar. Rüya çoğaldı mı, görüntü arttı mı, farklı hisler geldi mi diye merak ederler. Hâlbuki bunlar ölçü değildir.</p>
<p>Gerçek ilerlemenin işaretleri daha sadedir:</p>
<ul>
<li>Günah azalır.</li>
<li>Kalp yumuşar.</li>
<li>Daha az kırarsın.</li>
<li>Daha çok affedersin.</li>
<li>Ego zayıflar.</li>
<li>Haklı çıkma ihtiyacı azalır.</li>
<li>Sessizlik artar.</li>
<li>Sabır derinleşir.</li>
<li>Yalnızlık ağır gelmez.</li>
<li>Gösterme isteği kaybolur.</li>
</ul>
<p>İşte en büyük işaret budur: İnsan hâlini göstermek istemiyorsa, kalbinde bir edep uyanmış demektir.</p>',
            ],
            // 21
            [
                'title'   => 'Son Kapı: Yokluk',
                'excerpt' => 'Bu yolun sonunda rüya kalmaz. Keşif kalmaz. Hâl kalmaz. Sadece kulluk kalır, sadece teslimiyet kalır.',
                'content' => '<p>Ey talebem…</p>
<p>Bu yolun sonunda rüya kalmaz. Keşif kalmaz. Hâl kalmaz. "Ben gördüm, ben bildim, ben ulaştım" iddiası kalmaz.</p>
<p>Sadece kulluk kalır. Sadece teslimiyet kalır. Sadece Allah\'ın muradına razı olmak kalır.</p>
<p>Bu yol sana bir şey kazandırmaz; senden her şeyi alır. Kibrini alır, iddianı alır, benliğini alır, sahiplik duygunu alır. Eğer razıysan devam et.</p>
<p>Çünkü bu yolun başı zikir, ortası sabır, sonu hiçliktir.</p>
<ul>
<li>Az konuş.</li>
<li>Çok zikret.</li>
<li>Nefsini suçla.</li>
<li>Kimseyi küçük görme.</li>
<li>Gördüğünü sakla.</li>
<li>Hâlini mürşidine arz et.</li>
<li>Yolda kal, yoldan çıkma.</li>
<li>Kapıya değil, kapının sahibine yönel.</li>
</ul>
<p>Allah\'ım, nefsimizi tezkiye eyle. Kalplerimizi mutmain kıl. Bizi rızana razı olanlardan, rızana erenlerden eyle. Bize edep, sabır, teslimiyet ve istikamet nasip eyle.</p>
<p>Hakk\'ın rızasına erelim ey can… Allah bizi rahmet kapısının içinde olan kullarından eylesin.</p>
<p><em>Âmin.</em></p>',
            ],
        ];
    }
}
