/*
 * Central Build motion layer (GSAP 3 + ScrollTrigger).
 *
 * - Hero: staggered entrance on load.
 * - Section heads, cards, project tiles, steps, lists, photos, videos, forms: reveal once when
 *   they scroll into view, in small staggered batches.
 * - Steps: the orange line draws in. Facts: numbers count up.
 * - Header gets a shadow once the page scrolls.
 *
 * Content is only hidden while <html> has the "cb-motion" class, which is set in <head> only when
 * the visitor has not asked for reduced motion, and removed again if GSAP fails to load.
 */
(function () {
    'use strict';

    var root = document.documentElement;
    if (!root.classList.contains('cb-motion')) {
        return;
    }
    if (!window.gsap || !window.ScrollTrigger) {
        root.classList.remove('cb-motion');
        return;
    }
    var gsap = window.gsap;
    gsap.registerPlugin(window.ScrollTrigger);

    var EASE = 'power3.out';
    var $$ = function (sel, ctx) { return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); };
    var shown = function (els) {
        // Keep opacity at 1 (the CSS start state is 0) and hand transforms back to the hover styles.
        gsap.set(els, { clearProps: 'transform,clipPath' });
    };

    /* ---------------------------------------------------------------- hero */
    $$('.cb-hero').forEach(function (hero) {
        var items = $$('.cb-hero__inner > *', hero);
        gsap.fromTo(items, { y: 28, opacity: 0 }, {
            y: 0, opacity: 1, duration: 0.9, ease: EASE, stagger: 0.09, delay: 0.1,
            onComplete: function () { shown(items); }
        });
        gsap.fromTo(hero, { backgroundSize: '112%' }, { backgroundSize: '100%', duration: 2.2, ease: 'power2.out', clearProps: 'backgroundSize' });
    });

    /* ---------------------------------------------------------------- generic reveal in batches */
    function reveal(selector, from, opts) {
        var els = $$(selector);
        if (!els.length) {
            return;
        }
        gsap.set(els, from);
        window.ScrollTrigger.batch(els, {
            start: (opts && opts.start) || 'top 88%',
            once: true,
            onEnter: function (batch) {
                gsap.to(batch, {
                    opacity: 1, y: 0, x: 0, scale: 1, clipPath: 'inset(0% 0% 0% 0%)',
                    duration: (opts && opts.duration) || 0.8,
                    ease: EASE,
                    stagger: (opts && opts.stagger) || 0.08,
                    overwrite: true,
                    onComplete: function () { shown(batch); }
                });
            }
        });
    }

    reveal('.cb-head > div > *, .cb-head > .cb-lead, .cb-head > .cb-btns', { y: 26, opacity: 0 }, { stagger: 0.07 });
    reveal('.cb-card', { y: 34, opacity: 0 }, { stagger: 0.07 });
    reveal('.cb-tile', { y: 40, opacity: 0 }, { stagger: 0.1, duration: 0.9 });
    reveal('.cb-split__body > *, .cb-list li', { y: 22, opacity: 0 }, { stagger: 0.06 });
    reveal('.cb-split__media', { opacity: 0, clipPath: 'inset(0% 0% 18% 0%)', scale: 1.04 }, { duration: 1.1 });
    reveal('.cb-video', { y: 30, opacity: 0, scale: 0.97 }, { stagger: 0.12, duration: 0.9 });
    reveal('.cb-gallery a', { y: 30, opacity: 0 }, { stagger: 0.05, start: 'top 94%' });
    reveal('.cb-photos img', { y: 30, opacity: 0 }, { stagger: 0.1 });
    reveal('.cb-faq details', { y: 18, opacity: 0 }, { stagger: 0.06 });
    reveal('.cb-contact__aside > *, .cb-form', { y: 26, opacity: 0 }, { stagger: 0.08 });
    reveal('.cb-cta > *', { y: 26, opacity: 0 }, { stagger: 0.1 });
    reveal('.cb-trust__list li, .cb-trust .cb-link', { y: 16, opacity: 0 }, { stagger: 0.07, start: 'top 95%' });
    reveal('.cb-filter a', { y: 12, opacity: 0 }, { stagger: 0.05, start: 'top 95%' });

    /* ---------------------------------------------------------------- steps: number + drawing line */
    $$('.cb-steps').forEach(function (list) {
        var items = $$('li', list);
        gsap.set(items, { y: 24, opacity: 0, '--cb-line': 0 });
        window.ScrollTrigger.create({
            trigger: list, start: 'top 85%', once: true,
            onEnter: function () {
                gsap.to(items, {
                    y: 0, opacity: 1, '--cb-line': 1, duration: 0.9, ease: EASE, stagger: 0.12,
                    onComplete: function () { shown(items); }
                });
            }
        });
    });

    /* ---------------------------------------------------------------- facts: count up the leading number */
    $$('.cb-fact').forEach(function (fact) {
        var b = fact.querySelector('b');
        if (!b) {
            return;
        }
        var text = b.textContent;
        var m = text.match(/^(\D*?)(\d[\d,]*(?:\.\d+)?)(.*)$/);
        gsap.set(fact, { y: 18, opacity: 0 });
        window.ScrollTrigger.create({
            trigger: fact, start: 'top 92%', once: true,
            onEnter: function () {
                gsap.to(fact, { y: 0, opacity: 1, duration: 0.7, ease: EASE, onComplete: function () { shown(fact); } });
                // Years ("Jul 2026") and other plain labels are shown as they are, not counted.
                if (!m || /^(19|20)\d{2}$/.test(m[2])) {
                    return;
                }
                var target = parseFloat(m[2].replace(/,/g, ''));
                var decimals = (m[2].split('.')[1] || '').length;
                var useComma = m[2].indexOf(',') !== -1 || target >= 10000;
                var counter = { v: 0 };
                gsap.to(counter, {
                    v: target, duration: 1.4, ease: 'power2.out',
                    onUpdate: function () {
                        var n = counter.v.toFixed(decimals);
                        if (useComma) {
                            n = Number(n).toLocaleString('en-AU', { minimumFractionDigits: decimals, maximumFractionDigits: decimals });
                        }
                        b.textContent = m[1] + n + m[3];
                    },
                    onComplete: function () { b.textContent = text; }
                });
            }
        });
    });

    /* ---------------------------------------------------------------- header shadow on scroll */
    var header = document.querySelector('header');
    if (header) {
        window.ScrollTrigger.create({
            start: 80,
            onToggle: function (self) { header.classList.toggle('cb-header-scrolled', self.isActive); }
        });
    }

    window.cbMotionReady = true;

    // Images and fonts change heights after load: recalculate trigger positions once.
    window.addEventListener('load', function () { window.ScrollTrigger.refresh(); });
})();
