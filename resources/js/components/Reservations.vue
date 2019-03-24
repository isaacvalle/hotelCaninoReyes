<template>
    <div>
        <Dashboard></Dashboard>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Reservaciones</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <button class="btn btn-sm btn-outline-secondary">Crear</button>
                        <button class="btn btn-sm btn-outline-secondary">Exportar</button>
                    </div>
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
                        <Calendar width="19" height="19" stroke-width="1.5" stroke="gray"></Calendar>
                        Hoy
                    </button>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div id="rooms" class="col-md-6">
                        <a href="#"><Home width="52" height="52" stroke="gray" stroke-width="1" fill="green"></Home></a>
                        <a href="#"><Home width="52" height="52" stroke="gray" stroke-width="0.5" fill="none"></Home></a>
                    </div>
                    <div id="services" class="col-md-6">

                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
    import { Calendar, Home } from 'vue-feather-icon';

    export default {
        data() {
            return {
                users: {}
            }
        },
        methods: {
            getUsers() {
                axios.get("api/user", {
                    headers: {
                        "Authorization" : "Bearer " + localStorage.token
                    }
                }).then(
                    ({data}) => (this.users = data)
                );
            }
        },
        created() {
            this.getUsers();
        },
        components: {
            Calendar, Home
        }
    }
</script>

<style scoped>
    #rooms {
        //border: solid 4px red;

        height: auto;
    }

    #services {
        //border: solid 4px green;
        height: auto;
    }
</style>