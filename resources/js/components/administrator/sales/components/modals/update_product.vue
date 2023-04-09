<template lang="">
    <div class="modal fade" id="modal_update_product" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-600px">
            <div class="modal-content rounded">
                <div class="modal-header justify-content-end border-0 pb-0">
                    <div class="btn btn-sm btn-icon btn-active-color-danger" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body pt-0 pb-15 px-5 px-xl-20">
                    <div class="mb-13 text-center" v-if="product_data">
                        <h1 class="mb-3">Editar total para el producto {{ product_data.product.name }}</h1>
                    </div>
                    <div class="card-body pt-5">
                        <h4 class="text-center" v-if="product_data">Total actual ${{ product_data.total }}</h4>
                        <input type="number" class="form-control" v-model="new_total" placeholder="Nuevo total" autocomplete="off"/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-light-success font-weight-bold" @click="updateProduct">Actualizar</button>
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
            product_data : null,
            new_total    : null,
            index_p      : 0
        }
    },
    methods: {
        openModal(){
            this.new_total = null;
            $('#modal_update_product').modal('show');
        },
        setData(product,index){
            this.index_p      = index;
            this.product_data = product;
        },
        updateProduct(){
            if(this.new_total != null && this.new_total != '' && this.new_total > 0){
                let data = {
                    "index" : this.index_p,
                    "total" : this.new_total
                };
                this.$emit("updateProduct",data);
                $('#modal_update_product').modal('hide');
            } else {
                Swal.fire({
                    icon  : 'warning',
                    title : 'Cuidado',
                    text  : 'Escriba una cantidad válida para el total'
                })
            }
        }
    },
}
</script>
