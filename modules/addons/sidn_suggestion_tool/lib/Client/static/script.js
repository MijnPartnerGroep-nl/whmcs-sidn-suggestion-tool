$(()=>{
    const container = document.querySelector(".sidn-suggestions") || false;
    const input = document.getElementById("inputDomain") || false;
    if(container && input) {
        fetch("index.php?m=sidn_suggestion_tool&a=fetch", {
            method: 'POST',
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({lookupTerm: input.value})
        })
        .then((res)  => res.json())
        .then(data => {
            if(typeof(data.message) != "undefined"){
                container.innerText = data.message;
            } else if(typeof(data.suggestions) != "undefined") {
                for(let s in data.suggestions) {
                    let suggestion = data.suggestions[s];
                    let item = container.querySelector(".list-group-item").cloneNode(true);
                    
                    item.classList.remove("w-hidden");

                    item.querySelector(".domain").innerText = suggestion.domain;
                    item.querySelector(".extension").innerText = suggestion.extension;

                    item.querySelector(".price").innerText = suggestion.price;
                    item.querySelector(".btn-add-to-cart").dataset.domain=suggestion.domain+suggestion.extension;

                    container.appendChild(item);
                }
            }
            jQuery('.btn-add-to-cart').on('click', function () {
                if (jQuery(this).hasClass('checkout')) return void (window.location = 'cart.php?a=confdomains');
                var e = jQuery(this).attr('data-domain'),
                t = jQuery('button[data-domain="' + e + '"]'),
                n = jQuery(this).attr('data-whois'),
                i = jQuery(this).hasClass('product-domain'),
                a = jQuery('#btnDomainContinue'),
                r = jQuery('#resultDomain'),
                o = jQuery('#resultDomainPricingTerm'),
                s = jQuery('#idnLanguageSelector'),
                d = s.find('select');
                if (s.is(':visible') && !d.val()) return void d.showInputError();
                t.find('span.to-add').hide(),
                t.find('span.loading').show();
                var l = jQuery(this).parents('.spotlight-tlds').length > 0 || jQuery(this).parents('.suggested-domains').length > 0 ? 1 : 0;
                WHMCS.http.jqClient.post(window.location.pathname, {
                  a: 'addToCart',
                  domain: e,
                  token: csrfToken,
                  whois: n,
                  sideorder: l,
                  idnlanguage: d.val()
                }, 'json').done(function (n) {
                  t.find('span.loading').hide(),
                  'added' === n.result ? (t.find('span.added').show(), i || t.removeAttr('disabled').addClass('checkout'), r.length && !r.val() && (r.val(e), o.val(n.period).attr('name', 'domainsregperiod[' + e + ']'), a.length > 0 && a.is(':disabled') && a.removeAttr('disabled')), jQuery('#cartItemCount').html(n.cartCount)) : (t.find('span.available.price').hide(), t.find('span.unavailable').show(), t.attr('disabled', 'disabled'))
                })
            });
        });
    }
});
