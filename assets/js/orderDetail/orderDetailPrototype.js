/**
 * Created by Zo on 17/05/2018.
 */

const addOrderDetailLink = $('.add_order_detail_row');

$(document).ready(function() {

    // Get the div that holds the collection of div-order-detail
    const l_divOrderDetailLists = $('div.div-order-detail');
    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    l_divOrderDetailLists.data('index', l_divOrderDetailLists.find(':input').length);

    //event add new address
    addOrderDetailLink.on('click', function(e) {
        e.preventDefault();
        addOrderDetailForm(l_divOrderDetailLists);
    });

    // handle the removal, just for this example
    $('.remove-tag').click(function(e) {
        e.preventDefault();

        $(this).parent().remove();
        calculateAmountOrder();

        return false;
    });
    
    $('.sel-product').change(function () {
        setInfoProduct($(this));
    });

    $('.txt-quantity-ordered').on('change',function () {
        calculateAmountOrder();
    });
    calculateAmountOrder();
});

/**
 * show the info for the product selected
 * @param p_selSelectProduct
 */
function setInfoProduct(p_selSelectProduct){
    const l_fStockQuantity = $(p_selSelectProduct).find('option:selected').data('stock-quantity');
    const l_fPrice = $(p_selSelectProduct).find('option:selected').data('price');
    const l_iIdUnitMeasure = $(p_selSelectProduct).find('option:selected').data('unit-measure');
    $(p_selSelectProduct).parent().parent().parent().find('.txt-stock-quantity').each(function () {
        $(this).val(l_fStockQuantity);
    });

    $(p_selSelectProduct).parent().parent().parent().find('.txt-price').each(function () {
        $(this).val(l_fPrice);
    });
    //get the unit of measure and show it
    $(p_selSelectProduct).parent().parent().parent().find('.sel-unit-of-measure').each(function () {
        $(this).trigger('change').val(l_iIdUnitMeasure);
    });
    calculateAmountOrder();
}

/**
 * calculate amount order
 */
function calculateAmountOrder() {
    let l_fAmount = 0;
    $('.txt-price').each(function () {
        let l_fQuantity = 0;
        let l_fTotalPrice = 0;
        //get the quantity to order
        $(this).parent().parent().parent().parent().parent().parent().find('.txt-quantity-ordered').each(function () {
            l_fQuantity = parseFloat($(this).val());
        });
        l_fTotalPrice = parseFloat($(this).val()) * l_fQuantity;
        l_fAmount = l_fAmount + l_fTotalPrice;
        //update amount of one item
        $(this).parent().parent().parent().parent().parent().parent().find('.sp-total-price').each(function () {
            $(this).html(l_fTotalPrice);
        });
    });
    $('.sp-amount-order').html(l_fAmount);
}

/**
 * add new addresses
 * @param p_divMovementDetail
 */
function addOrderDetailForm(p_divMovementDetail) {
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

    $('.div-order-detail').append($l_rowRowForm);
    //google map


    // handle the removal, just for this example
    $('.remove-tag').click(function(e) {
        e.preventDefault();

        $(this).parent().remove();
        calculateAmountOrder();

        return false;
    });

    $('.sel-product').change(function () {
        setInfoProduct($(this));
    });

    $('.txt-quantity-ordered').on('change',function () {
        calculateAmountOrder();
    });
}
