<template>
    <div class="d-flex flex-center w-lg-50 p-10">
        <!--begin::Card-->
        <div class="card rounded-3 w-md-550px">
            <!--begin::Card body-->
            <div class="card-body p-10 p-lg-20">
                <!--begin::Form-->
                <!-- <form method="POST" class="form w-100" id="kt_sign_in_form" :action="action_login"> -->
                <form class="form w-100" :action="action_login"  method="POST" @submit="validateForm">
                    <!--begin::Heading-->
                    <div class="text-center mb-11">
                        <!--begin::Title-->
                        <h1 class="text-dark fw-bolder mb-3">Iniciar sesión</h1>
                        <!--end::Title-->
                        <!--begin::Subtitle-->
                        <div class="text-gray-500 fw-semibold fs-6">Ingrese sus credenciales de acceso</div>
                        <!--end::Subtitle=-->
                    </div>
                    <!--begin::Heading-->
                    <!--begin::Login options
                    <div class="row g-3 mb-9">
                        <div class="col-md-6">
                            <a href="#" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                            <img alt="Logo" src="metronic/assets/media/svg/brand-logos/google-icon.svg" class="h-15px me-3" />Iniciar con Google</a>
                        </div>
                        <div class="col-md-6">
                            <a href="#" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                            <img alt="Logo" src="metronic/assets/media/svg/brand-logos/apple-black.svg" class="theme-light-show h-15px me-3" />
                            <img alt="Logo" src="metronic/assets/media/svg/brand-logos/apple-black-dark.svg" class="theme-dark-show h-15px me-3" />Iniciar con Apple</a>
                        </div>
                    </div>
                    end::Login options-->
                    <!--begin::Separator
                    <div class="separator separator-content my-14">
                        <span class="w-125px text-gray-500 fw-semibold fs-7">o con correo</span>
                    </div>
                    end::Separator-->
                    <input type="hidden" name="_token" :value="csrfToken">
                    <!--begin::Input group=-->
                    <div class="fv-row mb-8">
                        <!--begin::Email-->
                        <input type="text" v-model="email" placeholder="Correo" name="email" autocomplete="off" class="form-control bg-transparent" />
                        <!--end::Email-->
                        <!-- Email msg error -->
                        <span class="text-danger" v-if="email_error">{{ email_msg }}</span>
                    </div>
                    <!--end::Input group=-->
                    <div class="fv-row mb-3">
                        <!--begin::Password-->
                        <input type="password" v-model="password" placeholder="Contraseña" name="password" autocomplete="off" class="form-control bg-transparent" />
                        <!--end::Password-->
                        <span class="text-danger" v-if="password_error">{{ password_msg }}</span>
                    </div>
                    <!--end::Input group=-->
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                        <div></div>
                        <!--begin::Link-->
                        <a href="" class="link-primary">¿Olvidó su contraseña?</a>
                        <!--end::Link-->
                    </div>
                    <div class="alert alert-warning d-flex align-items-center p-5 mb-10" v-if="errors.length > 0">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->
                        <span class="svg-icon svg-icon-2hx svg-icon-warning me-4">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="currentColor"></path>
                                <path d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z" fill="currentColor"></path>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-warning">¡Cuidado!</h4>
                            <ul>
                                <li v-for="(error,index) in errors" :key="index">{{ error }}</li>
                            </ul>
                        </div>
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Submit button-->
                    <div class="d-grid mb-10">
                        <button type="submit" class="btn btn-primary" :disabled="loading">
                            <!--begin::Indicator progress-->
                            <span v-if="loading">
                                Iniciando sesión
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                            <!--end::Indicator progress-->
                            <!--begin::Indicator label-->
                            <span v-else>Iniciar sesión</span>
                            <!--end::Indicator label-->
                        </button>
                    </div>
                    <!--end::Submit button-->
                    <!--begin::Sign up-->
                    <!-- <div class="text-gray-500 text-center fw-semibold fs-6">¿Aún no estas registrado?
                    <a :href="route_register" class="link-primary">Registrarse</a></div> -->
                    <!--end::Sign up-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
</template>
<script>
export default {
    props : ['route_register','action_login','session_errors'],
    data(){
        return {
            csrfToken      : window.Laravel.csrfToken,
            url_base       : window.Laravel.baseUrl,
            loading        : false,
            email          : null,
            password       : null,
            email_error    : false,
            email_msg      : null,
            password_error : false,
            password_msg   : null,
            errors         : (this.session_errors) ? JSON.parse(this.session_errors) : []
        }
    },
    methods: {
        validateForm(event) {
            let hasError = false;
            this.loading = true;
            if(this.email == null || this.email == ''){
                this.email_msg   = 'El email es requerido';
                this.email_error = true;
                hasError         = true;
            } else {
                if(!this.validEmail()){
                    this.email_msg   = 'El email es inválido';
                    this.email_error = true;
                    hasError         = true;
                } else {
                    this.email_error = false;
                }
            }
            if(this.password == null || this.password == ''){
                this.password_msg   = 'La contraseña es requerida';
                this.password_error = true;
                hasError            = true;
            } else {
                this.password_error = false;
            }
            if(hasError){
                event.preventDefault();
                this.loading = false;
            }
        },
        validEmail(){
            var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            return regex.test(this.email);
        }
    }
}
</script>
