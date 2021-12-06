<template>
    <div class="auth-wrapper auth-v2">
        <div class="auth-inner row m-0"><a class="brand-logo" href="javascript:void(0);">
            <h2 class="brand-text text-primary ml-1">Logo Gestão ILPI</h2>
        </a>
            <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img
                    class="img-fluid" src="#" alt="Imagem Gestão ILPI"/>
                </div>
            </div>
            <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                <div class="col-12 col-sm-8 col-md-6 col-lg-12 p-0 mx-auto">
                    <h2 class="card-title font-weight-bold mb-1">Boas Vindas ao Gestão ILPI 👋</h2>
                    <p class="card-text mb-2">Digite seu Login e Senha para entrar no Sistema</p>
                    <form class="auth-login-form mt-2" method="POST" action="" @submit.prevent="login">
                        <input type="hidden" name="_token" :value="token_csrf">
                        <div class="form-group">
                            <label class="form-label" for="email">E-mail</label>
                            <input id="email" type="email" class="form-control" name="email" value=""
                                   required autocomplete="email" placeholder="usuario@gestaoilpi.com.br" autofocus
                                   v-model="email">
                            <span class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-between">
                                <label for="password">Senha</label>
                                <a href="#"><small>Esqueceu sua senha?</small></a>
                            </div>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input id="password" type="password"
                                       class="form-control form-control-merge" name="password"
                                       required autocomplete="current-password" v-model="password"
                                       placeholder="············">
                                <div class="input-group-append">
                                    <span class="input-group-text cursor-pointer">
                                        <i data-feather="eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">

                                <label class="form-check-label" for="remember">
                                    Mantenha-me conectado
                                </label>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block" tabindex="4">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["token_csrf", "urlBaseApi"],
    name: "app-login",
    data() {
        return {
            email: '',
            password: ''
        }
    },
    methods: {
        login(event) {

            let data = {
                'email': this.email,
                'password': this.password
            }

            axios.post(this.urlBaseApi + '/api/login/', data).then(
                (response) => {
                    if (response.data.token) {
                        document.cookie = 'token=' + response.data.token + ';SameSite=Lax';
                        event.target.submit();
                    }
                }
            );
        }
    }
}
</script>

<style scoped>


</style>
