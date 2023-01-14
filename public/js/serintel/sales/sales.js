"use strict";

// Class definition
var KTDatatablesButtons = function () {
    // Shared variables
    var datatable;
    // Private functions
    var initDatatable = function () {
        let url     = `${HOST_URL}/sales/get-general-all`;
        let columns = [
            {   //ID
                targets   : 0,
                className : 'dt-head-center dt-body-center', // Center text for head and body column
                orderable : true,
                asc       : true,
                render    : function (data,type, row) {
                    return `${row.id}`;
                }
            },
            {
                //CLIENT
                targets   : 1,
                className : 'dt-head-center dt-body-center',
                render    : function (data, type, row) {
                    return `${row.customer.fullname}`;
                }
            },
            {
                //EMPLOYEE
                targets   : 2,
                className : 'dt-head-center dt-body-center',
                orderable : false,
                render    : function (data, type, row) {
                    return `${row.seller.fullname}`;
                }
            },
            {
                //SUBTOTAL
                targets   : 3,
                className : 'dt-head-center dt-body-center',
                orderable : false,
                render    : function (data, type, row) {
                    return `$${Number(row.subtotal).toFixed(2)}`;
                }
            },
            {
                //TOTAL
                targets   : 4,
                className : 'dt-head-center dt-body-center',
                orderable : false,
                render    : function (data, type, row) {
                    return `$${Number(row.total).toFixed(2)}`;
                }
            },
            {
                //TYPE
                targets: 5,
                orderable: false,
                render: function (data, type, row) {
                    if(row.type == 1){
                        return `<span class="badge badge-info">Prepago</span>`;
                    }if (row.type == 2) {
                        return `<span class="badge badge-success">Pagado</span>`;
                    }if (row.type == 3){
                        return `<span class="badge badge-primary">Postpago</span>`;
                    } else {
                        return `<span class="badge badge-secondary">--</span>`;
                    }


                }
            },
            {
                //STATUS
                targets: 6,
                orderable: false,
                render: function (data, type, row) {
                    if(row.status == 0){
                        return `<span class="badge badge-light-warning">Pendiente</span>`;
                    }if (row.status == 1) {
                        return `<span class="badge badge-light-success">Completado</span>`;
                    }if (row.status == 2){
                        return `<span class="badge badge-light-danger">Rechazado</span>`;
                    } else {
                        return `<span class="badge badge-light-secondary">--</span>`;
                    }
                }
            },
            {
                //FOLIO
                targets: 7,
                orderable: false,
                render: function (data, type, row) {
                    return `${row.folio}`;
                }
            },
            {
                //CREATED_AT
                targets: 8,
                render: function (data, type, row) {
                    return `${row.format_created_at}`;
                }
            },
            {
                //ACCIONES
                targets: 9,
                data: null,
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return `
                        <a href="#" class="btn btn-icon btn-light-primary"><i class="bi bi-eye"></i></i></a>
                        <a href="#" class="btn btn-icon btn-light-info"><i class="bi bi-printer fs-2 me-2"></i></i></a>
                        <a href="#" class="btn btn-icon btn-light-warning"><i class="bi bi-pencil"></i></i></a>
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
