<?php 
return [
    'deposit' => [
        'name' => '[:ja]デポジット[:en]Deposit[:vi]Đặt cọc[:]',
        'group' => 'basic',
        'type' => 'single',                
        'values' => [
            '1' => '[:ja]無し[:en]Non[:vi]Không [:]',
            '2' => '[:ja]× 1[:en]× 1[:vi]× 1[:]',
            '3' => '[:ja]× 2[:en]× 2[:vi]× 2[:]',
            '4' => '[:ja]× 3[:en]× 3[:vi]× 3[:]',
            '5' => '[:ja]× 4[:en]× 4[:vi]× 4[:]',
            '6' => '[:ja]× 5[:en]× 5[:vi]× 5[:]',
            '7' => '[:ja]× 6[:en]× 6[:vi]× 6[:]',
            '8' => '[:ja]× 7[:en]× 7[:vi]× 7[:]',
            '9' => '[:ja]× 12[:en]× 12[:vi]× 12[:]',
            
        ]
                    
    ],
    'city' => [
        'name' => '[:ja]都市名[:en]City[:vi]Thành phố[:]',
        'group' => 'basic',
        'type' => 'single',                
        'values' => [
            '1' => '[:ja]ホーチミン市[:en]Ho Chi Minh City[:vi]Hồ Chí Minh[:]',
            '2' => '[:ja]ハノイ市[:en]Hanoi City[:vi]Hà Nội[:]',
            
        ]
                    
    ],
    'area' => [
        'name' => '[:ja]エリア[:en]Area[:vi]Khu Vực[:]',
        'group' => 'basic',
        'type' => 'single',                
        'values' => [
            '1' => '[:ja]１区[:en]District 1[:vi]Quận 1[:]',
            '2' => '[:ja]２区[:en]District 2[:vi]Quận 2[:]',
            '3' => '[:ja]３区[:en]District 3[:vi]Quận 3[:]',
            '4' => '[:ja]４区[:en]District 4[:vi]Quận 4[:]',
            '5' => '[:ja]５区[:en]District 5[:vi]Quận 5[:]',
            '6' => '[:ja]７区[:en]District 7[:vi]Quận 7[:]',
            '7' => '[:ja]10区[:en]District 10[:vi]Quận 10[:]',
            '8' => '[:ja]ビンタン区[:en]Binh Thanh[:vi]Bình Thạnh[:]',
            '9' => '[:ja]フーニャン区[:en]Phu Nhuan[:vi]Phú Nhuận[:]',
            '10' => '[:ja]タンビン区[:en]Tan Binh[:vi]Tân Bình[:]',
            '11' => '[:ja]その他エリア[:en]Other Area[:vi]Quận khác[:]',
            
        ]
                    
    ],
    'size' => [
        'name' => '[:ja]面積[:en]Size[:vi]Diện tích[:]',
        'group' => 'basic',
        'type' => 'text',                'unit' => 'm²',
        'values' => [
<<<<<<< HEAD
            '93' => '[:ja]100㎡[:en]100㎡[:vi]100㎡[:]',
            '94' => '[:ja]147㎡[:en]147㎡[:vi]147㎡[:]',
            '95' => '[:ja]91㎡[:en]91㎡[:vi]91㎡[:]',
            '97' => '[:ja]342㎡[:en]342㎡[:vi]342㎡[:]',
            '99' => '[:ja]91㎡[:en]91㎡[:vi]91㎡[:]',
            '103' => '[:ja]600㎡[:en]600㎡[:vi]600㎡[:]',
            '104' => '[:ja]210㎡[:en]210㎡[:vi]210㎡[:]',
            '105' => '[:ja]204㎡[:en]204㎡[:vi]204㎡[:]',
            '107' => '[:ja]76㎡[:en]76㎡[:vi]76㎡[:]',
            '108' => '[:ja]76㎡[:en]76㎡[:vi]76㎡[:]',
            '109' => '[:ja]60㎡[:en]60㎡[:vi]60㎡[:]',
            '111' => '[:ja]700㎡[:en]700㎡[:vi]700㎡[:]',
            '112' => '[:ja]1200㎡[:en]1,200㎡[:vi]1,200㎡[:]',
            '114' => '[:ja]200㎡[:en]200㎡[:vi]200㎡[:]',
            '115' => '[:ja]300㎡[:en]300㎡[:vi]300㎡[:]',
            '116' => '[:ja]340㎡[:en]340㎡[:vi]340㎡[:]',
            '117' => '[:ja]255㎡[:en]255㎡[:vi]255㎡[:]',
            '118' => '[:ja]235㎡[:en]235㎡[:vi]235㎡[:]',
            '119' => '[:ja]58㎡[:en]58㎡[:vi]58㎡[:]',
            '121' => '[:ja]86㎡[:en]86㎡[:vi]86㎡[:]',
            '122' => '[:ja]76㎡[:en]76㎡[:vi]76㎡[:]',
            '123' => '[:ja]55㎡[:en]55㎡[:vi]55㎡[:]',
            '124' => '[:ja]85㎡[:en]85㎡[:vi]85㎡[:]',
            '125' => '[:ja]45㎡[:en]45㎡[:vi]45㎡[:]',
            '127' => '[:ja]620㎡[:en]620㎡[:vi]620㎡[:]',
            '128' => '[:ja]130㎡[:en]130㎡[:vi]130㎡[:]',
            '129' => '[:ja]109㎡[:en]109㎡[:vi]109㎡[:]',
            '131' => '[:ja]130㎡[:en]130㎡[:vi]130㎡[:]',
            '133' => '[:ja]1200㎡[:en]1,200㎡[:vi]1,200㎡[:]',
            '135' => '[:ja]350㎡[:en]350㎡[:vi]350㎡[:]',
            '136' => '[:ja]500㎡[:en]500㎡[:vi]500㎡[:]',
            '137' => '[:ja]129㎡[:en]129㎡[:vi]129㎡[:]',
            '138' => '[:ja]103㎡[:en]103㎡[:vi]103㎡[:]',
            '140' => '[:ja]400㎡[:en]400㎡[:vi]400㎡[:]',
            '141' => '[:ja]2,000㎡[:en]2,000㎡[:vi]2,000㎡[:]',
            '142' => '[:ja]320㎡[:en]320㎡[:vi]320㎡[:]',
            '143' => '[:ja]450㎡[:en]450㎡[:vi]450㎡[:]',
            '146' => '[:ja]525㎡[:en]525㎡[:vi]525㎡[:]',
            '148' => '[:ja]167㎡[:en]167㎡[:vi]167㎡[:]',
            '149' => '[:ja]167㎡[:en]167㎡[:vi]167㎡[:]',
            '150' => '[:ja]167㎡[:en]167㎡[:vi]167㎡[:]',
            '151' => '[:ja]200㎡[:en]200㎡[:vi]200㎡[:]',
            '152' => '[:ja]140㎡[:en]140㎡[:vi]140㎡[:]',
            '154' => '[:ja]206㎡[:en]206㎡[:vi]206㎡[:]',
            '155' => '[:ja]700㎡[:en]700㎡[:vi]700㎡[:]',
            '156' => '[:ja]240㎡[:en]240㎡[:vi]240㎡[:]',
            '157' => '[:ja]240㎡[:en]240㎡[:vi]240㎡[:]',
            '158' => '[:ja]80㎡[:en]80㎡[:vi]80㎡[:]',
            '160' => '[:ja]150㎡[:en]150㎡[:vi]150㎡[:]',
            '161' => '[:ja]525㎡[:en]525㎡[:vi]525㎡[:]',
            '162' => '[:ja]500㎡[:en]500㎡[:vi]500㎡[:]',
            '163' => '[:ja]110㎡[:en]110㎡[:vi]110㎡[:]',
            '166' => '[:ja]54㎡[:en]54㎡[:vi]54㎡[:]',
            '168' => '[:ja]1800㎡[:en]1,800㎡[:vi]1,800㎡[:]',
            '169' => '[:ja]800㎡[:en]800㎡[:vi]800㎡[:]',
            '170' => '[:ja]110㎡[:en]110㎡[:vi]110㎡[:]',
            '171' => '[:ja]56㎡[:en]56㎡[:vi]56㎡[:]',
            '172' => '[:ja]98㎡[:en]98㎡[:vi]98㎡[:]',
            '174' => '[:ja]120㎡[:en]120㎡[:vi]120㎡[:]',
            '175' => '[:ja]177㎡[:en]177㎡[:vi]177㎡[:]',
            '177' => '[:ja]145㎡[:en]145㎡[:vi]145㎡[:]',
            '178' => '[:ja]145㎡[:en]145㎡[:vi]145㎡[:]',
            '179' => '[:ja]158㎡[:en]158㎡[:vi]158㎡[:]',
            '181' => '[:ja]158㎡[:en]158㎡[:vi]158㎡[:]',
            '182' => '[:ja]152㎡[:en]152㎡[:vi]152㎡[:]',
            '186' => '[:ja]195㎡[:en]195㎡[:vi]195㎡[:]',
            '188' => '[:ja]135㎡[:en]135㎡[:vi]135㎡[:]',
            '189' => '[:ja]154㎡[:en]154㎡[:vi]154㎡[:]',
            '191' => '[:ja]154㎡[:en]154㎡[:vi]154㎡[:]',
            '192' => '[:ja]145㎡[:en]145㎡[:vi]145㎡[:]',
            '193' => '[:ja]850㎡[:en]850㎡[:vi]850㎡[:]',
            '248' => '[:ja]350㎡[:en]350㎡[:vi]350㎡[:]',
            '249' => '[:ja]72㎡[:en]72㎡[:vi]72㎡[:]',
            '250' => '[:ja]250㎡[:en]250㎡[:vi]250㎡[:]',
            '251' => '[:ja]56㎡[:en]56㎡[:vi]56㎡[:]',
            '252' => '[:ja]67㎡[:en]67㎡[:vi]67㎡[:]',
            '255' => '[:ja]185㎡[:en]185㎡[:vi]185㎡[:]',
            '257' => '[:ja]600㎡[:en]600㎡[:vi]600㎡[:]',
            '270' => '[:ja]101㎡[:en]101㎡[:vi]101㎡[:]',
            '271' => '[:ja]65㎡[:en]65㎡[:vi]65㎡[:]',
            '272' => '[:ja]48㎡[:en]48㎡[:vi]48㎡[:]',
            '274' => '[:ja]56㎡[:en]56㎡[:vi]56㎡[:]',
            '275' => '[:ja]45㎡[:en]45㎡[:vi]45㎡[:]',
            '276' => '[:ja]52㎡[:en]52㎡[:vi]52㎡[:]',
            '277' => '[:ja]75㎡[:en]75㎡[:vi]75㎡[:]',
            '278' => '[:ja]250㎡[:en]250㎡[:vi]250㎡[:]',
            '279' => '[:ja]700㎡[:en]700㎡[:vi]700㎡[:]',
            '280' => '[:ja]800㎡[:en]800㎡[:vi]800㎡[:]',
            '281' => '[:ja]156㎡[:en]156㎡[:vi]156㎡[:]',
            '282' => '[:ja]240㎡[:en]240㎡[:vi]240㎡[:]',
            '285' => '[:ja]90㎡[:en]90㎡[:vi]90㎡[:]',
            '286' => '[:ja]38㎡[:en]38㎡[:vi]38㎡[:]',
            '287' => '[:ja]52㎡[:en]52㎡[:vi]52㎡[:]',
            '288' => '[:ja]38㎡[:en]38㎡[:vi]38㎡[:]',
            '289' => '[:ja]48㎡[:en]48㎡[:vi]48㎡[:]',
            '291' => '[:ja]137㎡[:en]137㎡[:vi]137㎡[:]',
            '292' => '[:ja]261㎡[:en]261㎡[:vi]261㎡[:]',
            '293' => '[:ja]80㎡[:en]80㎡[:vi]80㎡[:]',
            '294' => '[:ja]200㎡[:en]200㎡[:vi]200㎡[:]',
            '295' => '[:ja]50㎡[:en]50㎡[:vi]50㎡[:]',
            '296' => '[:ja]385㎡[:en]385㎡[:vi]385㎡[:]',
            '299' => '[:ja]120㎡[:en]120㎡[:vi]120㎡[:]',
            '300' => '[:ja]700㎡[:en]700㎡[:vi]700㎡[:]',
            '301' => '[:ja]400㎡[:en]400㎡[:vi]400㎡[:]',
            '302' => '[:ja]137㎡[:en]137㎡[:vi]137㎡[:]',
            '303' => '[:ja]550㎡[:en]550㎡[:vi]550㎡[:]',
            '304' => '[:ja]114㎡[:en]114㎡[:vi]114㎡[:]',
            '306' => '[:ja]114㎡[:en]114㎡[:vi]114㎡[:]',
            '307' => '[:ja]52㎡[:en]52㎡[:vi]52㎡[:]',
            '308' => '[:ja]160㎡[:en]160㎡[:vi]160㎡[:]',
            '309' => '[:ja]165㎡[:en]165v[:vi]165㎡[:]',
            '310' => '[:ja]220㎡[:en]220㎡[:vi]220㎡[:]',
            '311' => '[:ja]240㎡[:en]240㎡[:vi]240㎡[:]',
            '312' => '[:ja]45㎡[:en]45㎡[:vi]45㎡[:]',
            '313' => '[:ja]40㎡[:en]40㎡[:vi]40㎡[:]',
            '314' => '[:ja]125㎡[:en]125㎡[:vi]125㎡[:]',
            '315' => '[:ja]200㎡[:en]200㎡[:vi]200㎡[:]',
            '316' => '[:ja]47㎡[:en]47㎡[:vi]47㎡[:]',
            '317' => '[:ja]45㎡[:en]45㎡[:vi]45㎡[:]',
            '318' => '[:ja]750㎡[:en]750㎡[:vi]750㎡[:]',
            '320' => '[:ja]40㎡[:en]40㎡[:vi]40㎡[:]',
            '321' => '[:ja]40㎡[:en]40㎡[:vi]40㎡[:]',
            '322' => '[:ja]270㎡[:en]270㎡[:vi]270㎡[:]',
            '323' => '[:ja]45㎡[:en]45㎡[:vi]45㎡[:]',
            '324' => '[:ja]150㎡[:en]150m2[:vi]150㎡[:]',
            '325' => '[:ja]40㎡[:en]40㎡[:vi]40㎡[:]',
            '326' => '[:ja]300㎡[:en]300㎡[:vi]300㎡[:]',
            '327' => '[:ja]55㎡[:en]55㎡[:vi]55㎡[:]',
            '328' => '[:ja]45㎡[:en]45㎡[:vi]45㎡[:]',
            '329' => '[:ja]106㎡[:en]106㎡[:vi]106㎡[:]',
            '330' => '[:ja]400㎡[:en]400㎡[:vi]400㎡[:]',
            '332' => '[:ja]1,400㎡[:en]1,400㎡[:vi]1,400㎡[:]',
            '333' => '[:ja]76㎡[:en]76㎡[:vi]76㎡[:]',
            '334' => '[:ja]60㎡[:en]60㎡[:vi]60㎡[:]',
            '335' => '[:ja]57㎡[:en]57㎡[:vi]57㎡[:]',
            '336' => '[:ja]76㎡[:en]76㎡[:vi]76㎡[:]',
            '337' => '[:ja]90㎡[:en]90㎡[:vi]90㎡[:]',
            '338' => '[:ja]170㎡[:en]170㎡[:vi]170㎡[:]',
            '340' => '[:ja]68㎡[:en]68㎡[:vi]68㎡[:]',
            '341' => '[:ja]32㎡[:en]32㎡[:vi]32㎡[:]',
            '342' => '[:ja]55㎡[:en]55㎡[:vi]55㎡[:]',
            '343' => '[:ja]86㎡[:en]86㎡[:vi]86㎡[:]',
            '345' => '[:ja]64㎡[:en]64㎡[:vi]64㎡[:]',
            '346' => '[:ja]70㎡[:en]70㎡[:vi]70㎡[:]',
            '347' => '[:ja]30㎡[:en]30㎡[:vi]30㎡[:]',
            '348' => '[:ja]56.5㎡[:en]56.5㎡[:vi]56.5㎡[:]',
            '349' => '[:ja]90㎡[:en]90㎡[:vi]90㎡[:]',
            '358' => '[:ja]450㎡[:en]450㎡[:vi]450㎡[:]',
            '359' => '[:ja]99㎡[:en]99㎡[:vi]99㎡[:]',
            '360' => '[:ja]180㎡[:en]180㎡[:vi]180㎡[:]',
            '370' => '[:ja]310㎡[:en]310㎡[:vi]310㎡[:]',
            '372' => '[:ja]280㎡[:en]280㎡[:vi]280㎡[:]',
            '373' => '[:ja]126㎡[:en]126㎡[:vi]126㎡[:]',
            '391' => '[:ja]650㎡[:en]650㎡[:vi]650㎡[:]',
            '395' => '[:ja]28㎡[:en]28㎡[:vi]28㎡[:]',
            '396' => '[:ja]38㎡[:en]38㎡[:vi]38㎡[:]',
            '398' => '[:ja]55㎡[:en]55㎡[:vi]55㎡[:]',
            '407' => '[:ja]40㎡[:en]40㎡[:vi]40㎡[:]',
            '409' => '[:ja]190㎡[:en]190㎡[:vi]190㎡[:]',
            '411' => '[:ja]100㎡[:en]100㎡[:vi]100㎡[:]',
            '412' => '[:ja]100㎡[:en]100㎡[:vi]100㎡[:]',
            '414' => '[:ja]515㎡[:en]515㎡[:vi]515㎡[:]',
            '415' => '[:ja]175㎡[:en]175㎡[:vi]175㎡[:]',
            '416' => '[:ja]118㎡[:en]118㎡[:vi]118㎡[:]',
            '418' => '[:ja]360㎡[:en]360㎡[:vi]360㎡[:]',
            '419' => '[:ja]1,100㎡[:en]1,100㎡[:vi]1,100㎡[:]',
            '420' => '[:ja]332㎡[:en]332㎡[:vi]332㎡[:]',
            '421' => '[:ja]87㎡[:en]87㎡[:vi]87㎡[:]',
            '423' => '[:ja]136㎡[:en]136㎡[:vi]136㎡[:]',
            '424' => '[:ja]530㎡[:en]530㎡[:vi]530㎡[:]',
            '425' => '[:ja]260㎡[:en]260㎡[:vi]260㎡[:]',
            '426' => '[:ja]390㎡[:en]390㎡[:vi]390㎡[:]',
            '427' => '[:ja]55㎡[:en]55㎡[:vi]55㎡[:]',
            '428' => '[:ja]116㎡[:en]116㎡[:vi]116㎡[:]',
            '430' => '[:ja]440㎡[:en]440㎡[:vi]440㎡[:]',
            '431' => '[:ja]142㎡[:en]142㎡[:vi]142㎡[:]',
            '432' => '[:ja]95㎡[:en]95㎡[:vi]95㎡[:]',
            '434' => '[:ja]75㎡[:en]75㎡[:vi]75㎡[:]',
            '435' => '[:ja]90㎡[:en]90㎡[:vi]90㎡[:]',
            '436' => '[:ja]172㎡[:en]172㎡[:vi]172㎡[:]',
            '438' => '[:ja]112㎡[:en]112㎡[:vi]112㎡[:]',
            '439' => '[:ja]417㎡[:en]417㎡[:vi]417㎡[:]',
            '440' => '[:ja]490㎡[:en]490㎡[:vi]490㎡[:]',
            '441' => '[:ja]527㎡[:en]527㎡[:vi]527㎡[:]',
            '442' => '[:ja]1[:en]1㎡[:vi]1㎡[:]',
            '443' => '[:ja]139㎡[:en]139㎡[:vi]139㎡[:]',
            '444' => '[:ja]35㎡[:en]35㎡[:vi]35㎡[:]',
            '446' => '[:ja]88㎡[:en]88㎡[:vi]88㎡[:]',
            '447' => '[:ja]1,700㎡[:en]1,700㎡[:vi]1,700㎡[:]',
            '448' => '[:ja]123㎡[:en]123㎡[:vi]123㎡[:]',
            '450' => '[:ja]290㎡[:en]290㎡[:vi]290㎡[:]',
            '451' => '[:ja]94㎡[:en]94㎡[:vi]94㎡[:]',
            '452' => '[:ja]226㎡[:en]226㎡[:vi]226㎡[:]',
            '454' => '[:ja]157㎡[:en]157㎡[:vi]157㎡[:]',
            '456' => '[:ja]148㎡[:en]148㎡[:vi]148㎡[:]',
            '457' => '[:ja]185㎡[:en]185㎡[:vi]185㎡[:]',
            '458' => '[:ja]174㎡[:en]174㎡[:vi]174㎡[:]',
            '460' => '[:ja]124㎡[:en]124㎡[:vi]124㎡[:]',
            '461' => '[:ja]102㎡[:en]102㎡[:vi]102㎡[:]',
            '462' => '[:ja]97㎡[:en]97㎡[:vi]97㎡[:]',
            '463' => '[:ja]53㎡[:en]53㎡[:vi]53㎡[:]',
            '464' => '[:ja]84㎡[:en]84㎡[:vi]84㎡[:]',
            '465' => '[:ja]115㎡[:en]115㎡[:vi]115㎡[:]',
            '466' => '[:ja]117㎡[:en]117㎡[:vi]117㎡[:]',
            '467' => '[:ja]263㎡[:en]263㎡[:vi]263㎡[:]',
            '468' => '[:ja]520㎡[:en]520㎡[:vi]520㎡[:]',
            '469' => '[:ja]650㎡[:en]650㎡[:vi]650㎡[:]',
            '470' => '[:ja]190㎡[:en]190㎡[:vi]190㎡[:]',
            '471' => '[:ja]252㎡[:en]252㎡[:vi]252㎡[:]',
            '472' => '[:ja]307㎡[:en]307㎡[:vi]307㎡[:]',
            '473' => '[:ja]230㎡[:en]230㎡[:vi]230㎡[:]',
            '474' => '[:ja]1,000㎡[:en]1,000㎡[:vi]1,000㎡[:]',
            '476' => '[:ja]143㎡[:en]143㎡[:vi]143㎡[:]',
            '488' => '[:ja]275㎡[:en]275㎡[:vi]275㎡[:]',
            '489' => '[:ja]96㎡[:en]96㎡[:vi]96㎡[:]',
            '490' => '[:ja]78㎡[:en]78㎡[:vi]78㎡[:]',
            '496' => '[:ja]124㎡[:en]124㎡[:vi]124㎡[:]',
            '497' => '[:ja]25㎡[:en]25㎡[:vi]25㎡[:]',
            '498' => '[:ja]30㎡[:en]30㎡[:vi]30㎡[:]',
            '501' => '[:ja]34㎡[:en]34㎡[:vi]34㎡[:]',
            '503' => '[:ja]440㎡[:en]440㎡[:vi]440㎡[:]',
            '504' => '[:ja]20㎡[:en]20㎡[:vi]20㎡[:]',
            '505' => '[:ja]690㎡[:en]690㎡[:vi]690㎡[:]',
            '506' => '[:ja]380㎡[:en]380㎡[:vi]380㎡[:]',
            '507' => '[:ja]460㎡[:en]460㎡[:vi]460㎡[:]',
            '508' => '[:ja]375㎡[:en]375㎡[:vi]375㎡[:]',
            '510' => '[:ja]93㎡[:en]93㎡[:vi]93㎡[:]',
            '511' => '[:ja]151㎡[:en]151m2[:vi]151㎡[:]',
            '513' => '[:ja]138㎡[:en]138㎡[:vi]138㎡[:]',
            '515' => '[:ja]36㎡[:en]36㎡[:vi]36㎡[:]',
            '516' => '[:ja]325㎡[:en]325㎡[:vi]325㎡[:]',
            '517' => '[:ja]101.5㎡[:en]101.5㎡[:vi]101.5㎡[:]',
            '518' => '[:ja]201㎡[:en]201㎡[:vi]201㎡[:]',
            '519' => '[:ja]179㎡[:en]179㎡[:vi]179㎡[:]',
            '520' => '[:ja]243㎡[:en]243㎡[:vi]243㎡[:]',
            '521' => '[:ja]37㎡[:en]37㎡[:vi]37㎡[:]',
            '522' => '[:ja]37㎡[:en]37㎡[:vi]37㎡[:]',
            '523' => '[:ja]37㎡[:en]37㎡[:vi]37㎡[:]',
            '524' => '[:ja]37㎡[:en]37㎡[:vi]37㎡[:]',
            '525' => '[:ja]105㎡[:en]105㎡[:vi]105㎡[:]',
            '526' => '[:ja]172㎡[:en]172㎡[:vi]172㎡[:]',
            '528' => '[:ja]25㎡[:en]25㎡[:vi]25㎡[:]',
            '529' => '[:ja]370㎡[:en]370㎡[:vi]370㎡[:]',
            '530' => '[:ja]26㎡[:en]26㎡[:vi]26㎡[:]',
            '531' => '[:ja]1,350㎡[:en]1,350㎡[:vi]1,350㎡[:]',
            '532' => '[:ja]900㎡[:en]900㎡[:vi]900㎡[:]',
            '534' => '[:ja]565㎡[:en]565㎡[:vi]565㎡[:]',
            '535' => '[:ja]1,400㎡[:en]1,400㎡[:vi]1,400㎡[:]',
            '537' => '[:ja]508㎡[:en]508㎡[:vi]508㎡[:]',
            '538' => '[:ja]1,150㎡[:en]1,150㎡[:vi]1,150㎡[:]',
            '539' => '[:ja]1,000㎡[:en]1,000㎡[:vi]1,000㎡[:]',
            '540' => '[:ja]33㎡[:en]33㎡[:vi]33㎡[:]',
            '541' => '[:ja]51㎡[:en]51㎡[:vi]51㎡[:]',
            '542' => '[:ja]92㎡[:en]92㎡[:vi]92㎡[:]',
            '548' => '[:ja]32㎡[:en]32㎡[:vi]32㎡[:]',
            '550' => '[:ja]35㎡[:en]35㎡[:vi]35㎡[:]',
            '551' => '[:ja]20㎡[:en]20㎡[:vi]20㎡[:]',
            '552' => '[:ja]30㎡[:en]30㎡[:vi]30㎡[:]',
            '553' => '[:ja]450㎡[:en]450㎡[:vi]450㎡[:]',
            '554' => '[:ja]180㎡[:en]180㎡[:vi]180㎡[:]',
            '555' => '[:ja]500㎡[:en]500㎡[:vi]500㎡[:]',
            '556' => '[:ja]137㎡[:en]137㎡[:vi]137㎡[:]',
            '557' => '[:ja]86㎡[:en]86㎡[:vi]86㎡[:]',
            '558' => '[:ja]80㎡[:en]80㎡[:vi]80㎡[:]',
            '562' => '[:ja]33㎡[:en]33㎡[:vi]33㎡[:]',
            '563' => '[:ja]33㎡[:en]33㎡[:vi]33㎡[:]',
            '565' => '[:ja]36㎡[:en]36㎡[:vi]36㎡[:]',
            '566' => '[:ja]550㎡[:en]550㎡[:vi]550㎡[:]',
            '567' => '[:ja]830㎡[:en]830㎡[:vi]830㎡[:]',
            '570' => '[:ja]17㎡[:en]17㎡[:vi]17㎡[:]',
            '571' => '[:ja]24㎡[:en]24㎡[:vi]24㎡[:]',
            '574' => '[:ja]30㎡[:en]30㎡[:vi]30㎡[:]',
            '577' => '[:ja]153㎡[:en]153m2[:vi]153㎡[:]',
            '584' => '[:ja]800㎡[:en]800㎡[:vi]800㎡[:]',
            '585' => '[:ja]81㎡[:en]81㎡[:vi]81㎡[:]',
            '586' => '[:ja]104㎡[:en]104㎡[:vi]104㎡[:]',
            '587' => '[:ja]470㎡[:en]470㎡[:vi]470㎡[:]',
            '590' => '[:ja]122㎡[:en]122㎡[:vi]122㎡[:]',
            '591' => '[:ja]122㎡[:en]122㎡[:vi]122㎡[:]',
            '592' => '[:ja]122㎡[:en]122㎡[:vi]122㎡[:]',
            '595' => '[:ja]127㎡[:en]127㎡[:vi]127㎡[:]',
            '598' => '[:ja]20㎡[:en]20㎡[:vi]20㎡[:]',
            '599' => '[:ja]113㎡[:en]113㎡[:vi]113㎡[:]',
            '600' => '[:ja]158㎡[:en]158㎡[:vi]158㎡[:]',
            '601' => '[:ja]171㎡[:en]171㎡[:vi]171㎡[:]',
            '603' => '[:ja]89㎡[:en]89㎡[:vi]89㎡[:]',
            '606' => '[:ja]27㎡[:en]27㎡[:vi]27㎡[:]',
            '609' => '[:ja]450㎡[:en]450㎡[:vi]450㎡[:]',
            '611' => '[:ja]149㎡[:en]149㎡[:vi]149㎡[:]',
            '612' => '[:ja]132㎡[:en]132㎡[:vi]132㎡[:]',
            '613' => '[:ja]144㎡[:en]144㎡[:vi]144㎡[:]',
            '614' => '[:ja]82㎡[:en]82㎡[:vi]82㎡[:]',
            '615' => '[:ja]83㎡[:en]83㎡[:vi]83㎡[:]',
            '617' => '[:ja]168㎡[:en]168㎡[:vi]168㎡[:]',
            '618' => '[:ja]51㎡[:en]51㎡[:vi]51㎡[:]',
            '619' => '[:ja]38㎡[:en]38㎡[:vi]38㎡[:]',
            '629' => '[:ja]73㎡[:en]73㎡[:vi]73㎡[:]',
            '635' => '[:ja]135㎡[:en]135㎡[:vi]135㎡[:]',
            '636' => '[:ja]45㎡[:en]45㎡[:vi]45㎡[:]',
            '637' => '[:ja]44㎡[:en]44㎡[:vi]44㎡[:]',
            '639' => '[:ja]300㎡[:en]300㎡[:vi]300㎡[:]',
            '640' => '[:ja]148㎡[:en]148㎡[:vi]148㎡[:]',
            '642' => '[:ja]315㎡[:en]315㎡[:vi]315㎡[:]',
            '643' => '[:ja]135㎡[:en]135㎡[:vi]135㎡[:]',
            '645' => '[:ja]1,600㎡[:en]1,600㎡[:vi]1,600㎡[:]',
            '647' => '[:ja]384㎡[:en]384㎡[:vi]384㎡[:]',
            '652' => '[:ja]216㎡[:en]216㎡[:vi]216㎡[:]',
            '653' => '[:ja]440㎡[:en]440㎡[:vi]440㎡[:]',
            '655' => '[:ja]204㎡[:en]204㎡[:vi]204㎡[:]',
            '657' => '[:ja]89㎡[:en]89㎡[:vi]89㎡[:]',
            '662' => '[:ja]448㎡[:en]448㎡[:vi]448㎡[:]',
            '666' => '[:ja]192㎡[:en]192㎡[:vi]192㎡[:]',
            '670' => '[:ja]43㎡[:en]43㎡[:vi]43㎡[:]',
            '672' => '[:ja]25㎡[:en]25㎡[:vi]25㎡[:]',
            '674' => '[:ja]320㎡[:en]320㎡[:vi]320㎡[:]',
            '678' => '[:ja]600㎡[:en]600㎡[:vi]600㎡[:]',
            '679' => '[:ja]27㎡[:en]27㎡[:vi]27㎡[:]',
            '680' => '[:ja]27㎡[:en]27㎡[:vi]27㎡[:]',
            '682' => '[:ja]970㎡[:en]970㎡[:vi]970㎡[:]',
            '684' => '[:ja]25㎡[:en]25㎡[:vi]25㎡[:]',
            '685' => '[:ja]31㎡[:en]31㎡[:vi]31㎡[:]',
            '686' => '[:ja]189㎡[:en]189㎡[:vi]189㎡[:]',
            '687' => '[:ja]420㎡[:en]420㎡[:vi]420㎡[:]',
            '688' => '[:ja]497㎡[:en]497㎡[:vi]497㎡[:]',
            '689' => '[:ja]497㎡[:en]497㎡[:vi]497㎡[:]',
            '690' => '[:ja]42㎡[:en]42㎡[:vi]42㎡[:]',
            '691' => '[:ja]108㎡[:en]108㎡[:vi]108㎡[:]',
            '692' => '[:ja]108㎡[:en]108㎡[:vi]108㎡[:]',
            '693' => '[:ja]310㎡[:en]310㎡[:vi]310㎡[:]',
            '695' => '[:ja]546㎡[:en]546㎡[:vi]546㎡[:]',
=======
>>>>>>> 529a4bca899d779aaa7d00fdd0d6a6da6cebf85f
            
        ]
                    
    ],
    'size_rangefor_search' => [
        'name' => '[:ja]面積[:en]Size Range[:vi]Size Range[:]',
        'group' => 'basic',
        'type' => 'single',                
        'values' => [
            '1' => '[:ja]50㎡以下[:en]~ 50㎡[:vi]~ 50㎡[:]',
            '2' => '[:ja]51㎡ ~ 100㎡[:en]51㎡ ~ 100㎡[:vi]51㎡ ~ 100㎡[:]',
            '3' => '[:ja]101㎡ ~ 150㎡[:en]101㎡ ~ 150㎡[:vi]101㎡ ~ 150㎡[:]',
            '4' => '[:ja]151㎡ ~ 200㎡[:en]151㎡ ~ 200㎡[:vi]151㎡ ~ 200㎡[:]',
            '5' => '[:ja]201㎡ ~ 250㎡[:en]201㎡ ~ 250㎡[:vi]201㎡ ~ 250㎡[:]',
            '6' => '[:ja]251㎡ ~ 300㎡[:en]251㎡ ~ 300㎡[:vi]251㎡ ~ 300㎡[:]',
            '7' => '[:ja]301㎡ ~ 400㎡[:en]301㎡ ~ 400㎡[:vi]301㎡ ~ 400㎡[:]',
            '8' => '[:ja]401㎡ ~ 500㎡[:en]401㎡ ~ 500㎡[:vi]401㎡ ~ 500㎡[:]',
            '9' => '[:ja]501㎡ ~ 1000㎡[:en]501㎡ ~ 1000㎡[:vi]501㎡ ~ 1000㎡[:]',
            '10' => '[:ja]1001㎡ ~ 2000㎡[:en]1001㎡ ~ 2000㎡[:vi]1001㎡ ~ 2000㎡[:]',
            '11' => '[:ja]2001㎡以上[:en]2001㎡ ~[:vi]2001㎡ ~[:]',
            
        ]
                    
    ],
    'inclusive' => [
        'name' => '[:ja]賃料に含まれるもの[:en]Inclusive[:vi]Bao gồm[:]',
        'group' => 'details',
        'type' => 'multiple',                
        'values' => [
            '1' => '[:ja]VAT[:en]VAT[:vi]VAT[:]',
            '2' => '[:ja]管理費[:en]Management Fee[:vi]Phí quản lý[:]',
            '3' => '[:ja]インターネット+TV[:en]Internet + TV[:vi]Phí Internet[:]',
            '4' => '[:ja]電気代[:en]Electricity[:vi]Phí điện[:]',
            '5' => '[:ja]水道代[:en]Water[:vi]Phí nước[:]',
            '6' => '[:ja]掃除サービス[:en]Room Cleaning[:vi]Phí dọn vệ sinh[:]',
            '7' => '[:ja]プール利用料[:en]Pool Entrance[:vi]Phí vào hồ bơi[:]',
            '8' => '[:ja]ジム利用料[:en]Gym Entrance[:vi]Phí vào phòng tập[:]',
            '9' => '[:ja]洗濯サービス[:en]Laundry Service[:vi]Phí giặt[:]',
            
        ]
                    
    ],
    'facilities' => [
        'name' => '[:ja]特別な家具/設備など[:en]Facilities[:vi]Cơ sở vật chất[:]',
        'group' => 'details',
        'type' => 'multiple',                
        'values' => [
            '1' => '[:ja]プール[:en]Pool[:vi]Hồ bơi[:]',
<<<<<<< HEAD
            '212' => '[:ja]プライベートプール[:en]Private Pool[:vi]Hồ bơi riêng[:]',
            '213' => '[:ja]共用プール[:en]Shared Pool[:vi]Hồ bơi chung[:]',
            '214' => '[:ja]ジム[:en]Gym[:vi]Phòng tập thể dục[:]',
            '2000' => '[:ja]お部屋に洗濯機[:en]Washer in unit[:vi]Máy giặt[:]',
            '217' => '[:ja]バルコニー[:en]Balcony[:vi]Ban công[:]',
            '422' => '[:ja]エレベーター[:en]Elevator[:vi]Thang máy[:]',
            '576' => '[:ja]コンパウンド[:en]Compound[:vi]Compound[:]',
=======
            '2' => '[:ja]プライベートプール[:en]Private Pool[:vi]Hồ bơi riêng[:]',
            '3' => '[:ja]共用プール[:en]Shared Pool[:vi]Hồ bơi chung[:]',
            '4' => '[:ja]ジム[:en]Gym[:vi]Phòng tập thể dục[:]',
            '5' => '[:ja]キッチン[:en]Kitchen[:vi]Bếp[:]',
            '6' => '[:ja]バスタブ[:en]Bathtub[:vi]Bồn tắm[:]',
            '7' => '[:ja]お部屋に洗濯機[:en]Washer in unit[:vi]Máy giặt[:]',
            '8' => '[:ja]バルコニー[:en]Balcony[:vi]Ban công[:]',
            '9' => '[:ja]エレベーター[:en]Elevator[:vi]Thang máy[:]',
            '10' => '[:ja]コンパウンド[:en]Compound[:vi]Compound[:]',
            '11' => '[:ja]ペットOK[:en]Pet-Friendly[:vi]Pet OK[:]',
>>>>>>> 529a4bca899d779aaa7d00fdd0d6a6da6cebf85f
            
        ]
                    
    ],
    'surroundings' => [
        'name' => '[:ja]環境など[:en]Surroundings[:vi]Môi trường xung quanh[:]',
        'group' => 'details',
        'type' => 'multiple',                
        'values' => [
            '1' => '[:ja]有人受付[:en]Front Desk[:vi]Bàn tiếp tân[:]',
            '2' => '[:ja]警備員24/24[:en]Security Guard[:vi]Bảo vệ[:]',
            '3' => '[:ja]発電機[:en]Generator[:vi]Máy phát điện[:]',
            '4' => '[:ja]陽当たり良し[:en]Sunny[:vi]Nhiều ánh sáng[:]',
            '5' => '[:ja]門限無し[:en]No Curfew[:vi]Không giờ giới nghiêm[:]',
            '6' => '[:ja]買物便利[:en]Near Market[:vi]Mua hàng tiện lợi[:]',
            
        ]
                    
    ],
    'address' => [
        'name' => '[:ja][:en]Address[:vi][:]',
        'group' => 'basic',
        'type' => 'text',                
        'values' => [
            
        ]
                    
    ],
    'contract_limit' => [
        'name' => '[:ja][:en]Contract Limit[:vi][:]',
        'group' => 'basic',
        'type' => 'text',                
        'values' => [
            
        ]
                    
    ],
    'floor' => [
        'name' => '[:ja][:en]Floor[:vi][:]',
        'group' => 'basic',
        'type' => 'text',                
        'values' => [
            
        ]
                    
    ],
    'conditioning_system' => [
        'name' => '[:ja][:en]Conditioning System[:vi][:]',
        'group' => 'basic',
        'type' => 'text',                
        'values' => [
            
        ]
                    
    ],
    'anniversary' => [
        'name' => '[:ja][:en]Anniversary[:vi][:]',
        'group' => 'basic',
        'type' => 'text',                
        'values' => [
            
        ]
                    
    ],
    'commiss' => [
        'name' => '[:ja][:en]Commissions[:vi][:]',
        'group' => 'basic',
        'type' => 'text',                
        'values' => [
            
        ]
                    
    ],
    'term_8' => [
        'name' => '[:ja][:en]Address[:vi]Địa chỉ[:]',
        'group' => 'basic',
        'type' => 'single',        'deletable' => true,        
        'values' => [
            '0' => '[:ja][:en]Tân Bình[:vi]Tân Bình[:]',
            '1' => '[:ja][:en]Quận 1[:vi]Quận 1[:]',
            
        ]
                    
    ],
    'term_9' => [
        'name' => '[:ja][:en]Test[:vi][:]',
        'group' => 'basic',
        'type' => 'single',        'deletable' => true,        
        'values' => [
            '0' => '[:ja][:en]Test 1 vi[:vi][:]',
            
        ]
                    
    ],
];
