<template lang="">
    <div class="modal fade" id="modal_data_info" aria-hidden="true">
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
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Información para la recarga</h1>
                    </div>
                    <div class="card-body pt-5">
                        <div class="form-group">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span class="required">Teléfono</span>
                            </label>
                            <input type="tel" class="form-control" v-model="phonenumber" placeholder="0000000000" maxlength="10" autocomplete="off"/>
                        </div>
                        <div class="form-group">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span class="required">Compañia</span>
                            </label>
                            <select class="form-select" v-model="companie_id" placeholder="Seleccione una compañia" id="company_select">
                                <option v-for="(companie,index_c) in companies" :key="index_c" :value="companie.id">{{ companie.name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span class="required">Cantidad</span>
                            </label>
                            <input type="number" class="form-control" v-model="quantity" placeholder="20" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-light-success font-weight-bold" @click="addRecarga">Agregar +</button>
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
            companies    : [],
            companie_id  : null,
            phonenumber  : null,
            quantity     : 20
        }
    },
    methods: {
        openModal(product){
            this.product_data = product;
            this.resetData();
            this.getCompanies();
            $('#modal_data_info').modal('show');
        },
        resetData(){
            this.phonenumber = null;
            this.companie_id = 0;
        },
        getCompanies(){ // Get all clients
            let _this = this;
            axios.get(`/companycellphone/get-cellphone-all`).then(function(response){
                _this.companies = response.data;
            });
        },
        addRecarga(){
            let data_is_valid = this.validateData();
            if(data_is_valid){
                this.product_data.phonenumber  = this.phonenumber;
                this.product_data.company_id   = this.companie_id;
                this.product_data.company_data = this.searchCompany(this.companie_id);
                this.product_data.retail_price = this.quantity;
                this.$emit("addProduct",this.product_data);
                $('#modal_data_info').modal('hide');
            }
        },
        validateData(){
            if(this.phonenumber == null || this.phonenumber == ''){
                Swal.fire({
                    icon  : 'warning',
                    title : 'Cuidado',
                    text  : 'Escriba un número de teléfono'
                })
                return false;
            }
            if(this.companie_id == null || this.companie_id == '' || this.companie_id == 0){
                Swal.fire({
                    icon  : 'warning',
                    title : 'Cuidado',
                    text  : 'Seleccione una compañia'
                })
                return false;
            }
            if(this.quantity == null || this.quantity == '' || this.quantity <= 0){
                Swal.fire({
                    icon  : 'warning',
                    title : 'Cuidado',
                    text  : 'Ingresa una cantidad válida'
                })
                return false;
            }
            return true;
        },
        searchCompany(id){
            return this.companies.find( companie => companie.id == id );
        }
    },
}
</script>
