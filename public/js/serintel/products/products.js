"use strict";

// Class definition
var KTDatatablesButtons = function () {
    // Shared variables
    var datatable;
    // Private functions
    var initDatatable = function () {
        let url     = `${HOST_URL}/products/get-general-all`;
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
                //NAME
                targets   : 1,
                render    : function (data, type, row) {
                    return `${row.name}`;
                }
            },
            {
                //SUPPLIER_CODE
                targets   : 2,
                orderable : false,
                render: function (data, type, row) {
                    if(row.supplier_code == null){
                        return `<span class="badge badge-light-info">--</span>`;
                    }else {
                        return `${row.supplier_code}`;
                    }


                }
            },
            {
                //CODE
                targets   : 3,
                orderable : false,
                render    : function (data, type, row) {
                    return `${row.code}`;
                }
            },
            // {
            //     //DESCRIPTION
            //     targets   : 4,
            //     className : 'dt-head-center dt-body-center',
            //     orderable : false,
            //     render    : function (data, type, row) {
            //         return `${row.description}`;
            //     }
            // },
            {
                //COST
                targets   : 4,
                className : 'dt-head-center dt-body-center',
                orderable : false,
                render    : function (data, type, row) {
                    return `$${Number(row.cost).toFixed(2)}`;
                }
            },
            {
                //RETAIL_PRICE
                targets   : 5,
                className : 'dt-head-center dt-body-center',
                orderable : false,
                render    : function (data, type, row) {
                    return `$${Number(row.retail_price).toFixed(2)}`;
                }
            },
            {
                //WHOLESALE_PRICE
                targets   : 6,
                className : 'dt-head-center dt-body-center',
                orderable : false,
                render    : function (data, type, row) {
                    return `$${Number(row.wholesale_price).toFixed(2)}`;
                }
            },
            {
                //SUPER_SPECIAL_PRICE
                targets   : 7,
                className : 'dt-head-center dt-body-center',
                orderable : false,
                render    : function (data, type, row) {
                    return `$${Number(row.super_special_price).toFixed(2)}`;
                }
            },
            {
                //BRAND_ID
                targets: 8,
                orderable: false,
                render: function (data, type, row) {
                    return `${row.brand.name}`;
                }
            },
            {
                //CATEGORY_ID
                targets: 9,
                orderable: false,
                render: function (data, type, row) {
                    return `${row.category.name}`;
                }
            },
            {
                //LINE_ID
                targets: 10,
                render: function (data, type, row) {
                    return `${row.line.name}`;
                }
            },
            {
                //ACCIONES
                targets: 11,
                data: null,
                orderable: false,
                className: 'text-end',
                render: function (data, type, row) {
                    return `
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
