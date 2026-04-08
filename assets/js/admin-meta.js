/**
 * admin-meta.js
 * - Meta boxes Projet : sections, images, couverture
 * - Page JTT Options : boutons médiathèque pour hero_bg_image et about_image
 */
jQuery(function ($) {

    // ================================================================
    // UTILITAIRE : ouvre la médiathèque et retourne l'URL choisie
    // ================================================================
    function pickImage(opts) {
        var frame = wp.media({
            title:    opts.title   || 'Choisir une image',
            button:   { text: opts.btn || 'Utiliser cette image' },
            multiple: false,
            library:  { type: 'image' }
        });
        frame.on('select', function () {
            var att = frame.state().get('selection').first().toJSON();
            var url = (att.sizes && att.sizes.large) ? att.sizes.large.url : att.url;
            opts.onSelect(url, att);
        });
        frame.open();
        return frame;
    }

    // ================================================================
    // PAGE JTT OPTIONS (Réglages → JTT Options)
    // ================================================================

    // Générique : chaque bouton [data-pick] cible un input + un preview
    // Structure attendue dans le HTML :
    //   <input type="text" id="jtt-field-{key}" name="jtt_options[{key}]" />
    //   <img   id="jtt-preview-{key}" />
    //   <button data-pick="{key}">Choisir…</button>
    $(document).on('click', '[data-jtt-pick]', function () {
        var key = $(this).data('jtt-pick');
        pickImage({
            title: 'Choisir l\'image',
            btn:   'Utiliser cette image',
            onSelect: function (url) {
                $('#jtt-field-' + key).val(url);
                var $prev = $('#jtt-preview-' + key);
                $prev.attr('src', url).show();
            }
        });
    });

    // Mise à jour live de la preview quand on tape une URL manuellement
    $(document).on('input', '[id^="jtt-field-"]', function () {
        var key = this.id.replace('jtt-field-', '');
        var url = $(this).val();
        var $prev = $('#jtt-preview-' + key);
        if (url) $prev.attr('src', url).show();
        else $prev.hide();
    });


    // ================================================================
    // META BOXES PROJET
    // ================================================================

    // ── Sérialisation JSON → champ caché ─────────────────────────
    function serialize() {
        var sections = [];
        $('#jtt-sections-list .jtt-section-item').each(function () {
            var $s = $(this);
            var imgs = [];
            $s.find('.jtt-img-thumb').each(function () {
                var url = $(this).find('.jtt-img-url').val();
                var alt = $(this).find('.jtt-img-alt').val();
                if (url) imgs.push({ url: url, alt: alt });
            });
            sections.push({
                titre:  $s.find('.jtt-s-titre').val(),
                type:   $s.find('.jtt-s-type').val(),
                texte:  $s.find('.jtt-s-texte').val(),
                images: imgs
            });
        });
        $('#jtt-sections-json').val(JSON.stringify(sections));
    }
    $('form#post').on('submit', serialize);

    // ── HTML d'une nouvelle section vide ────────────────────────
    function newSectionHtml(index) {
        return [
            '<div class="jtt-section-item" data-index="' + index + '">',
            '<h4><span class="jtt-section-handle">☰</span>',
            '<span class="jtt-section-num">' + (index + 1) + '</span> Section</h4>',
            '<button type="button" class="jtt-section-rm" data-action="remove-section">&times; Supprimer</button>',
            '<div class="jtt-si-row"><label>Titre de la section</label>',
            '<input type="text" class="jtt-s-titre" placeholder="ex. Moodboard, Shooting…" /></div>',
            '<div class="jtt-si-row"><label>Type</label><select class="jtt-s-type">',
            '<option value="galerie">Galerie d\'images uniquement</option>',
            '<option value="texte">Texte uniquement</option>',
            '<option value="galerie-texte">Images + Texte</option>',
            '</select></div>',
            '<div class="jtt-si-row"><label>Texte (optionnel)</label>',
            '<textarea class="jtt-s-texte"></textarea></div>',
            '<div class="jtt-si-row"><label>Images</label>',
            '<div class="jtt-images-list"></div>',
            '<button type="button" class="button jtt-add-imgs" style="margin-top:8px;font-size:12px;">+ Ajouter des images</button>',
            '</div></div>'
        ].join('');
    }

    $(document).on('click', '.jtt-add-section', function () {
        var count = $('#jtt-sections-list .jtt-section-item').length;
        $('#jtt-sections-list').append(newSectionHtml(count));
        renumber();
    });

    $(document).on('click', '[data-action="remove-section"]', function () {
        if (!confirm('Supprimer cette section ?')) return;
        $(this).closest('.jtt-section-item').remove();
        renumber();
    });

    $(document).on('click', '[data-action="remove-img"]', function () {
        $(this).closest('.jtt-img-thumb').remove();
    });

    function renumber() {
        $('#jtt-sections-list .jtt-section-item').each(function (i) {
            $(this).attr('data-index', i).find('.jtt-section-num').text(i + 1);
        });
    }

    // ── Sélecteur multi-images pour les sections ───────────────────
    var mediaFrame = null;
    var $currentSection = null;

    $(document).on('click', '.jtt-add-imgs', function () {
        $currentSection = $(this).closest('.jtt-section-item');
        if (mediaFrame) { mediaFrame.open(); return; }
        mediaFrame = wp.media({
            title:    'Sélectionner les images',
            button:   { text: 'Ajouter les images sélectionnées' },
            multiple: true,
            library:  { type: 'image' }
        });
        mediaFrame.on('select', function () {
            var attachments = mediaFrame.state().get('selection').toArray();
            var $list = $currentSection.find('.jtt-images-list');
            attachments.forEach(function (attachment) {
                var data = attachment.toJSON();
                var url  = data.sizes && data.sizes.large ? data.sizes.large.url : data.url;
                var alt  = data.alt || data.title || '';
                $list.append(
                    '<div class="jtt-img-thumb">' +
                    '<img src="' + url + '" alt="' + alt + '" />' +
                    '<input type="hidden" class="jtt-img-url" value="' + url + '" />' +
                    '<input type="hidden" class="jtt-img-alt" value="' + alt + '" />' +
                    '<button type="button" class="jtt-img-rm" data-action="remove-img" title="Supprimer">&times;</button>' +
                    '</div>'
                );
            });
        });
        mediaFrame.open();
    });

    // ── Image de couverture externe (meta box projet) ──────────────
    $('#jtt-pick-cover').on('click', function () {
        pickImage({
            title: 'Choisir l\'image de couverture',
            btn:   'Utiliser cette image',
            onSelect: function (url) {
                $('#jtt-ext-url').val(url);
                $('#jtt-cover-preview').attr('src', url).show();
            }
        });
    });

    $('#jtt-ext-url').on('input', function () {
        var url = $(this).val();
        if (url) $('#jtt-cover-preview').attr('src', url).show();
        else $('#jtt-cover-preview').hide();
    });

    // Drag & drop réordonnement sections
    if ($.fn.sortable) {
        $('#jtt-sections-list').sortable({ handle: '.jtt-section-handle', update: renumber });
    }

});
