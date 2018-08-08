require('select2');
require('bootstrap-datepicker');
let scriptMovementDetailPrototype = require('../movementDetail/movementDetailPrototype');
global.scriptMovementDetailPrototype = scriptMovementDetailPrototype;
$(document).ready(function() {

    $('.txt-date').datepicker({
        autoclose: true,
        language: $('#div-date').attr('data-language'),
        format: 'yyyy-mm-dd'
    });
    // const l_selTypeMovement = $('.sel-type-movement');
    // l_selTypeMovement.change(function () {
    //     const l_frmForm = $(this).closest('form');
    //     const l_dtData = {};
    //     l_dtData[l_selTypeMovement.attr('name')] = l_selTypeMovement.val();
    //     $.ajax({
    //         url: l_frmForm.attr('action'),
    //         type: l_frmForm.attr('method'),
    //         data: l_dtData,
    //         success: function (p_sContent) {
    //             $('#div_movement_mvtOrder').replaceWith($(p_sContent).find('#div_movement_mvtOrder'));
    //             const l_selOrder = $('.sel-order-to-deliver');
    //             l_selOrder.change(function () {
    //                 const l_frmForm = $(this).closest('form');
    //                 const l_dtData = {};
    //                 l_dtData[l_selOrder.attr('name')] = l_selOrder.val();
    //                 $.ajax({
    //                     url: l_frmForm.attr('action'),
    //                     type: l_frmForm.attr('method'),
    //                     data: l_dtData,
    //                     success: function (p_sContent) {
    //                         console.log($(p_sContent).find('.div-mvtMovementDetailLists'));
    //                         $('.div-mvtMovementDetailLists').replaceWith($(p_sContent).find('.div-mvtMovementDetailLists'));
    //                     }
    //                 });
    //             });
    //         }
    //     });
    // });
});