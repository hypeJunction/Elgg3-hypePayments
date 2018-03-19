define(function(require) {

	var $ = require('jquery');
	var Ajax = require('elgg/Ajax');

	$(document).on('change', '.payments-method-selector-input', function() {
		var $elem = $(this);
		var $form = $(this).closest('form');

		$form.find('[type="submit"]').prop('disabled', false);

		$('.payments-method-selector-input:not(:checked)', $form).siblings().find('.payments-method-data').html('');

		var $selected = $('.payments-method-selector-input:checked', $form).eq(0);

		if ($selected.data('view')) {
			var ajax = new Ajax(false);

			$selected.siblings().find('.payments-method-data').html($('<div class="elgg-ajax-loader" />'));

			ajax.view($selected.data('view'), {
				data: $elem.data('config')
			}).done(function(output) {
				$selected.siblings().find('.payments-method-data').html($(output));
			});
		}
	});

});