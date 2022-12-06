"use strict";

// Class definition
var KTDatatablesButtons = function () {
    // Shared variables
    var datatable;
    // Private functions
    var initDatatable = function () {
        let url     = `${HOST_URL}/clients/get-general-all`;
        let columns = [
            {   //ID
                targets   : 0,
                className : 'dt-head-center dt-body-center', // Center text for head and body column
                orderable : true,
                asc       : true,
                render    : function (data,type, row) {
                    return `${row.customer.id}`;
                }
            },
            {
                //NAME CLIENT
                targets   : 1,
                render    : function (data, type, row) {
                    return `${row.customer.name}`;
                }
            },
            {
                //LAST_NAME CLIENT
                targets   : 2,
                orderable : false,
                render    : function (data, type, row) {
                    return `${row.customer.last_name}`;
                }
            },
            {
                //EMAIL CLIENT
                targets   : 3,
                orderable : false,
                render    : function (data, type, row) {
                    return `${row.customer.email}`;
                }
            },
            {
                //BUSINESS_NAME
                targets   : 4,
                orderable : false,
                render    : function (data, type, row) {
                    return `<i class="bi bi-shop text-success"></i> ${row.business_name}`;
                }
            },
            {
                //CODE
                targets: 5,
                orderable: false,
                render: function (data, type, row) {
                    return `<i class="bi bi-upc-scan text-info"></i> ${row.code}`;
                }
            },
            {
                //PHONE
                targets: 6,
                orderable: false,
                render: function (data, type, row) {
                    return `${row.phone}`;
                }
            },
            {
                //PHONE
                targets: 7,
                orderable: false,
                render: function (data, type, row) {
                    return `${row.address}`;
                }
            },
            {
                //PERFIL
                targets: 8,
                data: null,
                orderable: false,
                className: 'text-end',
                render: function (data, type, row) {
                    return `
                        <a href="${HOST_URL}/clientes/perfil/${row.customer.id}" class="btn btn-icon btn-light-primary"><i class="bi bi-person-rolodex fs-2 me-2"></i></i></a>
                        <a href="#" class="btn btn-icon btn-light-danger"><i class="bi bi-trash fs-2 me-2"></i></i></a>
                    `;
                }
            },
        ]
        datatable = factoryNixDit.methods.activateDataTable(url,columns);
    }

    // Search Datatable
    var handleSearchDatatable = function () {
        $('#filter_client_name').on('keyup', function(event){ // Filter by client name
            var client_name = $(this).val();
            datatable.columns(1).search(client_name).draw();
        });
    }

    // Delete customer
    var handleDeleteRows = () => {
        // Select all delete buttons

        const deleteButtons = document.querySelectorAll('[data-kt-docs-table-filter="delete_row"]');

        deleteButtons.forEach(d => {
            // Delete button on click
            d.addEventListener('click', function (e) {
                e.preventDefault();

                // Select parent row
                const parent = e.target.closest('tr');
                const id = e.target.getAttribute('data-user-id');
                // Get customer name
                const productName = parent.querySelectorAll('td')[1].innerText;

                // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                Swal.fire({
                    text: "Estas seguro de querer eliminar el usuario " + productName + "?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Si, eliminar!",
                    cancelButtonText: "No, cancelar",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-primary"
                    }
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: '/user/delete/'+ id,
                            dataType: 'json',
                            contentType: false,
                            processData: false,
                            type: 'GET',
                        }).done(function(response){
                            Swal.fire({
                                title: response.title,
                                text: response.message,
                                icon: response.icon,
                                timer: 2000
                            }).then( () => location.reload() );
                        });
                    }
                });
            })
        });
    }

    // Public methods
    return {
        init: function () {
            initDatatable();
            handleSearchDatatable();
            handleDeleteRows();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatablesButtons.init();
});
