<template>
    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users Table</h3>

                        <!-- <div class="card-tools">
                            <button class="btn btn-success" @click="">Add New <span data-feather="user-plus"></span></button>
                        </div> -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Registered At</th>
                                <th>Modify</th>
                            </tr>

                            <tr v-for="user in users.data" :key="user.id">

                                <td>{{user.id}}</td>
                                <td>{{user.name}}</td>
                                <td>{{user.email}}</td>
                                <td>{{user.created_at}}</td>

                                <td>
                                    <a href="#" @click="editModal(user)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteUser(user.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>

                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                users: {}
            }
        },
        methods: {
            getUsers() {
                axios.get("api/users", {
                    headers: {
                        "Authorization" : "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImJlOGE5MDQzMmU0YmY4ODM4NGVkOTIwZGU0OTRlYzYwZjMzNTJiZmY2MGQxYTAxYWMzMDEyYjAxZmExNTY4MTJlNjJmNmQ1NTY0OTNhOWVhIn0.eyJhdWQiOiI0IiwianRpIjoiYmU4YTkwNDMyZTRiZjg4Mzg0ZWQ5MjBkZTQ5NGVjNjBmMzM1MmJmZjYwZDFhMDFhYzMwMTJiMDFmYTE1NjgxMmU2MmY2ZDU1NjQ5M2E5ZWEiLCJpYXQiOjE1NTIxNjAzMzksIm5iZiI6MTU1MjE2MDMzOSwiZXhwIjoxNTUyMTY2MzM3LCJzdWIiOiIyMyIsInNjb3BlcyI6W119.fDGyWy7Aa8BXzgLi2q1_GPEaXY0WLh276vUf79Niez8wZZhqo22S85--9nMjxlagVTCHRtjwxb-e9-ltM15mOBV3HUJTS5QRos5B_rVAy9EkChWpBgwDj0LqVJzWU3aM3deDcRMM6ALi8vbE78Hyce3NK1Qz-K4FcpBNuDMez9olBJk9zNUmSwFW3mpcx53o8TWdW_shJn8jqSybwD5dWb3SC5WZD1qpZW2iI6aJQscnJgo9PfVgmT6EWljyx9eSHj7jLnsbXv4OJqMg7RKn4PSMzqhhzbxeHIPFGFrQ6Pgi6FxUPg8q7LJsldVr46dopWTLVdPG4P6YIC-sPIEFKO9yWXJOigfFx-bM32rIqmonyV5morOFbehxl0qcdE_cD6iZuuHkh1WkntsG2A0GBnE0wB4d0CtNXnfgc5DGNVXwUHsFWHz8YH9TSd3x8rKiuAl0yALw-1ecIK7uX3C48zhi0QcTD_g3LpcLa4L8treTUvGPt7XbUSqhIz9jZTrE5yGrIQKFkxP88gigGei1nAiWCI0dMJfbrqeK4d_4RRhXKeI5RDhj7WBx3o7SuUba8t6t4VU0D0pIFFAz1bELJSjxUI7q0g2JZX38PH6O2JDTxExZ5b_1kyb69GbLedkGcUYJ5GEVZRz1FskDDjOs4icFlxiE50O49l3h7FykOKw"
                    }
                }).then(
                    ({data}) => (this.users = data)
                );
            }
        },
        created() {
            this.getUsers();
        }
    }
</script>

<style scoped>

</style>