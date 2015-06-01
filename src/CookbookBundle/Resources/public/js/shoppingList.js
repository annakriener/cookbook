/**
 * Created by Anna Kriener on 31.05.2015.
 */

$(document).ready(function () {
    var buttonCheckAllShoppingListItems = $('#cb-sl-checkAllShoppingListItems'); //button-element

    // check all ingredients with button-click
    buttonCheckAllShoppingListItems.on("click", function(event) {
        event.preventDefault();
        checkAndUnCheckShoppingListItems();
    });
    var userShoppingListItem = $('.cb-sl-userShoppingListItem'); //li-element

    // make it able to click on the whole item to check it (and cross it out if checked)
    userShoppingListItem.on("click", function (event) {
        var checkbox = $(this).children("input:first:checkbox.cb-sl-userShoppingListItemCheckbox"); // input-element (checkbox)
        checkbox.prop('checked', !checkbox.prop("checked"));

        $(this).children("span.cb-sl-userShoppingListItemText").toggleClass("cb-sl-userShoppingListItemTextCrossed"); // span-element

        hideAndShowCheckedUserShoppingListItems();
    });

    // show a hand-pointer when hovering over an item
    userShoppingListItem.hover(function () {
        $(this).css('cursor', 'pointer');
    }, function () {
        $(this).css('cursor', 'auto');
    });

    var buttonHideUserShoppingListItem = $('#cb-sl-hideUserShoppingListItem'); // button-element

    // hide and show all checked items
    buttonHideUserShoppingListItem.on("click", function (event) {
        event.preventDefault();
        $(this).toggleClass("active");

        // toggle button text
        $(this).html($(this).html() == "Hide checked items" ? "Show checked items" : "Hide checked items");

        hideAndShowCheckedUserShoppingListItems();
    });

    function hideAndShowCheckedUserShoppingListItems() {
        if (buttonHideUserShoppingListItem.hasClass("active")) {
            $("input:checkbox:checked.cb-sl-userShoppingListItemCheckbox").each(function () {
                $(this).parent().addClass("cb-sl-userShoppingListItemHidden")
            });
        } else {
            $("input:checkbox:checked.cb-sl-userShoppingListItemCheckbox").each(function () {
                $(this).parent().removeClass("cb-sl-userShoppingListItemHidden")
            });
        }
    }

    function checkAndUnCheckShoppingListItems() {
        var checkboxesAddToShoppingListItem = $('.cb-sl-addToShoppingListItem');
        var checkedCheckboxesAddToShoppingListItem = $('.cb-sl-addToShoppingListItem:checked');
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
