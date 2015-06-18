var $ingredientCollectionHolder;

// setup an "add a ingredient" link
var $addIngredientButton = $('<button class="cb-ris-add-ingredient-button btn-default btn-sm btn">Add a ingredient</button>');
var $newIngredientButtonDiv = $('<div></div>').append($addIngredientButton);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of ingredients
    $ingredientCollectionHolder = $('div#recipe_ingredients');

    // add a delete link to all of the existing ingredient form div elements
    $ingredientCollectionHolder.find('div[id^="recipe_ingredients_"]:not([id$="ingredient"])').each(function() {
        addIngredientFormDeleteButton($(this));
    });

    // add the "add a ingredient" button and div to the ingredients div
    $ingredientCollectionHolder.append($newIngredientButtonDiv);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $ingredientCollectionHolder.data('index', $ingredientCollectionHolder.find(':input').length);

    $addIngredientButton.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new ingredient form (see next code block)
        addIngredientForm($ingredientCollectionHolder, $newIngredientButtonDiv);
    });

    function addIngredientForm($ingredientCollectionHolder, $newIngredientButtonDiv) {
        // Get the data-prototype explained earlier
        var prototype = $ingredientCollectionHolder.data('prototype');

        // get the new index
        var index = $ingredientCollectionHolder.data('index');

        console.log(index);
        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newIngredientForm = prototype.replace(/__name__/g, index);

        // increase the index with one for the next item
        $ingredientCollectionHolder.data('index', index + 1);

        // Display the form in the page in an li, before the "Add a ingredient" link li
        var $newIngredientFormDiv = $('<div class="cb-ris-new-ingredient"></div>').append(newIngredientForm);
        $newIngredientButtonDiv.before($newIngredientFormDiv);

        // add a delete link to the new form
        addIngredientFormDeleteButton($newIngredientFormDiv);
    }

    function addIngredientFormDeleteButton(ingredientFormDiv) {
        var $removeIngredientFormButton = $('<button class="btn btn-xs cb-ris-delete-new-ingredient-button"><span class="glyphicon glyphicon-remove"></span></button>');
        ingredientFormDiv.append($removeIngredientFormButton);

        $removeIngredientFormButton.on('click', function (e) {
            // prevent the link from creating a "#" on the URL
            e.preventDefault();

            // remove the li for the ingredient form
            ingredientFormDiv.remove();

            $('div#recipe_ingredients').children('div.form-group').each(function($index, $item) {
                if($(this).children().length === 0) {
                    $(this).remove();
                }
            });

        });
    }

    /* initially show one ingredient-input field */
    (function() {
        if(pathname === "/addRecipe" && $('div#recipe_ingredients').children().length <= 1) {
            $addIngredientButton.click();
        }
    }());
});
