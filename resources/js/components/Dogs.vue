<template>
    <div>
        <Dashboard></Dashboard>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
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
                            <th>Registrado</th>
                            <th>Acciones</th>
                        </tr>


                        <tr v-for="dog in dogs.data" :key="dog.id">

                            <td>{{dog.id}}</td>
                            <td>{{dog.name}}</td>
                            <td>{{dog.breed.name}}</td>
                            <td v-if="dog.gender == 1">Macho</td>
                            <td v-else>Hembra</td>
                            <td>{{dog.created_at}}</td>

                            <td>
                                <a href="#" @click="viewModal(dog.id)">
                                    <Eye></Eye>
                                </a>
                                /
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

                <div class="modal fade" id="details" tabindex="-1" role="dialog" aria-labelledby="detailsLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailsLabel">Detalles de perrito</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <label for="idLabel">ID: </label> {{dogDetails.id}} <br />
                                <label for="nameLabel">Nombre: </label> {{dogDetails.name}} <br />
                                <!--<label for="breedLabel">Raza: </label> {{dogDetails.breed.name}} -->
                                <label for="genderLabel">Genero: </label> <span v-if="dogDetails.gender == 1">Macho</span> <span v-else>Hembra</span> <br />
                                <label for="dobLabel">Fecha de nacimiento: </label> {{dogDetails.dob}} <br />
                                <!--<label for="colorLabel">Color: </label> {{dogDetails.color.color}} -->
                                <!--<label for="spotsLabel" v-if="dogDetails.spots_color_id != 0">Manchas: </label> {{dogDetails.spots.color}}-->
                               <label for="serializedLabel" v-if="dogDetails.sterialized != 0">Esterilizado</label> <br />

                           </div>
                       </div>
                   </div>
               </div>

               <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                   <div class="modal-dialog modal-dialog-centered" role="document">
                       <div class="modal-content">
                           <div class="modal-header">
                               <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Registro de nuevo perrito</h5>
                               <h5 class="modal-title" v-show="editmode" id="addNewLabel">Actualizar información del perrito</h5>
                               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                   <span aria-hidden="true">&times;</span>
                               </button>
                           </div>
                           <form id="form" @submit.prevent="editmode ? updateDog() : createDog()">
                               <div class="modal-body">
                                   <div class="form-group">
                                       <input v-model.trim="form.name" type="text" name="name"
                                              placeholder="Nombre para el perrito"
                                              class="form-control" required>
                                   </div>

                                   <div class="form-group">
                                       <select name="type" v-model="form.breed_id" id="breed_id" class="form-control" required>
                                           <option value="">Selecciona la raza del perrito</option>
                                           <option v-for="breed in breeds" :value="breed.id">{{breed.name}}</option>
                                       </select>
                                   </div>

                                   <div class="form-group">
                                       <input v-model="form.gender" type="radio" name="gender"
                                              value="0" v-on:change="gender_selection = true" required> Hembra
                                       <input v-model="form.gender" type="radio" name="gender"
                                              value="1" v-on:change="gender_selection = false"> Macho
                                   </div>

                                   <div class="form-group">
                                       <datepicker input-class="input-group form-control" placeholder="Fecha de nacimiento" v-model="form.dob" v-on:submit="customFormatter"></datepicker>
                                   </div>

                                   <div class="form-group">
                                       <select name="type" v-model="form.color_id" id="color_id" class="form-control">
                                           <option value="">Color del perrito</option>
                                           <option v-for="color in colors" :value="color.id">{{color.color}}</option>
                                       </select>
                                   </div>

                                   <div class="form-group">
                                       <input type="checkbox" v-model="spots" v-on:click="!spots">
                                       ¿Tiene manchas?
                                   </div>

                                   <div class="form-group" v-if="spots">
                                       <select name="type" v-model="form.spots_color_id" id="spots_color_id" class="form-control">
                                           <option value="">Color de las manchas</option>
                                           <option v-for="color in colors" :value="color.id">{{color.color}}</option>
                                       </select>
                                   </div>

                                   <div class="form-group">
                                       <select name="type" v-model="form.size_id" id="size_id" class="form-control" required>
                                           <option value="">Tamaño</option>
                                           <option v-for="size in sizes" :value="size.id">{{size.name}}</option>
                                       </select>
                                   </div>

                                   <div class="form-group">
                                       <input v-model.number="form.weight" type="number" name="weight"
                                              placeholder="¿Cuánto pesa? (Kg)"
                                              class="form-control">
                                   </div>

                                   <div class="form-group">
                                       <input type="checkbox" v-model="form.sterialized">
                                       ¿Esterilizado?
                                   </div>

                                   <div class="form-group" v-if="gender_selection">
                                       <datepicker input-class="input-group form-control" placeholder="¿Cuándo fue su último celo?" v-model="form.last_zeal" format="yyyy-MM-dd"></datepicker>
                                   </div>

                                   <div class="form-group">
                                       <input type="checkbox" v-model="form.special_care" v-on:click="!form.special_care">
                                       ¿Requiere algún cuidado especial?
                                   </div>

                                   <div class="form-group" v-if="form.special_care">
                                       <textarea v-model.trim="form.desc_special_care" name="desc_special_care" id="desc_special_care"
                                                 placeholder="Descripción del cuidado especial"
                                                 class="form-control"></textarea>
                                   </div>

                                   <div class="form-group">
                                       <vue-clock-picker v-model="form.lunch_time" placeholder="Seleccione la hora en la que come" input-class="form-control" required done-text="Listo" cancel-text="Cancelar"></vue-clock-picker>
                                   </div>

                                   <div class="form-group">
                                       <input type="checkbox" v-model="form.friendly" v-on:change="!form.friendly" required>
                                       ¿Puede convivir con otros perritos?
                                   </div>

                                   <div class="form-group">
                                       <textarea v-model.trim="form.observations" name="observations" id="observations"
                                                 placeholder="Observaciones"
                                                 class="form-control"></textarea>
                                   </div>
                                   <div class="form-group">
                                       <select name="type" v-model="form.user_id" id="user_id" class="form-control" required>
                                           <option value="">¿A qué usuario pertenece?</option>
                                           <option v-for="user in users.data" :value="user.id">{{user.id}} - {{user.name}}</option>
                                       </select>
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
       </main>
   </div>
</template>

<script>
   import { Edit, Trash2, Eye} from 'vue-feather-icon';
   import Datepicker from 'vuejs-datepicker';
   import Dashboard from "./Dashboard";
   import VueClockPicker from '@pencilpix/vue2-clock-picker';
   import '@pencilpix/vue2-clock-picker/dist/vue2-clock-picker.min.css';
   export default {
       data() {
           return {
               editmode: false,
               spots: false,
               breeds: {},
               colors: {},
               sizes: {},
               dogDetails: {},
               dogs: {},
               users: {},
               gender_selection: false,
               form: new Form({
                   id: null,
                   name: '',
                   breed_id: '',
                   gender: '',
                   picture: 'https://lorempixel.com/400/400/cats/97285.jpg',
                   dob: '',
                   color_id: '',
                   spots_color_id: '',
                   size_id: '',
                   weight: '',
                   sterialized: '0',
                   last_zeal: '',
                   special_care: '0',
                   desc_special_care: '',
                   lunch_time: '',
                   friendly: true,
                   observations: '',
                   user_id: ''
               })
           }
       },
       methods: {
           moment: function(date) {
               return moment(date, ["YYYY-MM-DD", moment.HTML5_FMT.DATETIME_LOCAL_MS]);
           },
           customFormatter(date) {
               this.form.dob = moment(date, ["YYYY-MM-DD", moment.HTML5_FMT.DATETIME_LOCAL_MS]).format('YYYY-MM-DD');
               console.log('DateC: ' + this.form.dob);
           },
           getDogs() {
               axios.get('api/dogs', {
                   headers: {
                       "Authorization" : "Bearer " + localStorage.token
                   }
               }).then(
                   ({data}) => (this.dogs = data)
               ).catch(
                   () => this.loginFailed()
               );
           },
           viewModal(id) {
               this.form.reset();
               $('#details').modal('show');
               axios.get('api/dogs/'+id, {
                   headers: {
                       "Authorization" : "Bearer " + localStorage.token
                   }
               }).then(
                   ({data}) => (this.dogDetails = data.data)
               ).catch(
                   () => this.loginFailed()
               );
           },
           loginFailed(){
             delete localStorage.token
             this.$router.replace(this.$route.query.redirect || '/login')
           },
           createDog(){
               this.$http.post('api/dogs', this.form, {
                   headers: {
                       'Authorization': 'Bearer ' + localStorage.token
                   }
               }).then(()=>{
                   $('#addNew').modal('hide')
                   this.getDogs()
                   swal.fire({
                       type: 'success',
                       title: 'Dog created successfully'
                   })
                   this.form.reset()
               }).catch(()=>{
                   $('#addNew').modal('hide')
                   swal.fire({
                       type: 'error',
                       title: 'Algo fue mal al crear el perrito.'
                   })
               })
           },
           updateDog(){
               // console.log('Editing data');
               this.$http.put('api/dogs/'+this.form.id, this.form, {
                   headers: {
                       'Authorization': 'Bearer ' + localStorage.token
                   }
               }).then(() => {
                   // success
                   $('#addNew').modal('hide');
                   swal.fire(
                       'Updated!',
                       'Dog information has been updated.',
                       'success'
                   )
                   this.getDogs()
                   this.form.reset()
               }).catch(() => {
                   swal.fire({
                       type: 'error',
                       title: 'Algo fue mal al actualizar los datos del perrito.'
                   })
               });
           },
           newModal(){
               this.editmode = false;
               //$('#form').trigger("reset");
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
                   title: '¿Estas seguro de eliminar este perrito?',
                   text: "No será posible revertir esto!",
                   type: 'warning',
                   showCancelButton: true,
                   confirmButtonColor: '#3085d6',
                   cancelButtonColor: '#d33',
                   confirmButtonText: 'Si, borrarlo!'
               }).then((result) => {
                   // Send request to the server
                   if (result.value) {
                       axios.delete('api/dogs/'+id, {
                           headers: {
                               "Authorization" : "Bearer " + localStorage.token
                           }
                       }).then(()=>{
                           this.getDogs()
                           swal.fire(
                               'Perrito borrado!',
                               'Este can ha sido eliminado de la base de datos.',
                               'success'
                           )
                       }).catch(()=> {
                           swal.fire("Error!", "Algo ocurrio mal al intentar elimnar el perrito.", "warning");
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
           },
           getUsers(){
               axios.get('api/users', {
                   headers: {
                       "Authorization" : "Bearer " + localStorage.token
                   }
               }).then(
                   ({data}) => (this.users = data)
               ).catch(
                   () => this.loginFailed()
               );
           }
       },
       created() {
           this.getDogs();
           this.getBreeds();
           this.getColors();
           this.getSizes();
           this.getUsers();
       },
       components: {
           Dashboard, VueClockPicker, Datepicker, Edit, Trash2, Eye
       }
   }
</script>

<style scoped>

</style>