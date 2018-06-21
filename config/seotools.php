<?php

return [
    'meta'      => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'       => '[:ja]ベトナムハウス｜ホーチミン最大級の賃貸不動産情報[:en]VIETNAM HOUSE｜Villa, Apartment, Office &amp; House for Rent in HCMC[:vi]VIETNAM HOUSE｜Cho Thuê Nhà Tp.HCM[:]', // set false to total remove
            'description' => '[:ja]ベトナムハウスはベトナム・ホーチミン市最大級の賃貸不動産会社です。サービスアパートからコンドミニアム、戸建、オフィス、店舗と幅広いジャンルと膨大な物件数よりあなたにぴったりな不動産物件を探せます。日本人完全対応。[:en]&quot;VIETNAM HOUSE&quot; is real estate agency in Ho Chi Minh City Vietnam.  Houses, villas, serviced apartments and office for rent in HCMC (Saigon).  You can find from our huge listing with professional experts.[:vi]VIETNAM HOUSE Công ty chuyên cho thuê nhà ở, villa, căn hô cao cấp, văn phòng, cửa hàng cho thuê tại Tp.HCM (Thành phố Hồ Chí Minh). Nắm trong tay số lượng bất động sản được xem là nhiều nhất tại thành phố, chúng tôi luôn sẵn sàng giới thiệu đến các bạn các bất động sản cao cấp với giá cực tốt phù hợp với nhu cầu của các bạn.[:]', // set false to total remove_accents( $string );
            'separator'   => ' - ',
            'keywords'    => [],
            'canonical'   => null, // Set null for using Url::current(), set false to total remove
        ],

        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
        ],
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => false, // set false to total remove
            'description' => false, // set false to total remove
            'url'         => null,
            'type'        => 'article',
            'site_name'   => 'VIETNAM HOUSE',
            'images'      => ['/images/vietnamhouse_home.png'],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
          'card'        => 'summary',
          'site'        => 'VIETNAM HOUSE',
        ],
    ],
];
