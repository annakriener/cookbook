/**
 * Created by Anna Kriener on 31.05.2015.
 */

$(document).ready(function () {

    /**
     * SHOPPING LIST
     */
    var userShoppingListItem = $('li.cb-sl-userShoppingListItem'); //li-element

    // make it able to click on the whole item to check it (and cross it out if checked)
    userShoppingListItem.on("click", function (event) {
        if(event.target.nodeName === "LABEL") {
            event.preventDefault();
        }

        if(event.target.nodeName != "INPUT") {
            var checkbox = $(this).children("input:checkbox.cb-sl-userShoppingListItemCheckbox"); // input-element (checkbox)
            checkbox.prop('checked', !checkbox.prop('checked'));
        }

        var label = $(this).children("label.cb-sl-userShoppingListItemText"); // label-element
        label.toggleClass("cb-sl-userShoppingListItemTextCrossed ");

        hideAndShowCheckedUserShoppingListItems();
    });


    var buttonHideUserShoppingListItem = $('#cb-sl-hideUserShoppingListItem'); // button-element

    // hide and show all checked items
    buttonHideUserShoppingListItem.on("click", function (event) {
        event.preventDefault();
        $(this).toggleClass("cb-sl-hideCheckedItemsActive active");

        // toggle button text
        $(this).html($(this).html() == "Hide checked items" ? "Show checked items" : "Hide checked items");

        hideAndShowCheckedUserShoppingListItems();
    });

    function hideAndShowCheckedUserShoppingListItems() {
        if (buttonHideUserShoppingListItem.hasClass("cb-sl-hideCheckedItemsActive")) {
            $("input:checkbox:checked.cb-sl-userShoppingListItemCheckbox").each(function () {
                $(this).parent().addClass("cb-sl-userShoppingListItemHidden")
            });
        } else {
            $("input:checkbox:checked.cb-sl-userShoppingListItemCheckbox").each(function () {
                $(this).parent().removeClass("cb-sl-userShoppingListItemHidden")
            });
        }
    }

    /**
     * RECIPE DETAIL
     */
    var buttonCheckAllShoppingListItems = $('#cb-sl-checkAllShoppingListItems'); //button-element

    // check all ingredients with button-click
    buttonCheckAllShoppingListItems.on("click", function(event) {
        event.preventDefault();
        checkAndUnCheckShoppingListItems();
    });

    var addItemsToShoppingListForm = $('form#cb-sl-addItemsToShoppingListForm');
    var addItemsToShoppingListButton = $('button#cb-sl-addItemsToShoppingListButton');
    var confirmAddItemsToShoppingListModal = $('#cb-sl-confirmAddItemsToShoppingList');

    addItemsToShoppingListButton.on("click", function(event) {
        event.preventDefault();

        var checkedCheckboxesAddToShoppingListItem = $('.cb-sl-addToShoppingListItemCheckbox:checked');
        var checkedLength = checkedCheckboxesAddToShoppingListItem.length;

        if(checkedLength > 0) {
            confirmAddItemsToShoppingListModal.modal('toggle');
        } else {
            alert("check at least one ingredient");
        }
    });

    $('button#cb-sl-yesAddItemsToShoppingListButton').on("click", function() {
        addItemsToShoppingListForm.submit();

    });

    confirmAddItemsToShoppingListModal.on('show.bs.modal', function (event) {

        /*
        var button = $(event.relatedTarget) // Button that triggered the modal
        var amount = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        */
        var modal = $(this);
        var checkedItems = $('.cb-sl-addToShoppingListItemCheckbox:checked').next();

        jQuery.each(checkedItems, function($index, $item) {
            //modal.find('.modal-body').append($item);
        });

    });

/*
    var deleteShoppingListItemForm = $('form#cb-sl-deleteShoppingListItemForm');
    var deleteButton = $('button#deleteShoppingListItem_deleteAll');
    deleteButton.on("click", function(event) {
            event.preventDefault();
            $('#cb-sl-confirmDeleteAllItems').modal('toggle');
    });

    $('button#cb-sl-yesDeleteAllItemsButton').on("click", function() {
        deleteShoppingListItemForm.submit();
        alert("TEST");
    });
*/

    function checkAndUnCheckShoppingListItems() {
        var checkboxesAddToShoppingListItem = $('.cb-sl-addToShoppingListItemCheckbox');
        var checkedCheckboxesAddToShoppingListItem = $('.cb-sl-addToShoppingListItemCheckbox:checked');

        var unCheckedLength = checkboxesAddToShoppingListItem.length;
        var checkedLength = checkedCheckboxesAddToShoppingListItem.length;

        if (checkedLength >= 0 && checkedLength < unCheckedLength) {
            checkboxesAddToShoppingListItem.prop("checked", true);
        }

        if (checkedLength == unCheckedLength) {
            checkboxesAddToShoppingListItem.prop("checked", false);
        }
    }
});
