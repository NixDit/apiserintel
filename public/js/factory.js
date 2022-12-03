"use strict";
// FACTORY
const factoryNixDit = function(){
    // INIT DATATABLE
    let _ajaxDataTable = function(url_request,columns,params = {}){
        // columns and columnsDefs must be an array object
        var dataTable = $('.ajax_datatable').DataTable({
            searchDelay : 500,
            processing  : true,
            serverSide  : false,
            order       : [[0, 'asc']],
            stateSave   : false,
            responsive  : false,
            ajax        : {
                url     : url_request,
                method  : 'GET',
                data    : params,
                dataSrc : '',
            },
            columns  : columns,
            language : {
                "processing": "Procesando...",
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "emptyTable": "Ningún dato disponible en esta tabla",
                "infoEmpty": "",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "search": "Buscar:",
                "infoThousands": ",",
                "loadingRecords": "Cargando...",
                // "paginate": {
                //     "first": "Primero",
                //     "last": "Último",
                //     "next": "Siguiente",
                //     "previous": "Anterior"
                // },
                "aria": {
                    "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                    "copy": "Copiar",
                    "colvis": "Visibilidad",
                    "collection": "Colección",
                    "colvisRestore": "Restaurar visibilidad",
                    "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
                    "copySuccess": {
                        "1": "Copiada 1 fila al portapapeles",
                        "_": "Copiadas %d fila al portapapeles"
                    },
                    "copyTitle": "Copiar al portapapeles",
                    "csv": "CSV",
                    "excel": "Excel",
                    "pageLength": {
                        "-1": "Mostrar todas las filas",
                        "1": "Mostrar 1 fila",
                        "_": "Mostrar %d filas"
                    },
                    "pdf": "PDF",
                    "print": "Imprimir"
                },
                "autoFill": {
                    "cancel": "Cancelar",
                    "fill": "Rellene todas las celdas con <i>%d<\/i>",
                    "fillHorizontal": "Rellenar celdas horizontalmente",
                    "fillVertical": "Rellenar celdas verticalmentemente"
                },
                "decimal": ",",
                "searchBuilder": {
                    "add": "Añadir condición",
                    "button": {
                        "0": "Constructor de búsqueda",
                        "_": "Constructor de búsqueda (%d)"
                    },
                    "clearAll": "Borrar todo",
                    "condition": "Condición",
                    "conditions": {
                        "date": {
                            "after": "Despues",
                            "before": "Antes",
                            "between": "Entre",
                            "empty": "Vacío",
                            "equals": "Igual a",
                            "notBetween": "No entre",
                            "notEmpty": "No Vacio",
                            "not": "Diferente de"
                        },
                        "number": {
                            "between": "Entre",
                            "empty": "Vacio",
                            "equals": "Igual a",
                            "gt": "Mayor a",
                            "gte": "Mayor o igual a",
                            "lt": "Menor que",
                            "lte": "Menor o igual que",
                            "notBetween": "No entre",
                            "notEmpty": "No vacío",
                            "not": "Diferente de"
                        },
                        "string": {
                            "contains": "Contiene",
                            "empty": "Vacío",
                            "endsWith": "Termina en",
                            "equals": "Igual a",
                            "notEmpty": "No Vacio",
                            "startsWith": "Empieza con",
                            "not": "Diferente de"
                        },
                        "array": {
                            "not": "Diferente de",
                            "equals": "Igual",
                            "empty": "Vacío",
                            "contains": "Contiene",
                            "notEmpty": "No Vacío",
                            "without": "Sin"
                        }
                    },
                    "data": "Data",
                    "deleteTitle": "Eliminar regla de filtrado",
                    "leftTitle": "Criterios anulados",
                    "logicAnd": "Y",
                    "logicOr": "O",
                    "rightTitle": "Criterios de sangría",
                    "title": {
                        "0": "Constructor de búsqueda",
                        "_": "Constructor de búsqueda (%d)"
                    },
                    "value": "Valor"
                },
                "searchPanes": {
                    "clearMessage": "Borrar todo",
                    "collapse": {
                        "0": "Paneles de búsqueda",
                        "_": "Paneles de búsqueda (%d)"
                    },
                    "count": "{total}",
                    "countFiltered": "{shown} ({total})",
                    "emptyPanes": "Sin paneles de búsqueda",
                    "loadMessage": "Cargando paneles de búsqueda",
                    "title": "Filtros Activos - %d"
                },
                "select": {
                    "1": "%d fila seleccionada",
                    "_": "%d filas seleccionadas",
                    "cells": {
                        "1": "1 celda seleccionada",
                        "_": "$d celdas seleccionadas"
                    },
                    "columns": {
                        "1": "1 columna seleccionada",
                        "_": "%d columnas seleccionadas"
                    },
                    "rows": {
                        "1": "1 fila seleccionada",
                        "_": "%d filas seleccionadas"
                    }
                },
                "thousands": ".",
                "datetime": {
                    "previous": "Anterior",
                    "next": "Proximo",
                    "hours": "Horas",
                    "minutes": "Minutos",
                    "seconds": "Segundos",
                    "unknown": "-",
                    "amPm": [
                        "am",
                        "pm"
                    ]
                },
                "editor": {
                    "close": "Cerrar",
                    "create": {
                        "button": "Nuevo",
                        "title": "Crear Nuevo Registro",
                        "submit": "Crear"
                    },
                    "edit": {
                        "button": "Editar",
                        "title": "Editar Registro",
                        "submit": "Actualizar"
                    },
                    "remove": {
                        "button": "Eliminar",
                        "title": "Eliminar Registro",
                        "submit": "Eliminar",
                        "confirm": {
                            "_": "¿Está seguro que desea eliminar %d filas?",
                            "1": "¿Está seguro que desea eliminar 1 fila?"
                        }
                    },
                    "error": {
                        "system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Más información&lt;\\\/a&gt;).<\/a>"
                    },
                    "multi": {
                        "title": "Múltiples Valores",
                        "info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.",
                        "restore": "Deshacer Cambios",
                        "noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo."
                    }
                },
                "info": "Mostrando registros del _START_ al _END_ de _TOTAL_ registros"
            }
        });
        return dataTable;
    }
    // PROCESS DATA BY AJAX
    let _activateConexionAjax = function(url,type,data){
        return $.ajax({
            "url"         : url,
            "method"      : type,
            "type"        : type,
            "data"        : data,
            "dataType"    : 'json',
            "contentType" : false,
            "processData" : false,
            "cache"       : false,
            success       : function(response) {
                // response.addHeader("Access-Control-Allow-Methods", "GET, POST, PATCH, PUT, DELETE");
                // console.log("Response from the factory => ",response);
            },
            error : function(error){
                console.log(error);
            }
        });
    }
    // ACTIVATE DATE PICKET
    let activateDatePicker = function () {
        let fecha_actual = new Date();
        $('.datepickerSingle').daterangepicker({ //single DatePicker
            "locale": {
                // format: 'DD/MM/YYYY hh:mm A'
                "format"      : 'DD/MM/YYYY',
                "daysOfWeek"  : ["Dom","Lun","Mar","Mier","Jue","Vie","Sáb"],
                "monthNames"  : ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
                "cancelLabel" : 'Cancelar',
                "applyLabel"  : 'Aceptar fecha'
            },
            "autoUpdateInput"  : false, //disable default date
            "singleDatePicker" : true,
            "showDropdowns"    : true,
            // "minDate"          : fecha_actual,
            // "minYear"          : fecha_actual.getFullYear() - 1,
            "maxYear"          : fecha_actual.getFullYear() + 5,
            "opens"            : "left",
            "drops"            : "down"
        });
        $('.datepickerSingle').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });

        $('.datepickerSingleWithTime').daterangepicker({ //single DatePicker
            "locale": {
                "format"      : 'DD/MM/YYYY hh:mm A',
                "daysOfWeek"  : ["Dom","Lun","Mar","Mier","Jue","Vie","Sáb"],
                "monthNames"  : ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
                "cancelLabel" : 'Cancelar',
                "applyLabel"  : 'Aceptar fecha'
            },
            "autoUpdateInput"  : false, //disable default date
            "singleDatePicker" : true,
            "showDropdowns"    : true,
            "timePicker"       : true,
            "maxYear"          : fecha_actual.getFullYear() + 5,
            "opens"            : "left",
            "drops"            : "down"
        });
        $('.datepickerSingleWithTime').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY hh:mm'));
        });
    }
    // REMOVE DIACRITICAL MARKS
    let removeDiacriticalMarks = function(value){
        return value.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    }
    // OPEN MODAL BY CLASS
    let openModalByClass = function(){
        $(document).on('click','.openModal',function(){
            $(`#${$(this).data('modal')}`).modal('show');
        })
    }
    // DATE FORMAT LONG
    function formatDateLong(){
        $.each($('.formatDateLong'),function(){
            var value  = $(this).text(),date,dateFormat;
            if(value != ''){
                date       = new Date(value),
                dateFormat = new Intl.DateTimeFormat('es', { year: 'numeric',month: 'long',day: '2-digit' }).format(date);
            } else {
                dateFormat = 'N/A';
            }
            $(this).text(dateFormat);
        });
    }
    // DATE FORMAT SHORT
    function formatDateShort(){
        $.each($('.formatDateShort'),function(){
            var value = $(this).text(),date,dateFormat;
            if(value != ''){
                date       = new Date(value),
                dateFormat = new Intl.DateTimeFormat('es', { year: 'numeric',month: '2-digit', day: '2-digit' }).format(date);
            } else {
                dateFormat = 'N/A';
            }
            $(this).text(dateFormat);
        });
    }
    // DATE FORMAT WITH TIME
    function formatDateWithTime(){
        $.each($('.formatDateWithTime'),function(){
            var value = $(this).text(),date,dateFormat;
            if(value != ''){
                date       = new Date(value);
                dateFormat = new Intl.DateTimeFormat('es', { year: 'numeric',month: '2-digit', day: '2-digit', hour: 'numeric', minute: 'numeric', second: 'numeric' }).format(date);
            } else {
                dateFormat = 'N/A';
            }
            $(this).text(dateFormat);
        });
    }
    // BUTTON SUBMIT LOADING
    let btnSubmitLoading = function(form,btn) {
        $(document).on('submit',form,function(){
            $(btn).attr('disabled',true).text('Guardando...').addClass('spinner spinner-white spinner-right');
        });
    }
    // FORM SUBMIT LOADING
    let formSubmitLoading = function(){
        $(document).on('submit','.form_loading',function(){
            $('.form_loading .btn_loading').attr('disabled',true).text('Guardando...').addClass('spinner spinner-white spinner-right');
        });
    }
    // DATA RETURN BY FACTORY
    return {
        // ACTIVATE GENERAL FUNCTIONS
        init: function() {
            activateDatePicker();
            openModalByClass();
            formatDateLong();
            formatDateShort();
            formatDateWithTime();
            formSubmitLoading();
        },
        "data": {
            // GENERAL DATA TO RETURN
        },
        "methods": {
            // ACTIVATE DATATABLE
            "activateDataTable" : function(url,columns,params = {}){
                return _ajaxDataTable(url,columns,params);
            },
            // ACTIVATE PROCESS DATA BY AJAX
            "processDataByAjax" : function(url,type,data = {}){
                return _activateConexionAjax(url,type,data);
            },
            // ACTIVATE REMOVE DIACRITICAL MARKS
            "removeDiacriticalMarks" : function(value){
                return removeDiacriticalMarks(value);
            },
            // ACTIVATE DATE PICKER
            "activateDatePicker": function(){
                activateDatePicker();
            },
            // ACTIVATE SUBMIT LOADING
            "activateSubmitLoading" : function(form,btn) {
                btnSubmitLoading(form,btn);
            }
        }
    };
}();

// INIT FACTORY INSTANCE
$(document).ready(function() {
    factoryNixDit.init();
});
