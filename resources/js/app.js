// ─────────────────────────────────────────────────────────────────────────────
// The Healing Room — Main JS Bundle
// ─────────────────────────────────────────────────────────────────────────────

// ── Flash message auto-dismiss ────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    const flashes = document.querySelectorAll('.flash-message');
    flashes.forEach(el => {
        setTimeout(() => {
            el.style.transition = 'opacity .4s ease';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 400);
        }, 4000);
    });
});

// ── Sticky nav: add shadow on scroll (public layout) ─────────────────────────
(function () {
    const nav = document.querySelector('.site-nav');
    if (!nav) return;
    const handler = () => nav.classList.toggle('site-nav--scrolled', window.scrollY > 40);
    window.addEventListener('scroll', handler, { passive: true });
    handler();
})();

// ── Admin sidebar toggle ──────────────────────────────────────────────────────
(function () {
    const toggle  = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.admin-sidebar');
    if (!toggle || !sidebar) return;
    toggle.addEventListener('click', () => sidebar.classList.toggle('admin-sidebar--open'));
    document.addEventListener('click', e => {
        if (sidebar.classList.contains('admin-sidebar--open') &&
            !sidebar.contains(e.target) && e.target !== toggle) {
            sidebar.classList.remove('admin-sidebar--open');
        }
    });
})();

// ── Admin modal: close on backdrop click ─────────────────────────────────────
document.addEventListener('click', e => {
    if (e.target.classList.contains('admin-modal')) {
        e.target.style.display = 'none';
    }
});

// ── Booking Stepper ──────────────────────────────────────────────────────────
(function () {
    if (!document.getElementById('bookingForm')) return;

    const steps      = document.querySelectorAll('.booking-step');
    const indicators = document.querySelectorAll('.stepper__step');
    let current = 0;

    function goTo(n) {
        steps[current].classList.remove('booking-step--active');
        indicators[current].classList.remove('stepper__step--active');
        current = n;
        steps[current].classList.add('booking-step--active');
        indicators[current].classList.add('stepper__step--active');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    document.querySelectorAll('[data-next]').forEach(btn => {
        btn.addEventListener('click', () => {
            const step = parseInt(btn.dataset.next);
            if (step === 1) {
                const selected = document.querySelector('input[name="service_id"]:checked');
                if (!selected) { alert('Please select a service.'); return; }
            }
            if (step === 2) {
                const date = document.getElementById('booking_date')?.value;
                const time = document.getElementById('booking_time')?.value;
                if (!date) { alert('Please select a date.'); return; }
                if (!time) { alert('Please select a time slot.'); return; }
            }
            if (step === 3) {
                populateReview();
            }
            goTo(step);
        });
    });

    document.querySelectorAll('[data-prev]').forEach(btn => {
        btn.addEventListener('click', () => goTo(parseInt(btn.dataset.prev)));
    });

    // ── Booking Calendar ──────────────────────────────────────────────────────
    const calEl     = document.getElementById('bookingCalendar');
    const dateInput = document.getElementById('booking_date');
    const timeInput = document.getElementById('booking_time');
    const slotsEl   = document.getElementById('timeSlotsContainer');
    if (!calEl) return;

    const today = new Date(); today.setHours(0, 0, 0, 0);
    let viewYear  = today.getFullYear();
    let viewMonth = today.getMonth();

    const MONTH_NAMES = ['January','February','March','April','May','June',
                         'July','August','September','October','November','December'];

    function renderCalendar() {
        const first    = new Date(viewYear, viewMonth, 1);
        const daysInMo = new Date(viewYear, viewMonth + 1, 0).getDate();
        const startDay = first.getDay();

        let html = `
        <div class="cal-header">
            <button type="button" class="cal-nav" id="calPrev">&#8249;</button>
            <strong>${MONTH_NAMES[viewMonth]} ${viewYear}</strong>
            <button type="button" class="cal-nav" id="calNext">&#8250;</button>
        </div>
        <div class="cal-grid">
            <div class="cal-dow">Su</div><div class="cal-dow">Mo</div>
            <div class="cal-dow">Tu</div><div class="cal-dow">We</div>
            <div class="cal-dow">Th</div><div class="cal-dow">Fr</div>
            <div class="cal-dow">Sa</div>`;

        for (let i = 0; i < startDay; i++) html += '<div></div>';

        for (let d = 1; d <= daysInMo; d++) {
            const dt  = new Date(viewYear, viewMonth, d);
            const iso = `${viewYear}-${String(viewMonth + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
            const past = dt < today;
            const sel  = dateInput.value === iso;
            html += `<div class="cal-day${past ? ' cal-day--past' : ''}${sel ? ' cal-day--selected' : ''}" data-date="${iso}">${d}</div>`;
        }
        html += '</div>';
        calEl.innerHTML = html;

        document.getElementById('calPrev').addEventListener('click', () => {
            if (viewMonth === 0) { viewMonth = 11; viewYear--; } else viewMonth--;
            renderCalendar();
        });
        document.getElementById('calNext').addEventListener('click', () => {
            if (viewMonth === 11) { viewMonth = 0; viewYear++; } else viewMonth++;
            renderCalendar();
        });

        calEl.querySelectorAll('.cal-day:not(.cal-day--past)').forEach(cell => {
            cell.addEventListener('click', () => {
                dateInput.value = cell.dataset.date;
                timeInput.value = '';
                renderCalendar();
                loadSlots(cell.dataset.date);
            });
        });
    }

    function loadSlots(date) {
        if (!slotsEl) return;
        slotsEl.innerHTML = '<p class="slots-loading">Loading available times…</p>';
        fetch(`/book/slots?date=${date}`)
            .then(r => r.json())
            .then(slots => {
                if (!slots.length) {
                    slotsEl.innerHTML = '<p class="slots-empty">No available slots on this date.</p>';
                    return;
                }
                slotsEl.innerHTML = slots.map(s => `
                    <button type="button"
                        class="slot-btn${s.available ? '' : ' slot-btn--taken'}"
                        data-time="${s.time}"
                        ${s.available ? '' : 'disabled'}>
                        ${s.time}
                    </button>`).join('');

                slotsEl.querySelectorAll('.slot-btn:not(.slot-btn--taken)').forEach(btn => {
                    btn.addEventListener('click', () => {
                        slotsEl.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('slot-btn--active'));
                        btn.classList.add('slot-btn--active');
                        timeInput.value = btn.dataset.time;
                    });
                });
            })
            .catch(() => {
                slotsEl.innerHTML = '<p class="slots-error">Could not load slots. Please try again.</p>';
            });
    }

    renderCalendar();

    // ── Review panel population ───────────────────────────────────────────────
    function populateReview() {
        const serviceLabel = document.querySelector('input[name="service_id"]:checked')
            ?.closest('.service-option')?.querySelector('.service-option__name')?.textContent?.trim() ?? '–';
        const first = document.getElementById('first_name')?.value ?? '';
        const last  = document.getElementById('last_name')?.value ?? '';

        const el = id => document.getElementById(id);
        if (el('reviewService')) el('reviewService').textContent = serviceLabel;
        if (el('reviewDate'))    el('reviewDate').textContent    = dateInput.value || '–';
        if (el('reviewTime'))    el('reviewTime').textContent    = timeInput.value || '–';
        if (el('reviewName'))    el('reviewName').textContent    = `${first} ${last}`.trim() || '–';
    }

    // ── Promo code validation ─────────────────────────────────────────────────
    const promoBtn   = document.getElementById('applyPromoBtn');
    const promoInput = document.getElementById('promo_code');
    const promoMsg   = document.getElementById('promoMessage');

    if (promoBtn && promoInput) {
        promoBtn.addEventListener('click', () => {
            const code = promoInput.value.trim();
            if (!code) return;
            promoBtn.disabled = true;
            promoBtn.textContent = 'Checking…';
            fetch(`/book/promo?code=${encodeURIComponent(code)}`)
                .then(r => r.json())
                .then(data => {
                    if (promoMsg) {
                        promoMsg.className = `promo-msg promo-msg--${data.valid ? 'success' : 'error'}`;
                        promoMsg.textContent = data.message;
                    }
                })
                .catch(() => {
                    if (promoMsg) {
                        promoMsg.className = 'promo-msg promo-msg--error';
                        promoMsg.textContent = 'Could not validate code.';
                    }
                })
                .finally(() => {
                    promoBtn.disabled = false;
                    promoBtn.textContent = 'Apply';
                });
        });
    }
})();

// ── Services category filter (public services page) ───────────────────────────
(function () {
    const tabs = document.querySelectorAll('.cat-tab');
    if (!tabs.length) return;
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('cat-tab--active'));
            tab.classList.add('cat-tab--active');
            const target = tab.dataset.cat;
            document.querySelectorAll('.service-category').forEach(sec => {
                sec.style.display = (target === 'all' || sec.dataset.cat === target) ? '' : 'none';
            });
        });
    });
})();

// ── Testimonials: pause scroll animation on hover ────────────────────────────
(function () {
    const strip = document.querySelector('.testimonials-track');
    if (!strip) return;
    strip.addEventListener('mouseenter', () => strip.style.animationPlayState = 'paused');
    strip.addEventListener('mouseleave', () => strip.style.animationPlayState = 'running');
})();

// ── Admin: reminder SMS / Email toggles (AJAX) ───────────────────────────────
(function () {
    const csrf = () => document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    ['smsToggle', 'emailToggle'].forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('change', () => {
            fetch('/admin/reminders/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf(),
                },
                body: JSON.stringify({ type: id === 'smsToggle' ? 'sms' : 'email', enabled: el.checked }),
            });
        });
    });
})();
