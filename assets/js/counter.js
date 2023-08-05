import $ from 'jquery';
import 'waypoints/lib/jquery.waypoints';
import 'jquery.counterup';

$(document).ready(function () {
    $('.counter').counterUp({
        delay: 10,
        time: 1000,
    });
});