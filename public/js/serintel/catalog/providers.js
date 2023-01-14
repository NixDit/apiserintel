"use strict";

// Class definition
var KTDatatablesButtons = function () {
    // Shared variables
    var datatable;
    // Private functions
    var initDatatable = function () {
        let url     = `${HOST_URL}/providers/get-provider-all`;
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
                //NAME CLIENT
                targets   : 1,
                render    : function (data, type, row) {
                    return `${row.provider.name}`;
                }
            },
            {
                //NAME CLIENT
                targets   : 2,
                render    : function (data, type, row) {
                    return `${row.provider.last_name}`;
                }
            },
            {
                //NAME CLIENT
                targets   : 3,
                render    : function (data, type, row) {
                    return `${row.provider.email}`;
                }
            },
            {
                //NAME CLIENT
                targets   : 4,
                render    : function (data, type, row) {
                    return `${row.razon_social}`;
                }
            },
            {
                //NAME CLIENT
                targets   : 5,
                render    : function (data, type, row) {
                    return `${row.rfc}`;
                }
            },
            {
                //NAME CLIENT
                targets   : 6,
                render    : function (data, type, row) {
                    return `${row.phone}`;
                }
            },
            {
                //NAME CLIENT
                targets   : 7,
                render    : function (data, type, row) {
                    return `${row.address}`;
                }
            },
            {
                //PERFIL
                targets: 8,
                data: null,
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return `
                        <button type="button" data-id="${row.id}" class="btn btn-icon btn-light-warning update_brand"><i class="bi bi-pencil "></i></button>
                        <button type="button" data-id="${row.id}" data-name="${row.provider.name}" class="btn btn-icon btn-light-danger delete_provider"><i class="bi bi-trash fs-2 me-2"></i></button>
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

    // Delete
    let deleteProvider = function () {
        $(document).on('click','.delete_provider',function(){
            let id   = $(this).data('id');
            let name = $(this).data('name');
            Swal.fire({
                text: `¿Estas seguro de querer eliminar el proveedor ${name}?`,
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Si, eliminar",
                cancelButtonText: "No, cancelar",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-primary"
                }
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url         : '/providers/delete/'+ id,
                        dataType    : 'json',
                        contentType : false,
                        processData : false,
                        type        : 'GET',
                    }).done(function(response){
                        Swal.fire({
                            title : response.title,
                            text  : response.message,
                            icon  : response.icon
                        }).then( () => datatable.ajax.reload() );
                    });
                }
            });
        });
    }

    // Public methods
    return {
        init: function () {
            initDatatable();
            handleSearchDatatable();
            deleteProvider(); // Delete
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatablesButtons.init();
});
