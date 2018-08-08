/**
 * Created by Zo on 17/05/2018.
 */

const addMovementDetailLink = $('.add_movement_detail_row');

$(document).ready(function() {

    // Get the div that holds the collection of div-mvtMovementDetailLists
    const l_divMvtMovementDetailLists = $('div.div-mvtMovementDetailLists');
    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    l_divMvtMovementDetailLists.data('index', l_divMvtMovementDetailLists.find(':input').length);

    //event add new address
    addMovementDetailLink.on('click', function(e) {
        e.preventDefault();
        addMovementDetailForm(l_divMvtMovementDetailLists);
    });

    // handle the removal, just for this example
    $('.remove-tag').click(function(e) {
        e.preventDefault();
        $(this).parent().remove();

        return false;
    });
    
    $('.sel-product').change(function () {
        setQuantityStock($(this));
    });
});

/**
 * show the quantity stock for the product selected
 * @param p_selSelectProduct
 */
function setQuantityStock(p_selSelectProduct){
    const l_fStockQuantity = $(p_selSelectProduct).find('option:selected').data('stock-quantity');
    const l_iIdUnitMeasure = $(p_selSelectProduct).find('option:selected').data('unit-measure');
    console.log(l_fStockQuantity);
    $(p_selSelectProduct).parent().parent().parent().find('.txt-stock-quantity').each(function () {
        $(this).val(l_fStockQuantity);
    });
    //get the unit of measure and show it
    $(p_selSelectProduct).parent().parent().parent().find('.sel-unit-of-measure').each(function () {
        $(this).trigger('change').val(l_iIdUnitMeasure);
    });
}

/**
 * add new addresses
 * @param p_divMovementDetail
 */
function addMovementDetailForm(p_divMovementDetail) {
    // Get the data-prototype explained earlier
    const prototype = p_divMovementDetail.data('prototype');
    // get the new index
    const index = p_divMovementDetail.data('index');

    // Replace '$$name$$' in the prototype's HTML to
    // instead be a number based on how many items we have
    const newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    p_divMovementDetail.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    const $newForm = '<div class="col-sm">'+newForm+'</div>';
    const $l_hrfDelete = '<a href="#" class="remove-tag text-red"><i class="material-icons md-18 md-red">delete</i></a>';
    const $l_rowRowForm = '<div class="row border m-2">'+$newForm+$l_hrfDelete+'</div>';

    $('.div-mvtMovementDetailLists').append($l_rowRowForm);
    //google map


    // handle the removal, just for this example
    $('.remove-tag').click(function(e) {
        e.preventDefault();

        $(this).parent().remove();

        return false;
    });

    $('.sel-product').change(function () {
        setQuantityStock($(this));
    });
}
