/**
 * Created by Anna Kriener on 15.06.2015.
 */
$(document).ready(function (){
   var searchRefineButton = $('button#cb-search-refine-button-down');
    var searchRefineDiv = $('div#cb-search-refine');
    var searchForm = $('form#cb-search-form');

    searchRefineDiv.on('show.bs.collapse', function(event) {
        searchForm.fadeOut();
        searchRefineButton.fadeOut();

    }).on('hide.bs.collapse', function(event) {
        searchForm.fadeIn();
        searchRefineButton.fadeIn();
    });
});