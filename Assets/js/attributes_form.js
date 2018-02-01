$('.selectize').selectize();
$( document ).ready(function() {
    // $('.dd').nestable();
    $('.jsTypeSelection').on('change', function() {
        if ($(this).find(':selected').data('use-options') === 1) {
            cloneTemplate();
            $('.optionsArea').show();
            $('.noOptionsArea').hide();
        } else {
            $('.optionsArea').hide();
            $('.noOptionsArea').show();
            if ($('.options li').length > 1) {
                $('.options li:last').remove();
            }
        }
    });

    var $body = $('body');

    $body.on('change', '.jsOptionLanguage', function (event) {
        $(this).parent().find('.lang-group').each(function (i ,element) {
            $(element).hide();
        });
        $(this).parent().find('.' + $(this).val()).show();
    });

    $body.on('click', '.jsAddRow', function (event) {
        event.preventDefault();
        incrementItemCount();
        cloneTemplate();
    });
    $body.on('click', '.jsRemoveRow', function (event) {
        event.preventDefault();
        var $row = $(this).closest('.dd-item');
        if ($('.options li').length > 2) {
            $row.fadeOut();
            setTimeout(function() {
                $row.remove();
            }, 300);
            decrementItemCount();
        }
    });

    function cloneTemplate() {
        var clone = $('.jsItemTemplate').clone(),
            $wrapper = $('.jsOptionsWrapper');

        $(clone).find('input').each(function() {
            var text = $(this).attr('name');
            $(this).attr('name', text.replace('count', $wrapper.data('item-count')));
            $(this).attr('id', text.replace('count', $wrapper.data('item-count')));
        });
        $(clone).find('label').each(function() {
            var text = $(this).attr('for');
            $(this).attr('for', text.replace('count', $wrapper.data('item-count')));
        });

        clone.removeClass('jsItemTemplate').removeClass('hidden').appendTo($wrapper);
    }

    function incrementItemCount() {
        var $wrapper = $('.jsOptionsWrapper'),
            currentCount = parseInt($wrapper.data('item-count'));

        $wrapper.data('item-count', currentCount + 1)
    }

    function decrementItemCount() {
        var $wrapper = $('.jsOptionsWrapper'),
            currentCount = parseInt($wrapper.data('item-count'));

        $wrapper.data('item-count', currentCount - 1)
    }
});
