<?php


namespace App\Service;


use App\Model\Article;
use Symfony\Component\HttpFoundation\RequestStack;

class Articles
{
    protected $list = [
        [
            'en' => [
                'title' => 'These animals spend their whole lives waiting to have sex, and then they die',
                'body' => 'The humble antechinus has been in the news recently because, well, it has so much sex that 
                it dies. This is not an evolutionary flaw. It is, in fact, a feature of the species.

Male antechinuses (antechinii? antechinae?) spend half their lives having sex for 14 hours a day. 
And it’s not leisurely, loving sex. It’s frantic oh-my-god-I-must-ejaculate-as-quickly-as-possible kind of sex. 
The kind of sex that rapidly depletes their limited supply of sperm and causes their bodies to literally fall apart. 
They lose their fur. They bleed internally. They die before they hit their first birthday.'
            ],
            'ru' => [
                'title' => 'ЛУЧШИЙ ЭЛЕКТРОМОБИЛЬ TESLA MODEL S SIGNATURE PERFOMANCE',
                'body' => 'В обществе пока 
            считают, что электромобиль просто не может быть удобным и быстрым. Но Tesla Model S Signature Perfomance 
            полностью ломает любые стереотипы. Запас хода этого автомобиля 480 км, его максимальная скорость 209 км/ч. 
            Удивляет и разгон машины за 4,4 секунды до 100 км/ч! Полностью заряжается за 5 часов от 220 В. 
Но на особых станциях машину можно зарядить и за 30 минут. Сегодня Tesla Model S - самый безопасный серийным 
автомобиль, который когда либо создавался человеком. 
Также автомобиль был удостоен по всем тестам 5 звездам NCAP. Самое приятное то, что 
все эти плюсы при нулевом выбросе CO2.
'
            ],
        ],
        [
            'en' => [
                'title' => 'This croco-dolphin has it all',
                'body' => 'Most people associate the Jurassic Period with depictions of feathered monsters 
                gallivanting across the surface of Earth, establishing their claim as the dominant creatures of 
                the planet. (And perhaps also Jeff Goldblum’s finest, most shirtless onscreen performance.) 
                But we ought not to forget that the marine world was teeming with its own gargantuan 
                beasts at the time. A 180 million-year-old fossil has led scientists to identify a new 
                species of a marine crocodile possessing a tail fin not unlike modern-day dolphins. 
                The discovery, reported Thursday in the journal PeerJ, ostensibly fills a missing link in the 
                crocodile family’s evolutionary tree, reconciling a gap where they branched out and either 
                continued to evolve into bony-armored creatures with limbs made for walking, or returned to the 
                water to develop flippers and tail fins.'
            ],
            'ru' => [
                'title' => 'БУДУЩЕЕ НАЧАЛОСЬ - PLANTBOOK',
                'body' => 'Пожалуй, на сегодняшний день Plantbook можно назвать самым необыкновенным концептом ноутбука. 

Его авторами являются – корейцы Hyerim Kim и Seunggi Baek. Своим воображением они буквально поразили весь мир технологий! 

У ноутбука Plantbook гибкий дисплей, сенсорная клавиатура, и… он сворачивается в трубочку! Также для его зарядки можно не просто использовать обыкновенную солнечную энергию, но и воду! Невероятно то, что при этом гаджет вдобавок вырабатывает кислород! Чтобы все понять владельцу ноутбука, была создана специальная петелька в виде листика, которая отображает уровень заряда батареи. 

Разработка уже заинтересовала многих инвесторов, так как это первая многообещающая функциональная технология, которая, в первую очередь, не только модная и актуальная, но и максимально рассчитана на заботу о природе и ее экологии. '
            ],
        ],
        [
            'en' => [
                'title' => 'The weirdest things we learned this week: The first celebrity diet, confused albatrosses, and delusions of death',
                'body' => 'What’s the weirdest thing you learned this week? Well, whatever it is, we promise you’d 
                have an even weirder answer if you’d listened to PopSci’s newest podcast. The Weirdest Thing I 
                Learned This Week hits iTunes, Soundcloud, Stitcher, and PocketCasts every Wednesday, and it’s your 
                new favorite source for the weirdest science-adjacent facts, figures, and Wikipedia spirals the 
                editors of Popular Science can muster.

Check out our second episode below, and keep scrolling for more info about the facts contained therein.'
            ],
            'ru' => [
                'title' => 'А ЧТО ПОЛУЧИТ КАЖДЫЙ, ЕСЛИ ВЗЯТЬ И РАЗДЕЛИТЬ ВСЕ ПОРОВНУ?',
                'body' => 'Достаточно интересную статистику предложили исследователи Калифорнийского университета в Беркли. В мире все желают справедливости и единого класса – равенства между людьми. Давайте же посмотрим, что получит каждый, если все поделить по-честному – поровну? 

2 литра нефти в день на одного человека 
177 г шерсти 
21 см железнодорожного полотна 
1018 см автомобильных дорог 
100 бананов 
56,6 кг и картона и бумаги 
36,9 кг мяса 
23,3 г золота 
269 г мыла 
107 кг пшеницы 
808 сигарет в год на 1 человека
1125 г кофе 
229 г молока 
1125 г кофе
4 литра чистого спирта 
2 презерватива 
25,8 кг минеральных удобрений 
5,63 кг газет 

А теперь самое страшное - 738 выброшенных полиэтиленовых пакетов.'
            ],
        ],
    ];

    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getRandom()
    {
        $id = rand(0, count($this->list) - 1);
        return $this->getById($id);
    }

    /**
     * @param $id
     * @return Article|null
     */
    public function getById($id)
    {
        $id = (int)$id;

        $result = null;
        if (array_key_exists($id, $this->list)) {
            $data = $this->list[$id][$this->getLocale()];
            $data['id'] = $id;
            $result = Article::createArticle($data);
        }

        return $result;
    }

    protected function getLocale()
    {
        return $this->requestStack->getMasterRequest()
            ? $this->requestStack->getMasterRequest()->getLocale() : 'en';
    }

    /**
     * @return Article[]
     */
    public function getAll()
    {
        $result = [];
        foreach (array_keys($this->list) as $id) {
            $result[] = $this->getById($id);
        }

        return $result;
    }
}