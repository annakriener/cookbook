var $tagCollectionHolder;
var $addTagButton;
var $newTagButtonDiv;


jQuery(document).ready(function() {
    // setup an "add a tag" link
    $addTagButton = $('<button class="cb-ris-add-tag-button btn-default btn btn-sm">Add a tag</button>');
    $newTagButtonDiv = $('<div></div>').append($addTagButton);

    // Get the ul that holds the collection of tags
    $tagCollectionHolder = $('div#recipe_tags');

    // add a delete link to all of the existing tag form div elements
    $tagCollectionHolder.find('div[id^="recipe_tags_"]:not([id$="tag"])').each(function() {
        addTagFormDeleteButton($(this));
    });

    // add the "add a tag" button and div to the tags div
    $tagCollectionHolder.append($newTagButtonDiv);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $tagCollectionHolder.data('index', $tagCollectionHolder.find('div').length);

    $addTagButton.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addTagForm($tagCollectionHolder, $newTagButtonDiv);
    });

    function addTagForm($tagCollectionHolder, $newTagButtonDiv) {
        // Get the data-prototype explained earlier
        var prototype = $tagCollectionHolder.data('prototype');

        // get the new index
        var index = $tagCollectionHolder.data('index');

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newTagForm = prototype.replace(/__name__/g, index);

        // increase the index with one for the next item
        $tagCollectionHolder.data('index', index + 1);

        // Display the form in the page in an li, before the "Add a tag" link li
        var $newTagFormDiv = $('<div class="cb-ris-new-tag"></div>').append(newTagForm);
        $newTagButtonDiv.before($newTagFormDiv);

        // add a delete link to the new form
        addTagFormDeleteButton($newTagFormDiv);
    }

    function addTagFormDeleteButton(tagFormDiv) {
        var $removeTagFormButton = $('<button class="btn btn-xs cb-ris-delete-new-tag-button"><span class="glyphicon glyphicon-remove"></span></button>');
        tagFormDiv.append($removeTagFormButton);

        $removeTagFormButton.on('click', function (e) {
            // prevent the link from creating a "#" on the URL
            e.preventDefault();

            // remove the li for the tag form
            tagFormDiv.remove();

            $('div#recipe_tags').children('div.form-group').each(function($index, $item) {
                if($(this).children().length === 0) {
                    $(this).remove();
                }
            });
        });
    }
});
