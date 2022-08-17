@extends('administrator.index')
@section('title','Clientes | Serintel')
@section('content')
<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="card card-custom">
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
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Correo electrónico</th>
                        <th>Negocio</th>
                        <th>Código</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th class="text-center min-w-100px">Acciones</th>
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
    <script type="text/javascript" src="{{  URL::asset ('js/serintel/clients/clients.js?v='.rand())  }}"></script>
@endpush
