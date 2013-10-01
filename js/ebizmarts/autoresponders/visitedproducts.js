function markVisited(productID) {
    new Ajax.Request('../index.php/ebizautoresponder/autoresponder/markVisitedProducts?product_id='+productID, { method:'get', onSuccess: function(transport){
    }
    });
}
(function() {
    var cb = function() {
        var productID = $$('input[name^=product]').first().value;
        //Making a fix based on the solution proposed by the support team in  http://ebizmarts.com/forums/topics/view/8135
        new Ajax.Request('../ebizautoresponder/autoresponder/getVisitedProductsConfig?product_id='+productID, { method:'get', onSuccess: function(transport){
                if(transport.responseJSON.time > -1) {
                    markVisited.delay(transport.responseJSON.time,productID);
                }
            }
        });
    };
    if (document.loaded) {
        cb();
    } else {
        document.observe('dom:loaded', cb);
    }
})();