<style>
.prices-card{
    max-height: 500px !important;
    overflow: auto !important;
}
.menu-products-to-select{
    max-height: 250px !important;
    overflow: auto !important;
}
.menu-products-to-select .product-element{
    cursor: pointer;
}
.menu-products-to-select .product-element:hover{
    background-color: #e8fff3 !important;
}
.content-price-summary{
    border-radius: 5px;
}

/* FIXED TABLE HEADER */
.table-products-content{
    max-height: 400px;
    overflow: auto !important;
}
.table-products-content #table_products .table-products-head{
    position: -webkit-sticky;
    position: sticky;
    top: 0;
    z-index: 1;
}

.small-alerts{
    font-size: 9px;
}
</style>
<template>
    <div class="container-fluid">
        <div id="ticket_content_data"></div>
        <div class="row">
            <!-- PRODUCTS -->
            <div class="col-md-8">
                <div class="card card-custom">
                    <div class="card-header flex-wrap border-0 p-5">
                        <div class="card-body p-0">
                            <div class="d-flex justify-content-end mb-1">
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input h-20px w-30px" type="checkbox" v-model="scan_codes" id="flexSwitchDefault"/>
                                    <label class="form-check-label" for="flexSwitchDefault">Escanear código</label>
                                </div>
                            </div>
                            <!-- Search product -->
                            <div class="form-group mb-5">
                                <!-- Search -->
                                <input type="text" v-model="product_search" class="form-control mb-2 mb-md-0" placeholder="Buscar producto" />
                                <!-- Search options -->
                                <div id="products_found_content" style="display: none;">
                                    <div v-if="searching_product">
                                        <p class="badge badge-info">Buscando...</p>
                                    </div>
                                    <div class="menu-products-to-select" v-if="!searching_product && !scan_codes">
                                        <div v-if="products_found.length > 0" class="my-5 px-5">
                                            <div class="d-flex p-5 product-element" v-for="(product_f,index_p) in products_found" :key="index_p" @click="selectProduct(product_f)">
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-60px flex-shrink-0 me-4">
                                                    <img :src="(product_f.image) ? product_f.image : '/metronic/assets/media/products/image.png' " class="mw-100" alt="">
                                                </div>
                                                <!--end::Symbol-->
                                                <!--begin::Section-->
                                                <div class="d-flex align-items-center flex-wrap flex-grow-1 mt-n2 mt-lg-n1">
                                                    <!--begin::Title-->
                                                    <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pe-3">
                                                        <span class="fs-5 text-success fw-bold">{{ product_f.name }}</span>

                                                        <span class="text-gray-400 fw-semibold fs-7 my-1">{{ product_f.description }}</span>

                                                        <span class="text-gray-400 fw-semibold fs-7">
                                                            Código: <span class="text-primary fw-bold">{{ product_f.code }}</span>
                                                        </span>
                                                    </div>
                                                    <!--end::Title-->
                                                    <!--begin::Info-->
                                                    <div class="text-end py-lg-0 py-2">
                                                        <span class="text-gray-800 fw-bolder fs-3">${{ product_f.retail_price }}</span>
                                                        <span class="text-gray-400 fs-7 fw-semibold d-block">Sales</span>
                                                    </div>
                                                    <!--end::Info-->
                                                </div>
                                                <!--end::Section-->
                                            </div>
                                        </div>
                                        <div v-else>
                                            <p class="badge badge-info">Sin resultados</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Table products -->
                            <div class="table-responsive table-products-content">
                                <table class="table table-row-dashed align-middle gs-0 gy-4 my-0" id="table_products">
                                    <thead class="table-products-head bg-success text-white">
                                        <tr class="border-bottom-0 text-center">
                                            <th>Productos</th>
                                            <th width="135px">Cantidad</th>
                                            <th width="150px">Total</th>
                                            <th width="125px"></th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="products_selected.length > 0">
                                        <tr class="text-center" v-for="(product,index) in products_selected" :key="index">
                                            <td>
                                                <a role="button" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6 pe-0" @click="showProductDetails(product)">{{ product.product.name }}</a>
                                                <span class="text-gray-400 fw-semibold fs-7 d-block ps-0">{{ product.product.code }}</span>
                                                <div v-if="product.recharge_data.is_recharge">
                                                    <small class="small-alerts"><strong>Teléfono:</strong> {{ product.recharge_data.phonenumber }}</small><br />
                                                    <small class="small-alerts"><strong>Compañia:</strong> {{ product.recharge_data.company_data.name }}</small>
                                                </div>
                                                <div v-if="product.service_data.is_service">
                                                    <small class="small-alerts"><strong>Nº servicio:</strong> {{ product.service_data.folio }}</small><br />
                                                    <small class="small-alerts"><strong>Compañia:</strong> {{ product.service_data.company_data.name }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-gray-800 fw-bold d-block fs-6 ps-0">
                                                    <div class="input-group input-group-sm mb-5" v-if="!product.recharge_data.is_recharge && !product.service_data.is_recharge">
                                                        <span class="input-group-text" style="cursor: pointer;" @click="substractQuantityProduct(index)">-</span>
                                                        <input type="text" class="form-control text-center onlyNumberValue" v-model="product.quantity" @input="checkQuantityProduct(index)"/>
                                                        <span class="input-group-text" style="cursor: pointer;" @click="addQuantityProduct(index)">+</span>
                                                    </div>
                                                    <p v-else>1</p>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-gray-800 fw-bold d-block fs-6">${{ stringFormatCommas(product.total) }}</span>
                                            </td>
                                            <td>
                                                <button class="btn btn-icon btn-danger" title="Eliminar" @click="removeProduct(index)">
                                                    <i class="fonticon-trash-bin"></i>
                                                </button>
                                                <button class="btn btn-icon btn-warning" title="Editar total" @click="editTotal(index)" v-if="is_superadmin">
                                                    <i class="bi bi-pencil "></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr class="text-center">
                                            <td colspan="5">
                                                <span>Sin productos agregados</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- PRICE SUMMARY -->
            <div class="col-md-4 prices-card">
                <div class="card card-custom ">
                    <div class="card-header flex-wrap border-0 p-5">
                        <div class="card-body p-0">
                            <!-- Clients -->
                            <div class="form-group mb-5">
                                <select class="form-select" data-control="select2" data-placeholder="Buscar cliente" id="client_select">
                                    <option></option>
                                </select>
                                <small class="small-alerts">Si no se selecciona un cliente, este guardará como cliente global</small>
                            </div>
                            <!-- Total data -->
                            <div class="bg-success p-2 content-price-summary">
                                <div class="row">
                                    <!-- Quantity products selected -->
                                    <div class="col-md-7">
                                        <p class="text-white text-start">Cantidad de productos</p>
                                    </div>
                                    <div class="col-md-5">
                                        <p class="text-white text-end">{{ products_selected.length }}</p>
                                    </div>
                                    <!-- Subtotal -->
                                    <div class="col-md-7">
                                        <p class="text-white text-start">Subtotal</p>
                                    </div>
                                    <div class="col-md-5">
                                        <p class="text-white text-end">${{ stringFormatCommas(subtotal) }}</p>
                                    </div>
                                    <!-- Total -->
                                    <div class="col-md-7 mt-5">
                                        <h2 class="text-white text-start">TOTAL</h2>
                                    </div>
                                    <div class="col-md-5 mt-5">
                                        <h2 class="text-white text-end">${{ stringFormatCommas(total) }}</h2>
                                    </div>
                                </div>
                            </div>
                            <!-- Payment method -->
                            <div class="row mt-5">
                                <p class="col-md-12 text-center">Método de pago</p>
                                <div class="col-md-6">
                                    <label :class="['form-check-image', {'active' : payment_method == 1}]">
                                        <div class="form-check-wrapper">
                                            <img src="/metronic/assets/media/stock/600x400/img-1.jpg"/>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio" checked value="1" v-model="payment_method"/>
                                            <div class="form-check-label">
                                                Efectivo
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label :class="['form-check-image', {'active' : payment_method == 2}]">
                                        <div class="form-check-wrapper">
                                            <img src="/metronic/assets/media/stock/600x400/img-2.jpg"/>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid me-10">
                                            <input class="form-check-input" type="radio" value="2" v-model="payment_method"/>
                                            <div class="form-check-label">
                                                Tarjeta
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <!-- Make sale -->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <button class="btn btn-primary w-100" @click="makeSale">Realizar venta</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODALS -->
        <modal-update-product
            ref="modal_update_product"
            @updateProduct="updateProduct"
        ></modal-update-product> <!-- Update product data -->
        <modal-add-recarga
            ref="modal_add_recarga"
            @addProduct="addProduct"
        ></modal-add-recarga> <!-- Add recarga -->
        <modal-add-servicio
            ref="modal_add_servicio"
            @addProduct="addProduct"
        ></modal-add-servicio> <!-- Add servicio -->
    </div>
</template>
<script>
import { stringFormatCommas } from '../../../utils/commonFunctions';
import modalUpdateProduct from './components/modals/update_product.vue';
import modalAddRecarga from './components/modals/recarga_info.vue';
import modalAddServicio from './components/modals/servicio_info.vue';
export default {
    data(){
        return {
            product_search    : null,
            products_found    : [],
            products_selected : [],
            timer_search      : null,
            searching_product : true,
            payment_method    : 1,
            clients           : [],
            client_id         : 0,
            ticket_data       : null,
            actual_user       : window.Laravel.user,
            is_superadmin     : window.Laravel.user.roles.some(r => r.name == 'superadmin'),
            scan_codes        : false
        }
    },
    components: {
        "modal-update-product" : modalUpdateProduct,
        "modal-add-recarga"    : modalAddRecarga,
        "modal-add-servicio"   : modalAddServicio
    },
    watch: {
        "product_search" : function(newValue, oldValue){
            window.clearTimeout(this.timer_search); // Reinicia el timeout cada vez que el usuario escriba sobre el campo para no ejecutar la búsqueda
            if(newValue != '' && newValue != null){
                this.timer_search = setTimeout(() => {
                    $('#products_found_content').show();
                    this.searchProduct(); // Si el usuario dejo de escribir, se realiza la búsqueda de productos
                }, 500); // 0.5 sec delay
            } else {
                $('#products_found_content').hide();
                this.products_found = [];
            }
        },
        "scan_codes" : function(newValue, oldValue){
            this.searchProduct();
        }
    },
    computed: {
        subtotal(){
            return this.products_selected.reduce((sum,product) => sum + product.total,0);
        },
        total(){
            return this.subtotal;
        }
    },
    mounted(){
        this.getClients();
        let _this = this;
        $(document).on('click','.print-ticket',function(e){ _this.printTicket(); });
    },
    methods: {
        getClients(){ // Get all clients
            let _this = this;
            axios.get(`/clients/get-general-all`).then(function(response){
                _this.clients = response.data;
                _this.clients.forEach(client => { // Fill client's select tag
                    var newOption = new Option(client.business_name, _this.formatCodeClients(client.code), false, false);
                    $('#client_select').append(newOption).trigger('change'); // Add and refresh content data
                });
                _this.onChangeSelectData();
            });
        },
        onChangeSelectData(){
            let _this = this;
            $('#client_select').on('select2:select', function (e) { // Set "id" value of selected option in client's select tag
                var data             = e.params.data;
                _this.payment_method = null;
                _this.client_id      = data.id;
            });
        },
        formatCodeClients(value){ // Covert code(SC-000001) of clients to int value
            return Number(value.replace(/SC-/g,''));
        },
        searchProduct(){ // Function to search product by name
            let _this              = this;
            this.searching_product = true;
            axios.get(`/product/search`,{
                params: {
                    search    : this.product_search,
                    scan_code : this.scan_codes
                }
            }).then(function(response){
                response = response.data;
                if(!response.error){
                    _this.products_found = response.products;
                    if(_this.scan_codes){
                        if(_this.products_found.length > 0){
                            _this.selectProduct(_this.products_found[0]);
                        } else {
                            _this.product_search = null;
                            Swal.fire({
                                title : 'Cuidado',
                                text  : 'Ningún producto/servicio encontrado',
                                icon  : 'warning'
                            });
                        }
                    }
                }
                _this.searching_product = false;
            });
        },
        selectProduct(product){ // Set products to list of products selected
            if(product.category_id == 3){ // If category product is "recarga"
                this.openModalRecarga(product);
                return false;
            }
            if(product.category_id == 2){ // If category product is "servicio"
                this.openModalServicio(product);
                return false;
            }
            let product_exists = this.existsProductSelected(product); // Verifica si el producto ya fue agregado, en caso que si le suma +1 en su cantidad
            if(!product_exists){
                this.addProduct(product);
            }
        },
        addProduct(product){
            this.products_selected.push({
                "product" : {
                    "id"           : product.id,
                    "name"         : product.name,
                    "retail_price" : product.retail_price,
                    "code"         : product.code
                },
                "recharge_data" : {
                    "is_recharge"  : (product.category_id == 3) ? true : false,
                    "phonenumber"  : product.phonenumber,
                    "company_id"   : product.company_id,
                    "company_data" : product.company_data
                },
                "service_data" : {
                    "is_service"   : (product.category_id == 2) ? true : false,
                    "folio"        : product.folio,
                    "company_id"   : product.company_id,
                    "company_data" : product.company_data
                },
                "quantity"   : 1,
                "subtotal"   : product.retail_price,
                "total"      : (product.retail_price * 1), // If is "recarga" add +$1 commission
            });
            this.resetProductsFound();
        },
        existsProductSelected(product){ // Check if the product to add exists, if exists in products selected add +1
            if(this.products_selected.length > 0){
                let product_exists = this.products_selected.find(product_f => product_f.product.id == product.id);
                if(product_exists){
                    let product_index = this.products_selected.findIndex(product_s => product_s.product.id == product_exists.product.id);
                    if(product_index != -1){ // Index is found
                        this.addQuantityProduct(product_index);
                    }
                    this.resetProductsFound();
                    return true;
                }
            }

            return false;
        },
        resetProductsFound(){ // Reset product search
            this.product_search    = null;
            this.searching_product = false;
        },
        substractQuantityProduct(index){ // Substract +1 to the product quantity
            let product_to_edit = this.products_selected[index];
            if(product_to_edit){
                if(product_to_edit.quantity > 1){
                    product_to_edit.quantity = Number(product_to_edit.quantity) - 1;
                    product_to_edit.total    = product_to_edit.quantity * product_to_edit.product.retail_price;
                }
            }
        },
        addQuantityProduct(index){ // Add +1 to the product quantity
            let product_to_edit = this.products_selected[index];
            if(product_to_edit){
                product_to_edit.quantity = Number(product_to_edit.quantity) + 1;
                product_to_edit.total    = product_to_edit.quantity * product_to_edit.product.retail_price;
            }
        },
        checkQuantityProduct(index){ // Check quantity of product
            let product_to_check = this.products_selected[index];
            if(product_to_check){
                let quantity = product_to_check.quantity;
                if(
                    quantity < 1 ||
                    quantity == null ||
                    quantity == ''
                ){
                    product_to_check.quantity = 1;
                    product_to_check.total    = product_to_check.retail_price;
                } else {
                    product_to_check.total = product_to_check.quantity * product_to_check.retail_price;
                }
            }
        },
        removeProduct(index){ // Remove product
            this.products_selected.splice(index,1);
        },
        showProductDetails(product){ // Show dialog with product details
            console.log(product);
        },
        stringFormatCommas(value){ // Format string value to 999,999.00
            return stringFormatCommas(value);
        },
        makeSale(){ // Make sale and show tickets options
            let sale_valid = this.validationSale();
            let _this      = this;
            if(sale_valid){
                Swal.fire({
                    text              : "¿Está seguro de realizar la venta?",
                    icon              : "warning",
                    showCancelButton  : true,
                    buttonsStyling    : false,
                    confirmButtonText : "¡Si!",
                    cancelButtonText  : "No, cancelar",
                    customClass : {
                        confirmButton : "btn fw-bold btn-primary",
                        cancelButton  : "btn fw-bold btn-active-danger"
                    }
                }).then(function (result) {
                    if (result.value) {
                        axios.post(`/api/sale`,{
                            "products"       : JSON.stringify(_this.products_selected),
                            "client_id"      : _this.client_id,
                            "subtotal"       : _this.subtotal,
                            "total"          : _this.total,
                            "type"           : 2, // 1:Prepago, 2:Pagado, 3:Postpago
                            "payment_method" : _this.payment_method
                        }).then(function(response){
                            response = response.data;
                            if(response.ok){
                                _this.ticket_data = response.ticket;
                                Swal.fire({
                                    title : 'Venta realizada',
                                    html  : `
                                        <div class="row m-0">
                                            <div class="col-md-6">
                                                <button class="btn btn-outline-primary print-ticket">Imprimir recibo</button>
                                            </div>
                                            <div class="col-md-6">
                                                <a href="/sales/download-ticket?folio=${_this.ticket_data.folio}" target="_blank" class="btn btn-outline-success download-ticket">Descargar recibo</a>
                                            </div>
                                        </div>
                                    `,
                                    text  : response.message,
                                    icon  : 'success'
                                });
                                _this.resetSaleData();
                            } else {
                                Swal.fire({
                                    title : 'ERROR',
                                    text  : response.message,
                                    icon  : 'error'
                                });
                            }
                        });
                    }
                });
            }
        },
        validationSale(){ // Validation of sale data
            if(this.products_selected.length == 0){
                Swal.fire({
                    title : 'Cuidado',
                    text  : "Agregue al menos 1 producto a vender",
                    icon  : 'warning'
                })
                return false;
            }
            // if(this.client_id == null  || this.client_id == 0 || this.client_id == ''){
            //     Swal.fire({
            //         title : 'Cuidado',
            //         text  : "Seleccione un cliente",
            //         icon  : 'warning'
            //     })
            //     return false;
            // }
            if(this.payment_method == null || this.payment_method == 0 || this.payment_method == ''){
                Swal.fire({
                    title : 'Cuidado',
                    text  : "Seleccione un método de pago",
                    icon  : 'warning'
                })
                return false;
            }
            return true;
        },
        resetSaleData(){ // Reset all sale data
            this.product_search    = null;
            this.products_found    = [];
            this.products_selected = [];
            this.timer_search      = null;
            this.searching_product = true;
            this.payment_method    = 1;
            this.clients           = [];
            this.client_id         = 0;
            $('#client_select').val(null);
            $('#client_select').trigger('change');
            $('#ticket_content_data').empty();
        },
        printTicket(){ // Print ticket data
            $('#ticket_content_data').empty();
            axios.get(`/sales/get-ticket-view-data`,{
                params : {
                    "folio" : this.ticket_data.folio
                }
            }).then(function(response) {
                $('#ticket_content_data').html(response.data);
                $('#ticket_content_data').printThis({
                    "importStyle" : true,
                    "importCSS"   : true,
                    afterPrint : function(){
                        $('#ticket_content_data').empty();
                    }
                });
            });
        },
        editTotal(index){
            let product = this.products_selected[index];
            this.$refs.modal_update_product.setData(product,index);
            this.$refs.modal_update_product.openModal();
        },
        updateProduct(data){
            this.products_selected[data.index].total = Number(data.total);
        },
        openModalRecarga(product){
            this.$refs.modal_add_recarga.openModal(product);
        },
        openModalServicio(product){
            this.$refs.modal_add_servicio.openModal(product);
        }
    }
}
</script>