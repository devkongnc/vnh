<?xml version="1.0" encoding="UTF-8"?>

<sitemapindex xmlns="//www.sitemaps.org/schemas/sitemap/0.9">
	@foreach(['page', 'estate', 'category', 'review'] as $type)
		{{-- */ $model = '\\App\\' . ucfirst($type); /* --}}
		<sitemap>
	      <loc>{{ action('HomeController@sitemap', $type) }}</loc>
	      <lastmod>{{ \Carbon\Carbon::parse($model::orderBy('id', 'desc')->first()->getOriginal('updated_at'))->tz('UTC')->toAtomString() }}</lastmod>
	   </sitemap>
	@endforeach
</sitemapindex>
