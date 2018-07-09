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
            
        ]
                    
    ],
    'facilities' => [
        'name' => '[:ja]特別な家具/設備など[:en]Facilities[:vi]Cơ sở vật chất[:]',
        'group' => 'details',
        'type' => 'multiple',                
        'values' => [
            '8' => '[:ja]バルコニー[:en]Balcony[:vi]Ban công[:]',
            '9' => '[:ja]エレベーター[:en]Elevator[:vi]Thang máy[:]',
            '10' => '[:ja]駐車場[:en]Car park[:vi]Bãi giữ xe[:]',
            '11' => '[:ja]トイレ[:en]Toilet[:vi]Nhà vệ sinh[:]',
            
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
            '5' => '[:ja]門限無し[:en]No Curfew[:vi]Không giờ giới nghiêm[:]',
            
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
];
