<template>
    <div>
        <Dashboard></Dashboard>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <div class="container">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2">Usuarios registrados </h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <button class="btn btn-sm btn-outline-secondary" @click="newModal">Registrar</button>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Registrado</th>
                                <th>Acciones</th>
                            </tr>


                            <tr v-for="user in users.data" :key="user.id">

                                <td>{{user.id}}</td>
                                <td>{{user.name}} {{user.last_name}}</td>
                                <td>{{user.email}}</td>
                                <td>{{user.created_at}}</td>

                                <td>
                                    <a href="#" @click="view(user.id)">
                                        <Eye></Eye>
                                    </a>
                                    /
                                    <a href="#" @click="editModal(user)">
                                        <Edit></Edit>
                                    </a>
                                    /
                                    <a href="#" @click="deleteUser(user.id)">
                                        <Trash2></Trash2>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
    import { Edit, Trash2, Eye } from 'vue-feather-icon';
    export default {
        data() {
            return {
                users: {}
            }
        },
        methods: {
            getUsers() {
                axios.get('api/users', {
                    headers: {
                        "Authorization" : "Bearer " + localStorage.token
                    }
                }).then(
                    ({data}) => (this.users = data)
                );
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            }
        },
        created() {
            this.getUsers();
        },
        components: {
            Edit, Trash2, Eye
        }
    }
</script>

<style scoped>

</style>