$(document).ready(function () {

    /**
     * SHOPPING LIST
     */
    var userShoppingListItem = $('p.cb-sl-userShoppingListItem'); //li-element
    var buttonHideUserShoppingListItem = $('#cb-sl-hideUserShoppingListItem'); // button-element

    // cross out already checked items
    $("input:checkbox:checked.cb-sl-userShoppingListItemCheckbox").each(function () {
        $(this).next('label').toggleClass("cb-sl-userShoppingListItemTextCrossed ");
    });

    // make it able to click on the whole item to check it (and cross it out if checked)
    userShoppingListItem.on("click", function (event) {
        var label = $(this).children("label.cb-sl-userShoppingListItemText"); // label-element

        // prevent currently edited items of being checked/unchecked
        if (label.attr("contenteditable") === "true") {
            event.preventDefault();
        } else {
            label.toggleClass("cb-sl-userShoppingListItemTextCrossed ");

            if (event.target.nodeName === "LABEL") {
                event.preventDefault();
            }

            if (event.target.nodeName != "INPUT") {
                var checkbox = $(this).children("input:checkbox.cb-sl-userShoppingListItemCheckbox"); // input-element (checkbox)
                checkbox.prop('checked', !checkbox.prop('checked')).change(); // manually fire change-event to be able to listen on checkbox-change afterwards
            }

            hideAndShowCheckedUserShoppingListItems();
        }
    });

    // hide and show all checked items and toggle button-text
    buttonHideUserShoppingListItem.on("click", function (event) {
        event.preventDefault();
        $(this).toggleClass("cb-sl-hideCheckedItemsActive active");

        // toggle button text
        $(this).html($(this).html() === "Hide checked items" ? "Show checked items" : "Hide checked items");

        hideAndShowCheckedUserShoppingListItems();
    });

    function hideAndShowCheckedUserShoppingListItems() {
        if (buttonHideUserShoppingListItem.hasClass("cb-sl-hideCheckedItemsActive")) {
            $("input:checkbox:checked.cb-sl-userShoppingListItemCheckbox").each(function () {
                $(this).parent().parent().addClass("cb-sl-userShoppingListItemHidden")
            });
        } else {
            $("input:checkbox:checked.cb-sl-userShoppingListItemCheckbox").each(function () {
                $(this).parent().parent().removeClass("cb-sl-userShoppingListItemHidden")
            });
        }
    }

    // store checked status to database via ajax
    $('input:checkbox.cb-sl-userShoppingListItemCheckbox').change(function () {
        var url = "/shoppinglist/check";
        var isChecked = false;

        if ($(this).is(':checked')) {
            isChecked = true;
        }

        $.ajax({
            type: "POST",
            url: "/shoppinglist/check",
            data: {
                index: $(this).val(),
                isChecked: isChecked
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
            }
        });
    });

    // make label contenteditabel
    $('button.cb-sl-editUserShoppingListItem').on('click', function (event) {
        event.preventDefault();

        $(this).addClass('active');

        var label = $(this).prev('p.cb-sl-userShoppingListItem').children('label.cb-sl-userShoppingListItemText');
        label.prop("contenteditable", true);
        label.focus();
    });

    // store edited item-value to database via ajax
    $('label.cb-sl-userShoppingListItemText').on('blur', function (event) {
        $(this).prop("contenteditable", false);
        $(this).parent().next('button.cb-sl-editUserShoppingListItem').removeClass('active');

        var index = $(this).prev('input:checkbox.cb-sl-userShoppingListItemCheckbox').val();
        var newValue = $(this).html();

        $.ajax({
            type: "POST",
            url: "/shoppinglist/edit",
            data: {
                index: index,
                newValue: newValue
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
            }
        });
    });


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
            var itemAddToShoppingListText = $(this).text(); // span-elements (amount, measurement, ingredient)
            itemsAddToShoppingList += "<li>" + itemAddToShoppingListText + "</li>";
            $(this).prev('input.cb-sl-addToShoppingListItemCheckbox').val(itemAddToShoppingListText);
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
