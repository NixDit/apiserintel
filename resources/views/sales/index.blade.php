@extends('administrator.index')
@section('title','Ventas | Serintel')
@section('content')

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="card card-custom">
            {{-- <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Categorias
                    <span class="d-block text-muted pt-2 font-size-sm">Lista de categorias registrados en el sistema</span></h3>
                </div>
            </div> --}}

            <div class="card-body">
                <div class="p-5">
                    <div class="col-md-4 my-2 my-md-0">
                        <div class="input-icon">
                            <input type="text" class="form-control" placeholder="Buscar cliente" id="filter_client_name"/>
                            <span>
                                <i class="flaticon2-search-1 text-muted"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <!--begin::Datatable-->
                <table class="table align-middle table-row-dashed fs-6 gy-4 ajax_datatable">
                    <thead>
                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                        <th>N°</th>
                        <th>Cliente</th>
                        <th>Empleado</th>
                        <th>Subtotal</th>
                        <th>Total</th>
                        <th>Tipo P.</th>
                        <th>Status</th>
                        <th>Folio</th>
                        <th>Fecha</th>
                        <th class="text-end min-w-100px">Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-bold">
                    </tbody>
                </table>
                <!--end::Datatable-->
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="detalles_del_producto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="detalles_del_producto" style="color:darkgray">Detalles de la Venta</h2>
        <button type="button" class="btn btn-outline-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body productos_content">
        <table class="table table-bordered table-striped text-center">
            <thead style="color:darkcyan">
                <tr>
                    <th>
                        Nombre del Producto 
                    </th>
                    <th>
                        Subtotal 
                    </th>
                    <th>
                        Cantidad Vendida
                    </th>
                    <th>
                        Total
                    </th>
                    
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-success " data-dismiss="modal">Cerrar Ventana</button>
        
      </div>
    </div>
  </div>
</div>


@endsection
@section('scripts')
@push('scripts')
    <script>
        
    $(function(){
        $(function(){

            $('#detalles_del_producto').on('click',function(){
                $('#detalles_del_producto').modal('hide');
                $('#detalles_del_producto').append();
            });

        });
       

    }());
    </script>
    <script type="text/javascript" src="{{  URL::asset ('js/serintel/sales/sales.js?v='.rand())  }}"></script>
@endpush

