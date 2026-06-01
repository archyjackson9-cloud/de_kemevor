@extends('layouts.app')
@section('title', 'Book an Appointment | The Healing Room')

@section('content')

<section class="thr-page-hero thr-page-hero--booking">
    <div class="thr-page-hero__content">
        <p class="thr-page-hero__eyebrow">Your Transformation Starts Here</p>
        <h1 class="thr-page-hero__title">Book Your Appointment</h1>
        <p class="thr-page-hero__sub">Complete the steps below. We'll confirm within 2 hours via SMS and email.</p>
    </div>
</section>

<section class="thr-section thr-section--light">
    <div class="thr-container thr-container--narrow">

        {{-- Step Indicator --}}
        <div class="thr-stepper" id="stepper">
            <div class="thr-step active" data-step="1">
                <div class="thr-step__circle">1</div>
                <span>Service</span>
            </div>
            <div class="thr-step__connector"></div>
            <div class="thr-step" data-step="2">
                <div class="thr-step__circle">2</div>
                <span>Date & Time</span>
            </div>
            <div class="thr-step__connector"></div>
            <div class="thr-step" data-step="3">
                <div class="thr-step__circle">3</div>
                <span>Your Details</span>
            </div>
            <div class="thr-step__connector"></div>
            <div class="thr-step" data-step="4">
                <div class="thr-step__circle">4</div>
                <span>Confirm</span>
            </div>
        </div>

        @if($errors->any())
        <div class="thr-alert thr-alert--error">
            @foreach($errors->all() as $e)<div><i class="fas fa-exclamation-circle"></i> {{ $e }}</div>@endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('booking.store') }}" id="bookingForm" class="thr-booking-form">
            @csrf

            {{-- ── STEP 1: Service ──────────────────────────────────── --}}
            <div class="thr-booking-step active" id="step-1">
                <h2 class="thr-booking-step__title">Select Your Service</h2>
                <p class="thr-booking-step__sub">Choose from our range of premium treatments.</p>

                <div class="thr-service-picker">
                    @php
                    $categories = [
                        'maternity_postop' => ['label' => '🤱 Maternity & Post-Op Care', 'color' => 'pink'],
                        'body_treatments'  => ['label' => '💆 Body Treatments', 'color' => 'teal'],
                        'skin_treatments'  => ['label' => '✨ Skin Treatments', 'color' => 'amber'],
                        'rejuvenation'     => ['label' => '🌸 Rejuvenation', 'color' => 'purple'],
                    ];
                    $grouped = $services->groupBy('category');
                    @endphp

                    @foreach($categories as $catKey => $catMeta)
                    @if(isset($grouped[$catKey]) && $grouped[$catKey]->count())
                    <div class="thr-service-picker__group">
                        <div class="thr-service-picker__group-label">{{ $catMeta['label'] }}</div>
                        @foreach($grouped[$catKey] as $service)
                        <label class="thr-service-picker__item {{ $preselectedService === $service->slug ? 'selected' : '' }}">
                            <input type="radio" name="service_id" value="{{ $service->id }}"
                                {{ ($preselectedService === $service->slug || old('service_id') == $service->id) ? 'checked' : '' }}>
                            <div class="thr-service-picker__info">
                                <span class="thr-service-picker__name">{{ $service->name }}</span>
                                <span class="thr-service-picker__meta">
                                    <span><i class="fas fa-clock"></i> {{ $service->duration }}</span>
                                    <span><i class="fas fa-tag"></i> From GHS {{ number_format($service->price_from, 0) }}</span>
                                </span>
                            </div>
                            <div class="thr-service-picker__check"><i class="fas fa-check"></i></div>
                        </label>
                        @endforeach
                    </div>
                    @endif
                    @endforeach

                    <label class="thr-service-picker__item thr-service-picker__item--help">
                        <input type="radio" name="service_id" value="0">
                        <div class="thr-service-picker__info">
                            <span class="thr-service-picker__name">🤔 I'm not sure, help me choose</span>
                            <span class="thr-service-picker__meta">We'll guide you to the right treatment during your consultation</span>
                        </div>
                        <div class="thr-service-picker__check"><i class="fas fa-check"></i></div>
                    </label>
                </div>

                <div class="thr-booking-step__nav">
                    <button type="button" class="btn btn-gold" onclick="nextStep(2)">
                        Continue <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            {{-- ── STEP 2: Date & Time ─────────────────────────────── --}}
            <div class="thr-booking-step" id="step-2">
                <h2 class="thr-booking-step__title">Choose Date & Time</h2>
                <p class="thr-booking-step__sub">Select your preferred appointment date and time slot.</p>

                <div class="thr-calendar-wrap">
                    <div class="thr-calendar" id="calendar">
                        <div class="thr-calendar__header">
                            <button type="button" id="prevMonth" class="thr-calendar__nav"><i class="fas fa-chevron-left"></i></button>
                            <span id="calendarTitle"></span>
                            <button type="button" id="nextMonth" class="thr-calendar__nav"><i class="fas fa-chevron-right"></i></button>
                        </div>
                        <div class="thr-calendar__weekdays">
                            <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
                        </div>
                        <div class="thr-calendar__grid" id="calendarGrid"></div>
                    </div>

                    <div class="thr-time-slots" id="timeSlots">
                        <h4 class="thr-time-slots__title">Available Times</h4>
                        <p class="thr-time-slots__hint" id="timeSlotsHint">Select a date to see available time slots.</p>
                        <div class="thr-time-slots__grid" id="timeSlotsGrid"></div>
                    </div>
                </div>

                <input type="hidden" name="booking_date" id="bookingDate" value="{{ old('booking_date') }}">
                <input type="hidden" name="booking_time" id="bookingTime" value="{{ old('booking_time') }}">

                <div class="thr-calendar__legend">
                    <span class="thr-legend thr-legend--available">Available</span>
                    <span class="thr-legend thr-legend--selected">Selected</span>
                    <span class="thr-legend thr-legend--booked">Unavailable</span>
                    <span class="thr-legend thr-legend--past">Past</span>
                </div>

                <div class="thr-booking-step__nav">
                    <button type="button" class="btn btn-outline" onclick="prevStep(1)">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                    <button type="button" class="btn btn-gold" onclick="nextStep(3)" id="step2Next" disabled>
                        Continue <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            {{-- ── STEP 3: Customer Details ─────────────────────────── --}}
            <div class="thr-booking-step" id="step-3">
                <h2 class="thr-booking-step__title">Your Details</h2>
                <p class="thr-booking-step__sub">All information is kept strictly confidential.</p>

                <div class="thr-form">
                    <div class="thr-form__row">
                        <div class="thr-form__group">
                            <label>First Name <span class="req">*</span></label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" required placeholder="Abena">
                        </div>
                        <div class="thr-form__group">
                            <label>Last Name <span class="req">*</span></label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" required placeholder="Mensah">
                        </div>
                    </div>
                    <div class="thr-form__row">
                        <div class="thr-form__group">
                            <label>Phone Number <span class="req">*</span></label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="0244 000 000">
                        </div>
                        <div class="thr-form__group">
                            <label>Email Address <span class="req">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="you@email.com">
                        </div>
                    </div>
                    <div class="thr-form__row">
                        <div class="thr-form__group">
                            <label>Gender <span class="req">*</span></label>
                            <select name="gender" required>
                                <option value="">Select gender</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="prefer_not_to_say" {{ old('gender') == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                            </select>
                        </div>
                        <div class="thr-form__group">
                            <label>Date of Birth</label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}">
                        </div>
                    </div>
                    <div class="thr-form__group">
                        <label>Brief Note About Your Concern</label>
                        <textarea name="notes" rows="4" placeholder="Tell us a little about your skin, health concern, or what you're hoping to achieve. This helps us prepare for your session.">{{ old('notes') }}</textarea>
                    </div>
                    <div class="thr-form__group">
                        <label>Promo Code (Optional)</label>
                        <div class="thr-promo-input">
                            <input type="text" name="promo_code" id="promoCode" value="{{ old('promo_code') }}" placeholder="e.g. HEAL10" style="text-transform:uppercase">
                            <button type="button" class="btn btn-sm btn-outline" onclick="validatePromo()">Apply</button>
                        </div>
                        <p class="thr-form__hint" id="promoMsg"></p>
                    </div>
                </div>

                <div class="thr-booking-step__nav">
                    <button type="button" class="btn btn-outline" onclick="prevStep(2)">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                    <button type="button" class="btn btn-gold" onclick="nextStep(4)">
                        Review Booking <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            {{-- ── STEP 4: Review & Confirm ────────────────────────── --}}
            <div class="thr-booking-step" id="step-4">
                <h2 class="thr-booking-step__title">Review & Confirm</h2>
                <p class="thr-booking-step__sub">Please check your details before confirming.</p>

                <div class="thr-review-card">
                    <div class="thr-review-card__row">
                        <span class="thr-review-card__label"><i class="fas fa-spa"></i> Service</span>
                        <span class="thr-review-card__value" id="reviewService">–</span>
                    </div>
                    <div class="thr-review-card__row">
                        <span class="thr-review-card__label"><i class="fas fa-calendar"></i> Date & Time</span>
                        <span class="thr-review-card__value" id="reviewDateTime">–</span>
                    </div>
                    <div class="thr-review-card__row">
                        <span class="thr-review-card__label"><i class="fas fa-user"></i> Name</span>
                        <span class="thr-review-card__value" id="reviewName">–</span>
                    </div>
                    <div class="thr-review-card__row">
                        <span class="thr-review-card__label"><i class="fas fa-phone"></i> Phone</span>
                        <span class="thr-review-card__value" id="reviewPhone">–</span>
                    </div>
                    <div class="thr-review-card__row">
                        <span class="thr-review-card__label"><i class="fas fa-envelope"></i> Email</span>
                        <span class="thr-review-card__value" id="reviewEmail">–</span>
                    </div>
                </div>

                <div class="thr-form">
                    <div class="thr-form__checkbox">
                        <input type="checkbox" name="consent_reminders" id="consentReminders" value="1" checked>
                        <label for="consentReminders">
                            I consent to receive SMS and email reminders about my appointment from The Healing Room.
                        </label>
                    </div>
                </div>

                <div class="thr-review-privacy">
                    <i class="fas fa-lock"></i>
                    Your information is secure and will never be shared with third parties.
                </div>

                <div class="thr-booking-step__nav">
                    <button type="button" class="btn btn-outline" onclick="prevStep(3)">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                    <button type="submit" class="btn btn-gold btn-lg">
                        <i class="fas fa-check-circle"></i> Confirm Booking
                    </button>
                </div>
            </div>

        </form>
    </div>
</section>

@endsection

@push('scripts')
<script>
// ── Stepper ──────────────────────────────────────────────────────────────
let currentStep = 1;

function nextStep(n) {
    if (n === 2) {
        const service = document.querySelector('input[name="service_id"]:checked');
        if (!service) { alert('Please select a service.'); return; }
    }
    if (n === 3) {
        const date = document.getElementById('bookingDate').value;
        const time = document.getElementById('bookingTime').value;
        if (!date || !time) { alert('Please select a date and time slot.'); return; }
    }
    if (n === 4) {
        const fields = ['first_name','last_name','phone','email','gender'];
        for (const f of fields) {
            const el = document.querySelector(`[name="${f}"]`);
            if (!el || !el.value.trim()) { alert(`Please fill in the ${f.replace('_',' ')} field.`); return; }
        }
        populateReview();
    }
    gotoStep(n);
}

function prevStep(n) { gotoStep(n); }

function gotoStep(n) {
    document.querySelectorAll('.thr-booking-step').forEach((el, i) => {
        el.classList.remove('active');
    });
    document.getElementById(`step-${n}`).classList.add('active');

    document.querySelectorAll('.thr-step').forEach(el => {
        const sn = parseInt(el.dataset.step);
        el.classList.remove('active','completed');
        if (sn === n) el.classList.add('active');
        if (sn < n)  el.classList.add('completed');
    });

    currentStep = n;
    window.scrollTo({ top: document.querySelector('.thr-stepper').offsetTop - 80, behavior: 'smooth' });
}

// ── Calendar ──────────────────────────────────────────────────────────────
let calDate = new Date();
let selectedDate = null;
let selectedTime = null;

function renderCalendar() {
    const year  = calDate.getFullYear();
    const month = calDate.getMonth();
    const today = new Date(); today.setHours(0,0,0,0);

    const months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    document.getElementById('calendarTitle').textContent = `${months[month]} ${year}`;

    const grid = document.getElementById('calendarGrid');
    grid.innerHTML = '';

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month+1, 0).getDate();

    // Empty cells
    for (let i = 0; i < firstDay; i++) {
        const cell = document.createElement('div');
        cell.className = 'thr-cal-day thr-cal-day--empty';
        grid.appendChild(cell);
    }

    for (let d = 1; d <= daysInMonth; d++) {
        const cell = document.createElement('div');
        const thisDate = new Date(year, month, d);
        const isPast   = thisDate < today;
        const isSun    = thisDate.getDay() === 0;
        const dateStr  = `${year}-${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
        const isSelected = selectedDate === dateStr;

        cell.className = 'thr-cal-day';
        if (isPast || isSun) cell.classList.add('thr-cal-day--past');
        if (isSelected)      cell.classList.add('thr-cal-day--selected');
        cell.textContent = d;

        if (!isPast && !isSun) {
            cell.addEventListener('click', () => selectDate(dateStr, cell));
        }
        grid.appendChild(cell);
    }
}

function selectDate(dateStr, cell) {
    selectedDate = dateStr;
    document.getElementById('bookingDate').value = dateStr;
    selectedTime = null;
    document.getElementById('bookingTime').value = '';
    document.getElementById('step2Next').disabled = true;

    document.querySelectorAll('.thr-cal-day').forEach(c => c.classList.remove('thr-cal-day--selected'));
    cell.classList.add('thr-cal-day--selected');

    loadTimeSlots(dateStr);
}

async function loadTimeSlots(date) {
    const hint = document.getElementById('timeSlotsHint');
    const grid = document.getElementById('timeSlotsGrid');
    hint.textContent = 'Loading available slots...';
    grid.innerHTML = '';

    try {
        const res   = await fetch(`/book/slots?date=${date}`);
        const slots = await res.json();
        hint.textContent = '';

        slots.forEach(slot => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = slot.time;
            btn.className = slot.available ? 'thr-time-btn' : 'thr-time-btn thr-time-btn--booked';
            if (!slot.available) btn.disabled = true;
            btn.addEventListener('click', () => selectTime(slot.time, btn));
            grid.appendChild(btn);
        });

        if (!slots.length) hint.textContent = 'No slots available for this date.';
    } catch (e) {
        hint.textContent = 'Could not load slots. Please try again.';
    }
}

function selectTime(time, btn) {
    selectedTime = time;
    document.getElementById('bookingTime').value = time;
    document.getElementById('step2Next').disabled = false;

    document.querySelectorAll('.thr-time-btn').forEach(b => b.classList.remove('thr-time-btn--selected'));
    btn.classList.add('thr-time-btn--selected');
}

document.getElementById('prevMonth').addEventListener('click', () => {
    calDate.setMonth(calDate.getMonth() - 1);
    renderCalendar();
});
document.getElementById('nextMonth').addEventListener('click', () => {
    calDate.setMonth(calDate.getMonth() + 1);
    renderCalendar();
});

renderCalendar();

// ── Review Summary ────────────────────────────────────────────────────────
function populateReview() {
    const serviceEl = document.querySelector('input[name="service_id"]:checked');
    const serviceName = serviceEl ? serviceEl.closest('.thr-service-picker__item')?.querySelector('.thr-service-picker__name')?.textContent : '–';
    const date  = document.getElementById('bookingDate').value;
    const time  = document.getElementById('bookingTime').value;
    const fname = document.querySelector('[name="first_name"]').value;
    const lname = document.querySelector('[name="last_name"]').value;
    const phone = document.querySelector('[name="phone"]').value;
    const email = document.querySelector('[name="email"]').value;

    document.getElementById('reviewService').textContent = serviceName || '–';
    document.getElementById('reviewDateTime').textContent = date && time ? `${date} at ${time}` : '–';
    document.getElementById('reviewName').textContent = `${fname} ${lname}`;
    document.getElementById('reviewPhone').textContent = phone;
    document.getElementById('reviewEmail').textContent = email;
}

// ── Service picker visual selection ──────────────────────────────────────
document.querySelectorAll('.thr-service-picker__item').forEach(item => {
    item.addEventListener('click', function() {
        document.querySelectorAll('.thr-service-picker__item').forEach(i => i.classList.remove('selected'));
        this.classList.add('selected');
    });
});

// ── Promo validation (client-side hint only) ──────────────────────────────
function validatePromo() {
    const code = document.getElementById('promoCode').value.toUpperCase().trim();
    const msg  = document.getElementById('promoMsg');
    if (!code) { msg.textContent = 'Please enter a promo code.'; msg.className = 'thr-form__hint thr-form__hint--error'; return; }
    msg.textContent = '✓ Promo code will be applied at checkout if valid.';
    msg.className = 'thr-form__hint thr-form__hint--success';
    document.getElementById('promoCode').value = code;
}
</script>
@endpush
