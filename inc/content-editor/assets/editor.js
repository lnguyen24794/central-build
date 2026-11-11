/* Website Content editor */
(function ($) {
  'use strict';

  var $root = $('.cb-ce--page');
  if (!$root.length) { return; }
  var $form = $('#cb-ce-form');
  var dirty = false;

  function setDirty() {
    if (dirty) { return; }
    dirty = true;
    $root.addClass('is-dirty');
    $root.find('.cb-ce__dirty').prop('hidden', false);
  }

  $form.on('input change', ':input', setDirty);

  window.addEventListener('beforeunload', function (e) {
    if (dirty) { e.preventDefault(); e.returnValue = ''; }
  });

  $form.on('submit', function () {
    dirty = false;
    var open = $form.find('.cb-ce__section[open]').last().data('section') || '';
    $form.find('[name=cb_open]').val(open);
    $form.find('.cb-ce__tpl').remove(); // never submit item templates
    $form.find('button[type=submit]').prop('disabled', true).text('Saving…');
  });

  $('#cb-ce-restore').on('submit', function (e) {
    if (!window.confirm($(this).data('confirm'))) { e.preventDefault(); return; }
    dirty = false;
  });

  /* ------------------------------------------------ Repeaters */
  function escapeRe(s) { return s.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); }

  function reindex($rep) {
    var base = $rep.attr('data-base');
    var re = new RegExp('^' + escapeRe(base) + '\\[(\\d+|__i__)\\]');
    $rep.children('.cb-ce__items').children('.cb-ce__item').each(function (i) {
      var repl = base + '[' + i + ']';
      $(this).find('[name]').each(function () {
        this.name = this.name.replace(re, repl);
      });
      $(this).find('[data-base]').each(function () {
        $(this).attr('data-base', $(this).attr('data-base').replace(re, repl));
      });
    });
    $rep.find('> .cb-ce__repeater-label small').text('(' + $rep.children('.cb-ce__items').children().length + ')');
  }

  $form.on('click', '.cb-ce__item-toggle', function () {
    var $item = $(this).closest('.cb-ce__item');
    $item.toggleClass('is-open');
    $(this).attr('aria-expanded', $item.hasClass('is-open'));
  });

  $form.on('click', '.cb-ce__add', function () {
    var $rep = $(this).closest('.cb-ce__repeater');
    var html = $rep.children('.cb-ce__tpl').html();
    var $item = $($.parseHTML(html.trim(), document, false)).filter('.cb-ce__item');
    $item.addClass('is-open is-new').find('.cb-ce__item-title').text('New item');
    $rep.children('.cb-ce__items').append($item);
    reindex($rep);
    $item.find('input[type=text],textarea').first().trigger('focus');
    setDirty();
  });

  $form.on('click', '.cb-ce__remove', function () {
    var $item = $(this).closest('.cb-ce__item');
    var title = $item.find('.cb-ce__item-title').first().text();
    if (!window.confirm('Remove "' + title + '"?\n\nIt will disappear from the website when you press Save changes.')) { return; }
    var $rep = $item.closest('.cb-ce__repeater');
    $item.remove();
    reindex($rep);
    setDirty();
  });

  $form.on('click', '.cb-ce__move', function () {
    var $item = $(this).closest('.cb-ce__item');
    if ($(this).data('dir') === 'up') { $item.prev('.cb-ce__item').before($item); }
    else { $item.next('.cb-ce__item').after($item); }
    reindex($item.closest('.cb-ce__repeater'));
    setDirty();
  });

  // Keep the item heading in sync with its first text field.
  $form.on('input', '.cb-ce__item-body input[type=text], .cb-ce__item-body textarea', function () {
    var $item = $(this).closest('.cb-ce__item');
    var $first = $item.children('.cb-ce__item-body').find('input[type=text],textarea').first();
    if (this === $first[0]) {
      $item.find('> .cb-ce__item-head .cb-ce__item-title').text($(this).val().replace(/[*]/g, '').slice(0, 60) || 'New item');
    }
  });

  /* ------------------------------------------------ Images */
  var frame;
  $form.on('click', '.cb-ce__image-choose', function () {
    var $field = $(this).closest('.cb-ce__image');
    frame = wp.media({ title: 'Choose an image', button: { text: 'Use this image' }, library: { type: 'image' }, multiple: false });
    frame.on('select', function () {
      var att = frame.state().get('selection').first().toJSON();
      var url = (att.sizes && att.sizes.large) ? att.sizes.large.url : att.url;
      if (att.sizes && att.sizes.full && att.width <= 2560) { url = att.sizes.full.url; }
      $field.find('.cb-ce__image-input').val(url).trigger('change');
      $field.find('.cb-ce__image-preview').html('<img src="' + url + '" alt="">');
      $field.addClass('has-image').find('.cb-ce__image-choose').text('Change image');
    });
    frame.open();
  });

  $form.on('click', '.cb-ce__image-remove', function () {
    var $field = $(this).closest('.cb-ce__image');
    $field.find('.cb-ce__image-input').val('').trigger('change');
    $field.find('.cb-ce__image-preview').html('<span>No image</span>');
    $field.removeClass('has-image').find('.cb-ce__image-choose').text('Choose image');
  });

  /* ------------------------------------------------ Icons */
  var $palette = $('.cb-ce__palette');
  var $iconField = null;
  $form.on('click', '.cb-ce__icon-btn', function () {
    $iconField = $(this).closest('.cb-ce__icon-field');
    var current = $iconField.find('.cb-ce__icon-input').val();
    $palette.find('button[data-icon]').removeClass('is-current').filter(function () { return $(this).data('icon') === current; }).addClass('is-current');
    $palette.prop('hidden', false);
  });
  $palette.on('click', 'button[data-icon]', function () {
    if (!$iconField) { return; }
    var icon = $(this).data('icon');
    $iconField.find('.cb-ce__icon-input').val(icon).trigger('change');
    $iconField.find('.cb-ce__icon-preview').html('<i class="' + icon + '"></i>');
    $palette.prop('hidden', true);
  });
  $palette.on('click', function (e) {
    if (e.target === this || $(e.target).hasClass('cb-ce__palette-close')) { $palette.prop('hidden', true); }
  });
  $(document).on('keydown', function (e) { if (e.key === 'Escape') { $palette.prop('hidden', true); } });

  /* ------------------------------------------------ Open section from URL hash */
  if (location.hash && location.hash.indexOf('#section-') === 0) {
    var el = document.getElementById(location.hash.slice(1));
    if (el) { el.open = true; setTimeout(function () { el.scrollIntoView({ block: 'start' }); }, 50); }
  }
})(jQuery);
