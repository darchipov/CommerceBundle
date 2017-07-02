define(["jquery","routing"],function(a,b){"use strict";return a.fn.saleAddressWidget=function(){return this.each(function(){var c=a(this),d=a("#"+c.data("customer-field")),e=c.find(".sale-address-same"),f=c.find(".sale-address-choice"),g=c.find(".sale-address"),h={company:".address-company",gender:".identity-gender",first_name:".identity-first-name",last_name:".identity-last-name",street:".address-street",supplement:".address-supplement",postal_code:".address-postal-code",city:".address-city",country:".address-country",phone:".address-phone",mobile:".address-mobile"},i=function(){for(var a in h)h.hasOwnProperty(a)&&g.find(h[a]).val(null).trigger("change")};if(1===d.size()&&d.on("change",function(){f.empty().append(a("<option value>Choose</option>")).prop("disabled",!0);var c=a(this).val();if(c){var d=a.get(b.generate("ekyna_commerce_customer_address_admin_choice_list",{customerId:c}));d.done(function(b){if("undefined"!=typeof b.choices){for(var c in b.choices)b.choices.hasOwnProperty(c)&&f.append(a("<option />").attr("value",b.choices[c].id).text(b.choices[c].text).data("address",b.choices[c]));f.prop("disabled",!1)}f.trigger("form_choices_loaded",b)})}}),f.on("change",function(){var a=f.val();if(a){var b=f.find("option[value="+f.val()+"]");if(b.length){var c=b.data("address");if(c&&c.hasOwnProperty("id")){i();for(var d in h)h.hasOwnProperty(d)&&g.find(h[d]).val(c[d]).trigger("change")}}}}),1===e.length){var j=c.find(".sale-address-wrap"),k=function(){e.prop("checked")?j.slideUp(function(){f.length?f.val(null).trigger("change"):i()}):j.slideDown()};e.on("change",k),k()}}),this},{init:function(a){a.saleAddressWidget()}}});