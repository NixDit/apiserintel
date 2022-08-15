"use strict";

// Class definition
var KTDatatablesButtons = function () {
    // Shared variables
    var table;
    var dt;
    var filterPayment;

    // Private functions
    var initDatatable = function () {


        dt = $("#sales_datatable").DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: false,
            order: [[0, 'asc']],
            stateSave: true,
            ajax: {
                url: `${HOST_URL}/sales/get-all`,
                method: 'GET'
            },
            columns: [
                { data: 'id' },
                { data: 'client' },
                { data: 'employee' },
                { data: 'subtotal' },
                { data: 'total' },
                { data: 'type' },
                { data: 'status' },
                { data: 'folio' },
                { data: 'created_at' },
            ],
            columnDefs: [
                {   //ID
                    targets: 0,
                    orderable: true,
                    asc: true,
                    render: function (data) {
                        return `${data}`;
                    }
                },
                {
                    //CLIENT
                    targets: 1,
                    render: function (data, type, row) {
                        return `${data}`;
                    }
                },
                {
                    //EMPLOYEE
                    targets: 2,
                    orderable: false,
                    render: function (data, type, row) {
                        return `${data}`;
                    }
                },
                {
                    //SUBTOTAL
                    targets: 3,
                    orderable: false,
                    render: function (data, type, row) {
                        return `${data}`;
                    }
                },
                {
                    //TOTAL
                    targets: 4,
                    orderable: false,
                    render: function (data, type, row) {
                        return `${data}`;
                    }
                },
                {
                    //TYPE
                    targets: 5,
                    orderable: false,
                    render: function (data, type, row) {
                        return `${data}`;
                    }
                },
                {
                    //STATUS
                    targets: 6,
                    orderable: false,
                    render: function (data, type, row) {
                        return `${data}`;
                    }
                },
                {
                    //FOLIO
                    targets: 7,
                    orderable: false,
                    render: function (data, type, row) {
                        return `${data}`;
                    }
                },
                {
                    //CREATED_AT
                    targets: 8,
                    orderable: false,
                    render: function (data, type, row) {
                        return `${data}`;
                    }
                },
            ],
            // Add data-filter attribute
            createdRow: function (row, data, dataIndex) {
                $(row).find('td:eq(4)').attr('data-filter', data.CreditCardType);
            }
        });

        table = dt.$;

        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        dt.on('draw', function () {
            handleDeleteRows();
            KTMenu.createInstances();
        });
    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = function () {
        const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            dt.search(e.target.value).draw();
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
