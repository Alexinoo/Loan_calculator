(function ($) {
  $.widget('ui.autocomplete', $.ui.autocomplete, {
    _create: function () {
      if (
        !this.element.hasClass('ui-autocomplete-input') &&
        this.element.val() !== ''
      ) {
        this.previous = this.element.val();
      }

      return this._super();
    },
  });
})($);
