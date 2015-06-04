/**
 * Created by Anna Kriener on 31.05.2015.
 */

$(document).ready(function () {

    /**
     * SHOPPING LIST
     */
    var userShoppingListItem = $('li.cb-sl-userShoppingListItem'); //li-element
    var buttonHideUserShoppingListItem = $('#cb-sl-hideUserShoppingListItem'); // button-element

    // make it able to click on the whole item to check it (and cross it out if checked)
    userShoppingListItem.on("click", function (event) {
        if (event.target.nodeName === "LABEL") {
            event.preventDefault();
        }

        if (event.target.nodeName != "INPUT") {
            var checkbox = $(this).children("input:checkbox.cb-sl-userShoppingListItemCheckbox"); // input-element (checkbox)
            checkbox.prop('checked', !checkbox.prop('checked'));
        }

        var label = $(this).children("label.cb-sl-userShoppingListItemText"); // label-element
        label.toggleClass("cb-sl-userShoppingListItemTextCrossed ");

        hideAndShowCheckedUserShoppingListItems();
    });

    // hide and show all checked items and toggle button-text
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
     * RECIPE DETAIL (ADD INGREDIENTS FROM RECIPE TO SHOPPING LIST)
     */
    var buttonCheckAllShoppingListItemsButton = $('button#cb-sl-checkAllShoppingListItemsButton'); //button-element
    var addItemsToShoppingListForm = $('form#cb-sl-addItemsToShoppingListForm'); //form-element
    var addItemsToShoppingListButton = $('button#cb-sl-addItemsToShoppingListButton'); //button-element
    var confirmAddItemsToShoppingListModal = $('#cb-sl-confirmAddItemsToShoppingListModal'); //div-element (modal)
    var checkAtLeastOneItemModal = $('#cb-sl-checkAtLeastOneItemModal'); //div-element (modal)

    // check all ingredients with button-click
    buttonCheckAllShoppingListItemsButton.on("click", function (event) {
        event.preventDefault();
        checkAndUnCheckShoppingListItems();
    });

    // confirm adding to shopping list
    addItemsToShoppingListButton.on("click", function (event) {
        event.preventDefault();

        var checkedCheckboxesAddToShoppingListItem = $('.cb-sl-addToShoppingListItemCheckbox:checked');
        var checkedLength = checkedCheckboxesAddToShoppingListItem.length;

        if (checkedLength > 0) {
            confirmAddItemsToShoppingListModal.modal('toggle');
        } else {
            checkAtLeastOneItemModal.modal('toggle');
        }
    });

    // submit form if confirmed
    $('button#cb-sl-yesAddItemsToShoppingListButton').on("click", function () {
        addItemsToShoppingListForm.submit();
    });

    // add checked items to confirmation-modal
    confirmAddItemsToShoppingListModal.on('show.bs.modal', function (event) {
        var modal = $(this);
        var checkedItems = $('.cb-sl-addToShoppingListItemCheckbox:checked').next(); // span-elements (with span-elements)
        var itemsAddToShoppingList = "<ul>";

        checkedItems.each(function (index) {
            var itemAddToShoppingListParts = $(this).children(); // span-elements (amount, measurement, ingredient)
            itemsAddToShoppingList += "<li>";
            itemAddToShoppingListParts.each(function (index) {
                itemsAddToShoppingList += $(this).text() + " ";
            });
            itemsAddToShoppingList += "</li>";
        });
        itemsAddToShoppingList += "<ul>";
        modal.find("div#cb-sl-itemsAddToShoppingList").html(itemsAddToShoppingList);  // append list of checked items to modal
    });

    // check and un-check all ingredients of a recipe
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
