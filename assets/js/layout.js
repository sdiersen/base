'use strict';

import $ from 'jquery';
import 'bootstrap';
import '@fortawesome/fontawesome-free/js/all'
import 'bootstrap/dist/css/bootstrap.css';
import '@fortawesome/fontawesome-free/scss/fontawesome.scss'
import '../css/layout.scss';

function resize_until_scrollbar_is_gone(selector) {
    $.each($(selector), function(i, elem) {
        while (elem.clientHeight < elem.scrollHeight) {
            $(elem).height($(elem).height()+5);
        }
    });
}

resize_until_scrollbar_is_gone(".lift-area-grow");




