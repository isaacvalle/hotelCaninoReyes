<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel navbar-static-top">

            <a class="navbar-brand sticky-top flex-md-nowrap" href="#">
                Hotel Canino Reyes
            </a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                </ul>
            </div>
        </nav>
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Login</div>
                            <div class="card-body">
                                <div class="alert alert-danger" v-if="error">
                                    <p>There was an error, unable to sign in with those credentials.</p>
                                </div>
                                <form autocomplete="off" @submit.prevent="login" method="post">
                                    <div class="form-group row">
                                        <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>
                                        <div class="col-md-6">
                                            <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                        <div class="col-md-6">
                                            <input type="password" id="password" class="form-control" v-model="password" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                Login
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
    export default {
        name: "Login",
        data() {
            return {
                email: null,
                password: null,
                error: false
            }
        },
        methods: {
            login() {
                this.$http.post('oauth/token',{ username: this.email, password: this.password, grant_type: 'password', client_id: '2', client_secret: 'Ffdrmj4lZvq5loGERKyhmrDMdKwFnuRushKSU1d8' })
                    .then(response => this.loginSuccessful(response))
                    .catch(() => this.loginFailed())
            },

            loginSuccessful(response) {
                if (!response.data.access_token) {
                    this.loginFailed()
                    return
                }

                localStorage.token = response.data.access_token
                localStorage.refresh_token = response.data.refresh_token
                this.error = false

                this.$router.replace(this.$route.query.redirect || '/dashboard')
            },

            loginFailed() {
                this.error = 'Login failed!'
                delete localStorage.token
            }
        },
        mounted() {
            console.log("Mounted login...");
        }
    }
</script>

<style scoped>

</style>
