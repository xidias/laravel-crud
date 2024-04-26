// public/js/custom.js
/* document.addEventListener("DOMContentLoaded", function() {
    console.log("Custom JavaScript loaded!");
}); */



$(function() {

    const modal = $('#exampleModal');
    modal.on('hide.bs.modal', function() {
        //modal.find('.modal-content').html('');
    });
    $('.options>[data-bs-toggle="modal"]').on('click', function() {
        // Open modal
        modal.on('show.bs.modal');
        // Load data into modal for preview
        const url = $(this).closest('.page-content').data('url');
        const action = $(this).data('action');
        const id = $(this).data('id') !== undefined ? $(this).data('id') : '0';
        //console.log(`${url}/${action}/${id}`);
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
        // Initialize bootstrap-select
/* 		$('select.select-picker').each(function(){
			$(this).selectpicker();
		}); */
        //$('select').selectpicker();
    });


    function modalForm() {
        // Initialize labels on page load if input fields are pre-filled
        $('.form-floating .form-control').each(function() {
            if ($(this).val() || $(this).attr('type') == 'file') {
                $(this).siblings('label').css('transform', 'scale(.85) translateY(-.5rem) translateX(.15rem)');
            } else {
                $(this).siblings('label').css('transform', 'none');
            }
        });
        $('.form-floating .form-control').on('focus', function() {
            $(this).siblings('label').css('transform', 'scale(.85) translateY(-.5rem) translateX(.15rem)');
        });
        $('.form-floating .form-control').on('blur', function() {
            if ($(this).val() || $(this).attr('type') == 'file') {
                $(this).siblings('label').css('transform', 'scale(.85) translateY(-.5rem) translateX(.15rem)');
            } else {
                $(this).siblings('label').css('transform', 'none');
            }
        });
/* 		$('select').each(function(){
			$(this).selectpicker();
		}); */
        $('select.select-picker').selectpicker();
        //image logo
        if ($('#logo-preview>img').attr('src') !== '#') {
            $('#logo-preview').show();
            $('#logo-input-container').hide();
        }
        else {
            $('#logo-preview').hide();
            $('#logo-input-container').show();   
        }
        // Show file name when a file is selected
        $('#company-logo').change(function() {
            const fileName = $(this).val().split('\\').pop();
            //$('#logoFileName').text(fileName).show();

            // Check if the file input has a file selected
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#logo-preview>img').attr('src', e.target.result);
                    $('#logo-preview').removeClass('d-none');
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Show file input and hide logo preview when delete button is clicked
        $('#deleteLogoBtn').click(function() {
            const confirmation = confirm('Are you sure you want to delete the logo?');
            if (confirmation) {
                $('#company-logo').val(''); // Clear the file input value
                $('#logo-preview').hide();
                $('#logo-input-container').show(); 
                // Add a hidden input to signal logo deletion
                $('<input>').attr({
                    type: 'hidden',
                    name: 'delete_logo',
                    value: '1'
                }).appendTo('#company-form');
            }
        });

    }

    function modalMessage(message) {
        //console.log('ii');
        const modal = $('#exampleModal');
        modal.on('show.bs.modal', function() {
            modal.find('.modal-content').html(message);
        });
    }


    
    

/* 
    $(document).on('click','.btn-secondary', function() {
        alert('ddd');
    });
 */
});
