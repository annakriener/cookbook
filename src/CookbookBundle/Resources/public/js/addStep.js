/**
 * Created by Anna Kriener on 07.05.2015.
 */

var $instructionCollectionHolder;

// setup an "add a step" link
var $addInstructionButton = $('<button class="cb-ris-add-instruction-button btn-default btn">Add a step</button>');
var $newInstructionButtonDiv = $('<div></div>').append($addInstructionButton);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of steps
    $instructionCollectionHolder = $('div#recipe_instructions');

    // add a delete link to all of the existing instruction form div elements
    $instructionCollectionHolder.find('div').each(function() {
        addInstructionFormDeleteButton($(this));
    });

    // add the "add a step" button and div to the instructions div
    $instructionCollectionHolder.append($newInstructionButtonDiv);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $instructionCollectionHolder.data('index', $instructionCollectionHolder.find(':input').length);

    $addInstructionButton.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new step form (see next code block)
        addInstructionForm($instructionCollectionHolder, $newInstructionButtonDiv);
    });

    function addInstructionForm($instructionCollectionHolder, $newStepButtonDiv) {
        // Get the data-prototype explained earlier
        var prototype = $instructionCollectionHolder.data('prototype');

        // get the new index
        var index = $instructionCollectionHolder.data('index');

        console.log(index);
        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newInstructionForm = prototype.replace(/__name__/g, index);

        // increase the index with one for the next item
        $instructionCollectionHolder.data('index', index + 1);

        // Display the form in the page in an li, before the "Add a step" link li
        var $newInstructionFormDiv = $('<div></div>').append(newInstructionForm);
        $newStepButtonDiv.before($newInstructionFormDiv);

        // add a delete link to the new form
        addInstructionFormDeleteButton($newInstructionFormDiv);
    }

    function addInstructionFormDeleteButton(instructionFormDiv) {
        var $removeFormButton = $('<button class="btn btn-default">X</button>');
        instructionFormDiv.append($removeFormButton);

        $removeFormButton.on('click', function (e) {
            // prevent the link from creating a "#" on the URL
            e.preventDefault();

            // remove the li for the step form
            instructionFormDiv.remove();
        });
    }

    //addInstructionForm($instructionCollectionHolder, $newStepButtonDiv);
});
