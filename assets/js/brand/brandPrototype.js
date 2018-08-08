/**
 * Created by Zo on 17/05/2018.
 */

const addBrandLink = $('.add_brand_row');

$(document).ready(function() {

    // Get the div that holds the collection of supBrandList
    const l_divBrand = $('div.supBrandList');
    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    l_divBrand.data('index', l_divBrand.find(':input').length);

    //event add new address
    addBrandLink.on('click', function(e) {
        e.preventDefault();
        addBrandForm(l_divBrand);
    });

    // handle the removal, just for this example
    $('.remove-tag').click(function(e) {
        e.preventDefault();

        $(this).parent().remove();

        return false;
    });

});

/**
 * add new addresses
 * @param p_divBrand
 */
function addBrandForm(p_divBrand) {
    // Get the data-prototype explained earlier
    const prototype = p_divBrand.data('prototype');
    // get the new index
    const index = p_divBrand.data('index');

    // Replace '$$name$$' in the prototype's HTML to
    // instead be a number based on how many items we have
    const newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    p_divBrand.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    const $newForm = '<div class="col-sm">'+newForm+'</div>';
    const $l_hrfDelete = '<a href="#" class="remove-tag text-red"><i class="material-icons md-18 md-red">delete</i></a>';
    const $l_rowRowForm = '<div class="row border m-2">'+$newForm+$l_hrfDelete+'</div>';

    $('.supBrandList').append($l_rowRowForm);
    //google map


    // handle the removal, just for this example
    $('.remove-tag').click(function(e) {
        e.preventDefault();

        $(this).parent().remove();

        return false;
    });
}
