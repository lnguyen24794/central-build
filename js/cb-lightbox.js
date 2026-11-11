/*
 * Project gallery lightbox: clicking a photo opens it large in a modal instead of the image file.
 * Arrows / swipe move between photos, Esc or the backdrop closes. Without JavaScript the links
 * still open the photo, so nothing breaks.
 */
(function () {
    'use strict';

    var gallery = document.querySelector('.cb-gallery');
    if (!gallery || typeof HTMLDialogElement === 'undefined') {
        return;
    }
    var links = Array.prototype.slice.call(gallery.querySelectorAll('a[href]'));
    if (!links.length) {
        return;
    }

    var dialog = document.createElement('dialog');
    dialog.className = 'cb-lightbox';
    dialog.setAttribute('aria-label', 'Project photo');
    dialog.innerHTML =
        '<figure class="cb-lightbox__stage"><img class="cb-lightbox__img" alt=""></figure>' +
        '<p class="cb-lightbox__count" aria-live="polite"></p>' +
        '<button type="button" class="cb-lightbox__btn cb-lightbox__close" aria-label="Close"><i class="fas fa-times" aria-hidden="true"></i></button>' +
        '<button type="button" class="cb-lightbox__btn cb-lightbox__prev" aria-label="Previous photo"><i class="fas fa-chevron-left" aria-hidden="true"></i></button>' +
        '<button type="button" class="cb-lightbox__btn cb-lightbox__next" aria-label="Next photo"><i class="fas fa-chevron-right" aria-hidden="true"></i></button>';
    document.body.appendChild(dialog);

    var img = dialog.querySelector('.cb-lightbox__img');
    var count = dialog.querySelector('.cb-lightbox__count');
    var prev = dialog.querySelector('.cb-lightbox__prev');
    var next = dialog.querySelector('.cb-lightbox__next');
    var index = 0;
    var opener = null;

    if (links.length < 2) {
        prev.hidden = true;
        next.hidden = true;
    }

    function show(i) {
        index = (i + links.length) % links.length;
        var link = links[index];
        var thumb = link.querySelector('img');
        dialog.classList.add('is-loading');
        img.onload = function () { dialog.classList.remove('is-loading'); };
        img.src = link.getAttribute('href');
        img.alt = thumb ? thumb.getAttribute('alt') || '' : '';
        count.textContent = (index + 1) + ' / ' + links.length;
        // Preload the neighbours so moving between photos feels instant.
        [index + 1, index - 1].forEach(function (n) {
            var l = links[(n + links.length) % links.length];
            if (l) { (new Image()).src = l.getAttribute('href'); }
        });
    }

    function open(i, trigger) {
        opener = trigger || null;
        show(i);
        dialog.showModal();
        document.documentElement.classList.add('cb-lightbox-open');
    }

    function close() {
        dialog.close();
    }

    dialog.addEventListener('close', function () {
        document.documentElement.classList.remove('cb-lightbox-open');
        img.removeAttribute('src');
        if (opener) { opener.focus(); }
    });

    links.forEach(function (link, i) {
        link.addEventListener('click', function (e) {
            if (e.metaKey || e.ctrlKey || e.shiftKey || e.button === 1) {
                return; // let people open the photo in a new tab on purpose
            }
            e.preventDefault();
            open(i, link);
        });
    });

    prev.addEventListener('click', function () { show(index - 1); });
    next.addEventListener('click', function () { show(index + 1); });
    dialog.querySelector('.cb-lightbox__close').addEventListener('click', close);

    // Click on the dark backdrop (not the photo or a button) closes.
    dialog.addEventListener('click', function (e) {
        if (e.target === dialog || e.target.classList.contains('cb-lightbox__stage')) {
            close();
        }
    });

    dialog.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowLeft') { e.preventDefault(); show(index - 1); }
        if (e.key === 'ArrowRight') { e.preventDefault(); show(index + 1); }
    });

    // Swipe on phones.
    var startX = null;
    dialog.addEventListener('touchstart', function (e) { startX = e.touches[0].clientX; }, { passive: true });
    dialog.addEventListener('touchend', function (e) {
        if (startX === null) { return; }
        var dx = e.changedTouches[0].clientX - startX;
        if (Math.abs(dx) > 50) { show(index + (dx < 0 ? 1 : -1)); }
        startX = null;
    });
})();
