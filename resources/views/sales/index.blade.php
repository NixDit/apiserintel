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
                <table class="table align-middle table-row-dashed fs-6 gy-5 ajax_datatable">
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
                        {{-- <th class="text-end min-w-100px">Acciones</th> --}}
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
@endsection
@push('scripts')
    <script type="text/javascript" src="{{  URL::asset ('js/serintel/sales/sales.js?v='.rand())  }}"></script>
@endpush

