define(['jquery'], function($) {
    "use strict";

    $('.commerce-shipment-prices').each(function() {

        var $this = $(this),
            $filter = $this.find('.shipment-price-filter').eq(0),
            $list = $this.find('.shipment-price-list').eq(0),
            filterBy = $filter.data('filter-by'),
            filterValue;

        // Prices collection children visibility
        function togglePricesVisibility() {
            filterValue = $filter.val();
            $list
                .find('tbody > tr')
                .hide()
                .filter(function() { return $(this).data(filterBy) == filterValue; })
                .show();
        }

        $filter.on('change', togglePricesVisibility);

        togglePricesVisibility();
    });

});
