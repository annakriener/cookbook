/**
 * Created by Anna Kriener on 21.06.2015.
 */
$(document).ready(function() {

    $('#cb-lightbox').hide();

    $('.cb-lightbox-trigger').click(function(event) {
        event.preventDefault();

        var imgHref = $(this).attr('href');
        var lightbox = $('#cb-lightbox');

        if(lightbox.length > 0) {
            $('#cb-lightbox-content').html('<img src="'+imgHref+'">');
            lightbox.fadeIn();
        } else {
            var test =
                '<div id="lightbox">' +
                '<p>Click to close</p>' +
                '<div id="content">' + //insert clicked link's href into img src
                '<img src="' + image_href +'" />' +
                '</div>' +
                '</div>';

            //insert lightbox HTML into page
            $('body').append(test);
        }
    });



});