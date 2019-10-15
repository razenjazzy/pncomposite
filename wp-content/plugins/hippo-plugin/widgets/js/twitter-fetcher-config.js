jQuery(function ($) {

    'use strict';

    // ================================================================
    // Twitter Feed on Footer Widget
    // ================================================================

    /**
     * ### HOW TO CREATE A VALID ID TO USE: ###
     * Go to www.twitter.com and sign in as normal, go to your settings page.
     * Go to "Widgets" on the left hand side.
     * Create a new widget for what you need eg "user time line" or "search" etc.
     * Feel free to check "exclude replies" if you don't want replies in results.
     * Now go back to settings page, and then go back to widgets page and
     * you should see the widget you just created. Click edit.
     * Look at the URL in your web browser, you will see a long number like this:
     * 567185781790228482
     * Use this as your ID below instead!
     */


    (function () {

        var selector = $('.twitterWidget');
        var widgetId = selector.attr('data-widget-id');
        var maxTweetNumber = selector.attr('data-max-tweet');
        var twitterConfig = {
            id              : widgetId, //put your widget ID here
            domId           : "twitterWidget",
            maxTweets       : maxTweetNumber,
            enableLinks     : true,
            showUser        : false,
            showTime        : false,
            showInteraction : false,
            customCallback  : function (tweets) {
                var x = tweets.length;
                var n = 0;
                var html = "";
                while (n < x) {
                    html += '<div class="item">' + tweets[n] +
                        "</div>";
                    n++
                }
                $(".twitter-widget").html(html);
                $(".twitter_retweet_icon").html(
                    '<i class="mdi mdi-twitter-retweet"></i>');
                $(".twitter_reply_icon").html(
                    '<i class="mdi mdi-replay"></i>');
                $(".twitter_fav_icon").html(
                    '<i class="mdi mdi-star"></i>');
                $(".twitter-widget").owlCarousel({
                    pagination : false,
                    items      : 1,
                    singleItem : true,
                    autoPlay   : true
                });
            }
        };

        twitterFetcher.fetch(twitterConfig);
    }());

});