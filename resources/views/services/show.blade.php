<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ collect(['seo_title' => $service->seo_title, 'name' => $service->name])->filter()->first() }} | Agency</title>
    <meta name="description" content="{{ $service->seo_description ?? $service->short_description }}">
    <meta name="keywords" content="{{ $service->seo_keywords }}">
    <style>
        body { font-family: sans-serif; padding: 2rem; max-width: 800px; margin: 0 auto; color: #333; line-height: 1.6; }
        img { max-width: 100%; border-radius: 8px; margin-bottom: 2rem; }
        h1 { margin-bottom: 0.5rem; }
        .back-link { display: inline-block; margin-bottom: 2rem; color: #007bff; text-decoration: none; }
        .section { margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #eee; }
        .faq-item { margin-bottom: 1.5rem; }
        .faq-item h3 { margin-bottom: 0.5rem; }
        .cta { background: #007bff; color: white; padding: 2rem; text-align: center; border-radius: 8px; margin-top: 4rem; }
        .cta a { display: inline-block; background: white; color: #007bff; padding: 1rem 2rem; border-radius: 4px; text-decoration: none; font-weight: bold; margin-top: 1rem; }
    </style>
</head>
<body>
    <a href="{{ route('services.index') }}" class="back-link">&larr; Back to Services</a>

    <article>
        <h1>{{ $service->name }}</h1>
        <p class="lead">{{ $service->short_description }}</p>

        @if($service->featured_image)
            <img src="{{ Storage::url($service->featured_image) }}" alt="{{ $service->name }}">
        @endif

        <div class="content">
            {!! $service->full_description !!}
        </div>

        @if($service->problem_statement)
            <div class="section">
                <h2>The Problem</h2>
                {!! $service->problem_statement !!}
            </div>
        @endif

        @if($service->solution_approach)
            <div class="section">
                <h2>Our Approach</h2>
                {!! $service->solution_approach !!}
            </div>
        @endif

        @if(!empty($service->process_steps))
            <div class="section">
                <h2>How It Works</h2>
                <div class="process-steps">
                    @foreach($service->process_steps as $step)
                        <div class="step">
                            <h3>{{ $step['step_title'] ?? '' }}</h3>
                            <p>{{ $step['description'] ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if(!empty($service->faq))
            <div class="section">
                <h2>Frequently Asked Questions</h2>
                <div class="faqs">
                    @foreach($service->faq as $item)
                        <div class="faq-item">
                            <h3>{{ $item['question'] ?? '' }}</h3>
                            <p>{{ $item['answer'] ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="cta">
            <h2>Ready to get started?</h2>
            <p>{{ $service->call_to_action_text ?: 'Contact us today to discuss how we can help.' }}</p>
            <a href="#">Contact Us</a>
        </div>
    </article>
</body>
</html>
