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
</style>
<template>
    <div class="container-fluid">
        <div class="row">
            <!-- PRODUCTS -->
            <div class="col-md-8">
                <div class="card card-custom">
                    <div class="card-header flex-wrap border-0 p-5">
                        <div class="card-body p-0">
                            <!-- Search product -->
                            <div class="form-group mb-5">
                                <input type="text" v-model="product_search" class="form-control mb-2 mb-md-0" placeholder="Buscar producto" />
                                <div id="products_found_content" style="display: none;">
                                    <div v-if="searching_product">
                                        <p class="badge badge-info">Buscando...</p>
                                    </div>
                                    <div class="menu-products-to-select" v-else>
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
                                                        <span class="text-gray-800 fw-bolder fs-3">${{ product_f.cost }}</span>
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
                            <div class="table-responsive table-products-content">
                                <!-- Table products -->
                                <table class="table table-row-dashed align-middle gs-0 gy-4 my-0" id="table_products">
                                    <thead class="table-products-head bg-success text-white">
                                        <tr class="border-bottom-0 text-center">
                                            <th>Productos</th>
                                            <th>Precio</th>
                                            <th width="150px">Cantidad</th>
                                            <th width="150px">Total</th>
                                            <th width="50px"></th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="products_selected.length > 0">
                                        <tr class="text-center" v-for="(product,index) in products_selected" :key="index">
                                            <td>
                                                <a href="../../demo13/dist/apps/ecommerce/catalog/edit-product.html" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6 pe-0">{{ product.name }}</a>
                                                <span class="text-gray-400 fw-semibold fs-7 d-block ps-0">{{ product.code }}</span>
                                            </td>
                                            <td>
                                                <span class="text-gray-800 fw-bold d-block fs-6">${{ product.cost }}</span>
                                            </td>
                                            <td>
                                                <span class="text-gray-800 fw-bold d-block fs-6 ps-0">
                                                    <div class="input-group input-group-sm mb-5">
                                                        <span class="input-group-text" style="cursor: pointer;" @click="substractQuantityProduct(index)">-</span>
                                                        <input type="text" class="form-control text-center onlyNumberValue" v-model="product.quantity" @input="checkQuantityProduct(index)"/>
                                                        <span class="input-group-text" style="cursor: pointer;" @click="addQuantityProduct(index)">+</span>
                                                    </div>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-gray-800 fw-bold d-block fs-6">${{ product.total }}</span>
                                            </td>
                                            <td>
                                                <button class="btn btn-icon btn-danger" @click="removeProduct(index)">
                                                    <i class="fonticon-trash-bin"></i>
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
                            <div class="form-group mb-5">
                                <select class="form-select" data-control="select2" data-placeholder="Buscar cliente">
                                    <option></option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            product_search    : null,
            products_found    : [],
            products_selected : [],
            timer_search      : null,
            searching_product : true
        }
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
        }
    },
    methods: {
        searchProduct(){ // Function to search product by name
            let _this              = this;
            this.searching_product = true;
            axios.get(`/product/search`,{
                params: {
                    search : this.product_search
                }
            }).then(function(response){
                response = response.data;
                if(!response.error){
                    _this.products_found = response.products;
                }
                _this.searching_product = false;
            });
        },
        selectProduct(product){ // Set products to list of products selected
            let product_exists = this.existsProductSelected(product); // Verifica si el producto ya fue agregado, en caso que si le suma +1 en su cantidad
            if(!product_exists){
                this.products_selected.push({
                    "id"       : product.id,
                    "name"     : product.name,
                    "cost"     : product.cost,
                    "quantity" : 1,
                    "total"    : product.cost * 1,
                });
            }
            this.resetProductsFound();
        },
        existsProductSelected(product){ // Check if the product to add exists, if exists in products selected add +1
            if(this.products_selected.length > 0){
                let product_exists = this.products_selected.find(product_f => product_f.id == product.id);
                if(product_exists){
                    let product_index = this.products_selected.findIndex(product_s => product_s.id == product_exists.id);
                    if(product_index != -1){ // Index is found
                        this.addQuantityProduct(product_index);
                    }
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
                    product_to_edit.quantity -= 1;
                    product_to_edit.total     = product_to_edit.quantity * product_to_edit.cost;
                }
            }
        },
        addQuantityProduct(index){ // Add +1 to the product quantity
            let product_to_edit = this.products_selected[index];
            if(product_to_edit){
                product_to_edit.quantity += 1;
                product_to_edit.total     = product_to_edit.quantity * product_to_edit.cost;
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
                    product_to_check.total    = product_to_check.cost;
                } else {
                    product_to_check.total = product_to_check.quantity * product_to_check.cost;
                }
            }
        },
        removeProduct(index){ // Remove product
            this.products_selected.splice(index,1);
        }
    }
}
</script>