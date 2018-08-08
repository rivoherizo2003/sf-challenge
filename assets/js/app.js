require('jquery');
// require('popper.js');
require('bootstrap');
// require('');
require('exports-loader?bootstrap/js/src/tooltip.js');
require('exports-loader?bootstrap/js/src/popover.js');
require('exports-loader?bootstrap/js/src/modal.js');

$(document).ready(function () {
    $('#div-modal').on('show.bs.modal', function (event) {
        // link that triggered the modal
        const l_hrfRelatedTarget = $(event.relatedTarget);
        const l_sUrlToLaunch = l_hrfRelatedTarget.data('url');
        const l_sModalTitle = l_hrfRelatedTarget.data('heading-title');
        const l_sBodyContent = l_hrfRelatedTarget.data('body-content');

        const l_divModal = $(this);
        l_divModal.find('.modal-title').html(l_sModalTitle);
        l_divModal.find('.modal-body').html(l_sBodyContent);
        l_divModal.find('#hrf-confirm').attr('href',l_sUrlToLaunch);
    });
});