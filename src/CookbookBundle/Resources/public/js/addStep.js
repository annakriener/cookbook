var $instructionCollectionHolder;

// setup an "add a step" link
var $addStepButton = $('<button class="cb-ris-add-step-button btn-default btn btn-sm">Add a step</button>');
var $newStepButtonDiv = $('<div></div>').append($addStepButton);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of steps
    $instructionCollectionHolder = $('div#recipe_instructions');

    // add a delete link to all of the existing instruction form div elements
    $instructionCollectionHolder.find('div').each(function() {
        addStepFormDeleteButton($(this));
    });

    // add the "add a step" button and div to the instructions div
    $instructionCollectionHolder.append($newStepButtonDiv);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $instructionCollectionHolder.data('index', $instructionCollectionHolder.find('textarea').length + 1);

    $addStepButton.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new step form (see next code block)
        addStepForm($instructionCollectionHolder, $newStepButtonDiv);
    });


    //addInstructionForm($instructionCollectionHolder, $newStepButtonDiv);
});

function addStepForm($instructionCollectionHolder, $newStepButtonDiv) {
    // Get the data-prototype explained earlier
    var prototype = $instructionCollectionHolder.data('prototype');

    // get the new index
    var index = $instructionCollectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newStepForm = prototype.replace(/__name__/g, index);
    newStepForm = newStepForm.replace(/label__/g, ". Step");

    // increase the index with one for the next item
    $instructionCollectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a step" link li
    var $newStepFormDiv = $('<div></div>').append(newStepForm);
    $newStepButtonDiv.before($newStepFormDiv);

    // add a delete link to the new form
    addStepFormDeleteButton($newStepFormDiv);
}

function addStepFormDeleteButton(stepFormDiv) {
    var $removeStepFormButton = $('<button class="btn btn-xs">X</button>');
    stepFormDiv.append($removeStepFormButton);

    $removeStepFormButton.on('click', function (e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        var index = $instructionCollectionHolder.data('index');
        $instructionCollectionHolder.data('index', index -1);

        // remove the li for the step form
        stepFormDiv.remove();
    });
}
