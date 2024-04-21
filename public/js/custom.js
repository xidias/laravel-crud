// public/js/custom.js
document.addEventListener("DOMContentLoaded", function() {
    console.log("Custom JavaScript loaded!");
});


$(function() {

    const modal = $('#exampleModal');
    modal.on('hide.bs.modal', function() {
        //modal.find('.modal-content').html('');
    });
    $('.options>[data-bs-toggle="modal"]').on('click', function() {
        // Open modal
        modal.on('show.bs.modal');
        // Load data into modal for preview
        const url = $(this).closest('.container').find('.table').data('url');
        const action = $(this).data('action');
        const id = $(this).data('id') !== undefined ? $(this).data('id') : '0';
        console.log(`${url}/${action}/${id}`);
        // Use AJAX to fetch company data and display in the modal
        $.ajax({
            url: `${url}/${action}/${id}`,
            type: 'GET',
            success: response => {
                // Load modal content into the modal body
                //console.log(response);
                modal.find('.modal-content').html(response);
                modalForm();
            },
            error: function(xhr, status, error) {
                console.error(error);
                // Handle error if needed
            }
        });
    });





    function modalForm() {
        // Initialize labels on page load if input fields are pre-filled
        $('.form-floating .form-control').each(function() {
            if ($(this).val()) {
                $(this).siblings('label').css('transform', 'scale(.85) translateY(-.5rem) translateX(.15rem)');
            } else {
                $(this).siblings('label').css('transform', 'none');
            }
        });
        $('.form-floating .form-control').on('focus', function() {
            $(this).siblings('label').css('transform', 'scale(.85) translateY(-.5rem) translateX(.15rem)');
        });
        $('.form-floating .form-control').on('blur', function() {
            if ($(this).val()) {
                $(this).siblings('label').css('transform', 'scale(.85) translateY(-.5rem) translateX(.15rem)');
            } else {
                $(this).siblings('label').css('transform', 'none');
            }
        });
    }
/* 
    $(document).on('click','.btn-secondary', function() {
        alert('ddd');
    });
 */
});
