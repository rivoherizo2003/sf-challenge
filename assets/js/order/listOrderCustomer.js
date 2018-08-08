// require('jquery');
$(document).ready(function () {
    $('.hrf-order-code').click(function () {
        const url = $(this).data("url");
        const l_sModalTitle = $(this).data("heading-title")+" "+$(this).data('order-code');
        $.ajax({
            type: "POST",
            url: url,
            data: {p_iIdOrder:$(this).data("order-id")},
            success: function(res) {
                // update modal content

                const l_divModal = $('#div-modal-detail');
                l_divModal.find('.modal-title').html(l_sModalTitle);
                l_divModal.find('.modal-body').html(res);
                // show modal
                l_divModal.modal('show');

            },
            error:function(request, status, error) {
                console.log("ajax call went wrong:" + request.responseText);
            }
        });
    });
});