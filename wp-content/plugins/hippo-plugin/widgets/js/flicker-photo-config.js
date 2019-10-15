jQuery(function ($) {

    'use strict';

    // ================================================================
    // Flicker Photo Feed
    // ================================================================
    (function () {

        $('.flicker-photo-stream').jflickrfeed({
            limit        : $('.flicker-photo-stream').attr('data-photo-limit'),
            qstrings     : {
                id : $('.flicker-photo-stream').attr('data-flicker-id')
            },
            itemTemplate : '<li>' +
            '<a href="{{image}}" title="{{title}}">' +
            '<img src="{{image_s}}" alt="{{title}}" />' +
            '</a>' +
            '</li>'
        }, function (container, data) {
            $(document.body).triggerHandler('jflickrfeedloaded', [container, data]);
        });
    }());


});