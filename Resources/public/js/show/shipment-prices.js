define(["jquery"],function(a){"use strict";a(".commerce-shipment-prices").each(function(){function b(){c=e.val(),f.find("tbody > tr").hide().filter(function(){return a(this).data(g)==c}).show()}var c,d=a(this),e=d.find(".shipment-price-filter").eq(0),f=d.find(".shipment-price-list").eq(0),g=e.data("filter-by");e.on("change",b),b()})});