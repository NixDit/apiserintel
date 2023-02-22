"use strict";

// Class definition
var KTDatatablesButtons = function () {
    // Shared variables
    var datatable;
    // Private functions
    var initDatatable = function () {
        let url     = `${HOST_URL}/companyservice/get-cellphone-all`;
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
                    return `${row.name}`;
                }
            },
            {
                //LAST_NAME CLIENT
                targets   : 2,
                render    : function (data, type, row) {
                    if (row.created_at == null) {
                        return `<span class="badge badge-secondary">--</span>`;
                    }else {
                        let date       = new Date(row.created_at),
                        // dateFormat = new Intl.DateTimeFormat('es', { year: 'numeric',month: 'long',day: '2-digit' }).format(date);
                        dateFormat = new Intl.DateTimeFormat('es').format(date);
                        return `${dateFormat}`;
                    }
                }
            },
            {
                //PERFIL
                targets: 3,
                data: null,
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return `
                        <button type="button" data-id="${row.id}" class="btn btn-icon btn-light-warning update_service"><i class="bi bi-pencil "></i></button>
                        <button type="button" data-id="${row.id}" data-name="${row.name}" class="btn btn-icon btn-light-danger delete_service"><i class="bi bi-trash fs-2 me-2"></i></button>
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
    let deleteService = function () {
        $(document).on('click','.delete_service',function(){
            let id   = $(this).data('id');
            let name = $(this).data('name');
            Swal.fire({
                text: `¿Estas seguro de querer eliminar la compañía ${name}?`,
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
                        url         : '/service/delete/'+ id,
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

    // UPDATE DIVISION
    let updateService = function () {
        $(document).on('click','.update_service',function(){
            let id = $(this).data('id');
            $.ajax({
                url         : `/service/${id}/edit`,
                dataType    : 'json',
                contentType : false,
                processData : false,
                type        : 'GET',
            }).done(function(response){
                if(!response.error){
                    $('#edit_company_service_modal').empty();
                    $('#edit_company_service_modal').append(response.render);
                    $('#kt_modal_update_company_service').modal('show');
                } else {
                    // Colocar mensaje en caso de error
                }
            });
        });
    }

    // Public methods
    return {
        init: function () {
            initDatatable();
            handleSearchDatatable();
            deleteService(); // Delete
            updateService(); // Update
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatablesButtons.init();
});
