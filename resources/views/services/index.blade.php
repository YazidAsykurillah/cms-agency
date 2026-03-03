<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services | Agency</title>
    <!-- Basic generic styling for module demonstration -->
    <style>
        body { font-family: sans-serif; padding: 2rem; max-width: 1200px; margin: 0 auto; color: #333; }
        .service-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem; }
        .service-card { border: 1px solid #eee; padding: 1.5rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .service-card img { max-width: 100%; border-radius: 4px; height: 180px; object-fit: cover; width: 100%; }
        .badge { display: inline-block; background: #007bff; color: white; padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.8rem; margin-bottom: 0.5rem; }
    </style>
</head>
<body>
    <header>
        <h1>Our Services</h1>
        <p>Explore what Agency can do for your business.</p>
    </header>

    <div class="service-list">
        @forelse($services as $service)
            <div class="service-card">
                @if($service->featured_image)
                    <img src="{{ Storage::url($service->featured_image) }}" alt="{{ $service->name }}">
                @endif
                
                @if($service->featured)
                    <div class="badge">Featured</div>
                @endif
                
                <h2>{{ $service->name }}</h2>
                <p>{{ $service->short_description }}</p>
                <a href="{{ route('services.show', $service->slug) }}" style="color: #007bff; text-decoration: none; font-weight: bold;">Learn More &rarr;</a>
            </div>
        @empty
            <p>No services published yet.</p>
        @endforelse
    </div>
</body>
</html>
