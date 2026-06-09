@extends('layouts.app')
@section('title', 'Services | The Healing Room Aesthetic Clinic')

@section('content')

<section class="thr-page-hero thr-page-hero--services">
    <div class="thr-page-hero__content">
        <p class="thr-page-hero__eyebrow">What We Offer</p>
        <h1 class="thr-page-hero__title">Our Services</h1>
        <p class="thr-page-hero__sub">Premium, personalized treatments for every stage of your wellness journey.</p>
    </div>
</section>

<section class="thr-section thr-section--light">
    <div class="thr-container">
        {{-- Category Filter Tabs --}}
        <div class="thr-tabs-wrap">
            <div class="thr-tabs">
                <button class="thr-tab active" data-category="all">All Services</button>
                @foreach($servicesByCategory as $key => $data)
                <button class="thr-tab" data-category="{{ $key }}">
                    {{ $data['meta']['icon'] }} {{ $data['meta']['label'] }}
                </button>
                @endforeach
            </div>
        </div>

        {{-- Service Categories --}}
        @foreach($servicesByCategory as $key => $data)
        @if($data['services']->count() > 0)
        <div class="thr-category-block" data-category="{{ $key }}">
            <div class="thr-category-header thr-category-header--{{ $data['meta']['color'] }}">
                <span class="thr-category-header__icon">{{ $data['meta']['icon'] }}</span>
                <h2 class="thr-category-header__title">{{ $data['meta']['label'] }}</h2>
                <span class="thr-category-header__count">{{ $data['services']->count() }} services</span>
            </div>
            <div class="thr-service-list">
                @foreach($data['services'] as $service)
                <div class="thr-service-item">
                    @if($service->image)
                    <div class="thr-service-item__image">
                        <img src="{{ $service->image_url }}" alt="{{ $service->name }}">
                    </div>
                    @endif
                    <div class="thr-service-item__body">
                        <h3 class="thr-service-item__name">{{ $service->name }}</h3>
                        <p class="thr-service-item__desc">{{ $service->short_description }}</p>
                        <div class="thr-service-item__meta">
                            <span class="thr-meta-badge"><i class="fas fa-clock"></i> {{ $service->duration }}</span>
                        </div>
                    </div>
                    <div class="thr-service-item__aside">
                        <div class="thr-service-item__price">
                            <span class="thr-service-item__price-label">From</span>
                            <span class="thr-service-item__price-amount">GHS {{ number_format($service->price_from, 0) }}</span>
                        </div>
                        <a href="{{ route('booking') }}?service={{ $service->slug }}" class="btn btn-gold btn-sm">
                            Book This Service
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        @endforeach
    </div>
</section>

{{-- CTA --}}
<section class="thr-cta-banner">
    <div class="thr-cta-banner__content">
        <h2 class="thr-cta-banner__title">Not Sure Which Treatment Is Right for You?</h2>
        <p class="thr-cta-banner__sub">Select "Help me choose" when booking and our experts will guide you.</p>
        <a href="{{ route('booking') }}" class="btn btn-white btn-lg">
            <i class="fas fa-calendar-plus"></i> Book a Consultation
        </a>
    </div>
</section>

@endsection

@push('scripts')
<script>
const tabs = document.querySelectorAll('.thr-tab');
const blocks = document.querySelectorAll('.thr-category-block');
tabs.forEach(tab => {
    tab.addEventListener('click', function() {
        tabs.forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        const cat = this.dataset.category;
        blocks.forEach(b => {
            if (cat === 'all' || b.dataset.category === cat) {
                b.style.display = '';
            } else {
                b.style.display = 'none';
            }
        });
    });
});
</script>
@endpush
