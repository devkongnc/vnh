<?xml version="1.0" encoding="UTF-8"?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	@if ($type === 'page')
		<url>
            <loc>{{ action('HomeController@searchForm') }}</loc>
            <lastmod>{{ \Carbon\Carbon::parse(\App\Estate::orderBy('id', 'desc')->first()->getOriginal('updated_at'))->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
        <url>
            <loc>{{ action('RealEstateController@index') }}</loc>
            <lastmod>{{ \Carbon\Carbon::parse(\App\Estate::orderBy('id', 'desc')->first()->getOriginal('updated_at'))->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
        <url>
            <loc>{{ action('CategoryController@index') }}</loc>
            <lastmod>{{ \Carbon\Carbon::parse(\App\Category::orderBy('id', 'desc')->first()->getOriginal('updated_at'))->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
        <url>
            <loc>{{ action('ApartmentController@index') }}</loc>
            <lastmod>{{ \Carbon\Carbon::parse(\App\Apartment::orderBy('id', 'desc')->first()->getOriginal('updated_at'))->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
        <url>
            <loc>{{ action('ReviewController@index') }}</loc>
            <lastmod>{{ \Carbon\Carbon::parse(\App\Review::orderBy('id', 'desc')->first()->getOriginal('updated_at'))->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
	@endif
    @foreach ($models as $model)
        <url>
            <loc>{{ $model->url }}</loc>
            <lastmod>{{ \Carbon\Carbon::parse($model->getOriginal('updated_at'))->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach
</urlset>
