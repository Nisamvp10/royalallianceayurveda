var App = (function ($) {
    let siteUrl = '';
    let custUrl = '';

    return {
        init: function (config) {
            siteUrl = config.siteUrl || '';
            custUrl  = config.cust || '';
        },

        // 🔹 Getters
        getSiteurl: function () {
            return siteUrl;
        },

        getCut: function () {
            return custUrl;
        },

        cit: function (path = '') {
            if (!siteUrl.endsWith('/')) siteUrl += '/';
            if (path.startsWith('/')) path = path.substring(1);
            return siteUrl + path;
        },

        cust: function (path = '') {
            if (!custUrl.endsWith('/')) custUrl += '/';
            if (path.startsWith('/')) path = path.substring(1);
            return custUrl + path;
        }
    };
})(jQuery);