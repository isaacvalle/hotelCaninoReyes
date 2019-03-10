<template>
    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Perritos registrados </h1>
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
                    <th>Raza</th>
                    <th>Genero</th>
                    <th>Registered At</th>
                    <th>Modify</th>
                </tr>


                <tr v-for="dog in dogs.data" :key="dog.id">

                    <td>{{dog.id}}</td>
                    <td>{{dog.name}}</td>
                    <td>{{dog.breed.name}}</td>
                    <td v-if="dog.gender == 1">Macho</td>
                    <td v-else>Hembra</td>
                    <td>{{dog.created_at}}</td>

                    <td>
                        <a href="#" @click="editModal(dog)">
                            <Edit></Edit>
                        </a>
                        /
                        <a href="#" @click="deleteUser(dog.id)">
                            <Trash2></Trash2>
                        </a>

                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Registrar nuevo perrito</h5>
                        <h5 class="modal-title" v-show="editmode" id="addNewLabel">Actualizar información del perrito</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateUser() : createUser()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.name" type="text" name="name"
                                       placeholder="Nombre para el perrito"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>

                            <div class="form-group">
                                <select name="type" v-model="form.breed_id" id="breed_id" class="form-control" :class="{ 'is-invalid': form.errors.has('breed_id') }">
                                    <option value="">Selecciona la raza del perrito</option>
                                    <option v-for="breed in breeds" :value="breed.id">{{breed.name}}</option>
                                </select>
                                <has-error :form="form" field="breed_id"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.gender" type="radio" name="gender"
                                       value="0">Hembra
                                <has-error :form="form" field="gender"></has-error>
                                <input v-model="form.gender" type="radio" name="gender"
                                       value="1">Macho
                                <has-error :form="form" field="gender"></has-error>
                            </div>

                            <div class="form-group">
                                <datepicker input-class="input-group form-control" placeholder="Fecha de nacimiento" v-model="form.dob" format="yyyy-MM-dd"></datepicker>
                            </div>

                            <div class="form-group">
                                <select name="type" v-model="form.color_id" id="color_id" class="form-control" :class="{ 'is-invalid': form.errors.has('color_id') }">
                                    <option value="">Color del perrito</option>
                                    <option v-for="color in colors" :value="color.id">{{color.color}}</option>
                                </select>
                                <has-error :form="form" field="color_id"></has-error>
                            </div>

                            <div class="form-group">
                                <input type="checkbox" v-model="spots" v-on:click="!spots">
                                ¿Tiene manchas?
                            </div>

                            <div class="form-group" v-if="spots">
                                <select name="type" v-model="form.spots_color_id" id="spots_color_id" class="form-control" :class="{ 'is-invalid': form.errors.has('color_id') }">
                                    <option value="">Color de las manchas</option>
                                    <option v-for="color in colors" :value="color.id">{{color.color}}</option>
                                </select>
                                <has-error :form="form" field="spots_color_id"></has-error>
                            </div>

                            <div class="form-group">
                                <select name="type" v-model="form.size_id" id="size_id" class="form-control" :class="{ 'is-invalid': form.errors.has('size_id') }">
                                    <option value="">Tamaño</option>
                                    <option v-for="size in sizes" :value="size.id">{{size.name}}</option>
                                </select>
                                <has-error :form="form" field="size_id"></has-error>
                            </div>

                            <div class="form-group">
                                <textarea v-model="form.bio" name="bio" id="bio"
                                  placeholder="Short bio for user (Optional)"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                                <has-error :form="form" field="bio"></has-error>
                            </div>


                            <div class="form-group">
                                <select name="type" v-model="form.type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                    <option value="">Select User Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">Standard User</option>
                                    <option value="author">Author</option>
                                </select>
                                <has-error :form="form" field="type"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.password" type="password" name="password" id="password"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                            <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import {Edit, Trash2} from 'vue-feather-icon';
    import Datepicker from 'vuejs-datepicker';
    export default {
        data() {
            return {
                editmode: false,
                spots: false,
                breeds: {},
                colors: {},
                dogs: {},
                form: new Form({
                    id: '',
                    name: '',
                    breed_id: '',
                    gender: '',
                    picture: '',
                    dob: '',
                    color_id: '',
                    spots_color_id: '',
                    size_id: '',
                    weight: '',
                    sterialized: '',
                    last_zeal: '',
                    special_care: '',
                    desc_special_care: '',
                    lunch_time: '',
                    friendly: '',
                    observations: '',
                    user_id: ''
                })
            }
        },
        methods: {
            getDogs() {
                axios.get("api/dogs", {
                    headers: {
                        "Authorization" : "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjRiY2QyYzcyMmNkZWJjZTg4ZDkzNjEyNDBkMDAyOWFlMzQ4NjU1MDU3NmQzMDNkN2QwZDkzOGVlNjhhZGEwNGJjMzI0OWM0NzYzY2ZhMTg2In0.eyJhdWQiOiI0IiwianRpIjoiNGJjZDJjNzIyY2RlYmNlODhkOTM2MTI0MGQwMDI5YWUzNDg2NTUwNTc2ZDMwM2Q3ZDBkOTM4ZWU2OGFkYTA0YmMzMjQ5YzQ3NjNjZmExODYiLCJpYXQiOjE1NTIxOTI2NzEsIm5iZiI6MTU1MjE5MjY3MSwiZXhwIjoxNTUyMTk4NjY5LCJzdWIiOiIyMyIsInNjb3BlcyI6W119.e41pZZVpQu-AFn1xlE4_HwqbxbWb5I2g-nALkP9zlQ1pHI_uG4M2-_S1q64SP2bLjUzYknQbwdcLef1WyLYLu4ZHxOi783zzNnf9bK8lkBOWDMgXH6dh_w3pxClls25UT04wlmFciQv_TQsSvUW9SoXA5k_mt0D1MT2B4bFn_ypU62PRyphTgq0msQeu6rhUWMdMRQlyTttUReKl_EjAYRdLDBHFfSthdNzURkHxQ02TVs2jSNkFaBu7Fk7opqwbX3GiVQbIaHbpwnRGJRBB6tNwLp6GWmAsT6LDVOSieVfX8QGYCCA96Tmd_VUfT_LAT2rVSpcFRj3zQaReR2k1-R4ISQcIjR2FZRzpLVSsnJ_bFIdrnw_HvcUUuVxkCw93wHTpZ06mGYXBqLMIKNRWEJ2_bngAd11b9vUHjJAvEl33xT91aBo5iVXIvROxezsRVzGeUe3VfG6QasQ3SjtiA-2VTCOryaVj8nwhzos7D2RvPJYBLSpTiqRorpFCznActPgfNF1IayjdSGlHzAM7TBKJiCYZEUmg42QMzwQ9SMNcm2uI-XLqYF3jPabQ1lb_0GkgfBuPz0s9WdjhyZH2f1I3cM1c5LvbpNtLQM28FwwSxiyqf-cu-f07jbB9rJTzH1euDjtBhU7HiDSsdK7dZHmPZ14YknJazA_YYZEdUfg"
                    }
                }).then(
                    ({data}) => (this.dogs = data)
                );
            },
            createUser(){
                this.form.post('api/user')
                    .then(()=>{
                        $('#addNew').modal('hide')
                        toast({
                            type: 'success',
                            title: 'User Created in successfully'
                        })
                    })
                    .catch(()=>{
                    })
            },
            updateUser(){
                // console.log('Editing data');
                this.form.put('api/dogs/'+this.form.id)
                    .then(() => {
                        // success
                        $('#addNew').modal('hide');
                        swal(
                            'Updated!',
                            'Information has been updated.',
                            'success'
                        )
                    })
                    .catch(() => {
                        alert('Error')
                    });
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            editModal(dog){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(dog);
            },
            deleteUser(id){
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    // Send request to the server
                    if (result.value) {
                        axios.delete('api/dogs/'+id, {
                            headers: {
                                "Authorization" : "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImZkMTYxZTI3NTMyNjE3ZTNhMjVjZWJlMWRjNmI3ODc3YmNmNzY2OWUyYzdjOWQzOGQyM2M5NWZmYTk1YTM2YTM0ODkxNzQ2MGU0ZWMwZDBmIn0.eyJhdWQiOiI0IiwianRpIjoiZmQxNjFlMjc1MzI2MTdlM2EyNWNlYmUxZGM2Yjc4NzdiY2Y3NjY5ZTJjN2M5ZDM4ZDIzYzk1ZmZhOTVhMzZhMzQ4OTE3NDYwZTRlYzBkMGYiLCJpYXQiOjE1NTIxODQ1OTMsIm5iZiI6MTU1MjE4NDU5MywiZXhwIjoxNTUyMTkwNTkxLCJzdWIiOiIyMyIsInNjb3BlcyI6W119.jnQxyFwGk8Okmu8XNw91aCbRZPMZV9xUgl8y7-9utdMH9-iXB_MJ3J3jbjxQGLIdU5ChsVY9ioT1d7ZK_rjg1WA2CHjg2DSSRFatkt9wFE7-zf5XFzxYzKeba9DFBQJAWeMg95AXyKppI3cn4q2qYo7txQfJU8q38qIhKti-oltopYkS8N3QhPJ1mJVKYxNiNfQzd78cVar2dwEGG1QScHAiAlnq650IENGIx4ajln79EWfXLuF1GgKVB2AZwdvH_x5Fsz0cOA85ZQiFXAKNEcOcC8am3dVS2p-_Y9uYzb-1gB1viO7kEvb8fBOQYPAO2FycKdxUD23HQydFLaOsb0M3r8ll0phHDwcnAE8TtZi8A9AR9vBJ04LVq0XmiB1bMLHlkFqd99OxzLgvH7ERMO4vRx4-vU9F8M5QOuHqCcVqHNIFEXhHzD-Aery_5p6qsJrtl1XuPAvQLrPj7-ilR0uHe8KCwF7VSrUDexNqFx3V8A1ZaZwlAPgGeVcz-rYoJqemQgIR1AHpT8d0SlAU8kU2oyHVidHKy-mGsl-kRAMqnxXIbdnIk7G6r66wiIMoAlDkqja2DN7Kfpjkp2dXJbashw0GJ8WKoOTazJabaIR99kquOskaMkYVX13GZlsEKSgY-CPD2Va0orpkkXOiIVs0q6I6U7Ocl7aqyePOQv8"
                            }
                        }).then(()=>{
                            swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            this.form.reset()
                        }).catch(()=> {
                            swal.fire("Failed!", "There was something wronge.", "warning");
                        });
                    }
                })
            },
            getBreeds(){
                axios.get("api/breeds").then(
                    ({data}) => (this.breeds = data)
                );
            },
            getColors(){
                axios.get("api/colors").then(
                    ({data}) => (this.colors = data)
                );
            },
            getSizes(){
                axios.get("api/sizes").then(
                    ({data}) => (this.sizes = data)
                );
            }
        },
        created() {
            this.getDogs();
            this.getBreeds();
            this.getColors();
            this.getSizes();
        },
        components: {
            Datepicker, Edit, Trash2
        }
    }
</script>

<style scoped>

</style>