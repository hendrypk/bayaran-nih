const hnsRoleModalForm = function () {
    let validator;
    let form;

    const _componentValidation = function() {
        if (!$().validate) {
            console.warn('Warning - validate.min.js is not loaded.');
            return;
        }

        // Initialize
        validator = $('.form-validate').validate({
            rules: {
                name: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: 'Role name is required'
                }
            }
        });

        // Reset form
        // $('#reset').on('click', function() {
        //     validator.resetForm();
        // });
        // handle submit
        form.on('submit', function (e) {
            e.preventDefault();
            if (!validator.form()) {
                return;
            }
            hnsApp.submitAjax('#hns_modal', form.attr('action'), form.serialize(), 'POST')
        });
    };

    // Select all handler
    const handleSelectAll = () =>{
        // Define variables
        const selectAll = form.find('#hns_role_select_all');
        const allCheckboxes = form[0].querySelectorAll('[type="checkbox"]');

        // Handle check state
        selectAll.change(function (e) {
            // Apply check state to all checkboxes
            allCheckboxes.forEach(c => {
                c.checked = e.target.checked;
            });
        });
    }

    return {
        // Public functions
        init: function () {
            form = $('#form_modal_role');
            handleSelectAll()
            _componentValidation()
        }
    };
}();