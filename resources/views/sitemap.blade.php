{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url><loc>{{ url('/') }}</loc><changefreq>daily</changefreq><priority>1.0</priority></url>
    <url><loc>{{ url('/centre') }}</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>
    <url><loc>{{ url('/formations') }}</loc><changefreq>weekly</changefreq><priority>0.9</priority></url>
    <url><loc>{{ url('/admission') }}</loc><changefreq>weekly</changefreq><priority>0.9</priority></url>
    <url><loc>{{ url('/news') }}</loc><changefreq>daily</changefreq><priority>0.8</priority></url>
    <url><loc>{{ url('/events') }}</loc><changefreq>weekly</changefreq><priority>0.7</priority></url>
    <url><loc>{{ url('/documents') }}</loc><changefreq>daily</changefreq><priority>0.8</priority></url>
    <url><loc>{{ url('/galerie') }}</loc><changefreq>weekly</changefreq><priority>0.6</priority></url>
    <url><loc>{{ url('/contact') }}</loc><changefreq>monthly</changefreq><priority>0.7</priority></url>
    <url><loc>{{ url('/candidature') }}</loc><changefreq>weekly</changefreq><priority>0.9</priority></url>
    @foreach($filieres as $filiere)
    <url><loc>{{ url('/formations/filiere/'.$filiere->slug) }}</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>
    @endforeach
    @foreach($articles as $article)
    <url><loc>{{ url('/news/'.$article->slug) }}</loc><lastmod>{{ $article->updated_at->toAtomString() }}</lastmod><changefreq>monthly</changefreq><priority>0.6</priority></url>
    @endforeach
    @foreach($events as $event)
    <url><loc>{{ url('/events/'.$event->slug) }}</loc><changefreq>monthly</changefreq><priority>0.5</priority></url>
    @endforeach
</urlset>
