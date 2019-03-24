<template>
    <div>
        <Dashboard></Dashboard>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Here services</div>

                            <div class="card-body">
                                User logged in: {{ users.id }}
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
        data() {
            return {
                users: {}
            }
        },
        methods: {
            getUsers() {
                axios.get("api/user", {
                    headers: {
                        "Authorization" : "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImQzNjA2MzAzODRmMjY1N2NjMzAxMjQzMWUyZGIxZDBkNDFjNThmMDk4Mjk2YmU3M2QzOTlkYzQwOGU1NmQ2MjZlMDVlMWY2YzkzYWUyMDgyIn0.eyJhdWQiOiI0IiwianRpIjoiZDM2MDYzMDM4NGYyNjU3Y2MzMDEyNDMxZTJkYjFkMGQ0MWM1OGYwOTgyOTZiZTczZDM5OWRjNDA4ZTU2ZDYyNmUwNWUxZjZjOTNhZTIwODIiLCJpYXQiOjE1NTIwODkzNDcsIm5iZiI6MTU1MjA4OTM0NywiZXhwIjoxNTUyMDk1MzQzLCJzdWIiOiIyNyIsInNjb3BlcyI6W119.aX7dJ_uTTJvVTprlJEjm3tHsG9RAHVem-HoVhVLZIGM7xLq61MFZj_DJnJ9eL1I0Y_bBw7ivySP_n8Idx-nXMju1aFdQ95-gzX-Of9BbiOM6IsfvtvERA0IsQeyLBJEMGvHs4Rq7k5A2dOAe7yYR6_orldgpdX0tQdo_Qj8SCvKj5PJx6UAOE2qy48F9TC7RXqsJWp07lzttvReY0jmTxn3sotu1sRbDO9Wu6hGmCZjpqDw4hkvyx9O5znxJik_cjjGvN5AY8-I6f4XyDX6mFDotacaAMdLys2vtCSKyPjcVbym-DbylaAPL0IzbA4Guu3JpMH73NuY098wvJTX5r-X0lkHadPtzkR_2hyRzDNEYarvzXcOd828YB1oFEiOQUaqrUZHEkRgRjv7jLuaod6Gw5NrwfjWnPN7euRYYer4hhWEHSdRG3uTYZ8yTawkt7rJZHDJP_yVCXclAn8Zc4pspB6Ote1uajVEck1ykanMZ7yp5AULRtHfeAMbadi17F4E9Swoz6cRox7jZP8fvXDMwgyyF_tIobJTDEXQ8hvAjDO57v662WkPzo6XcAIdULEVi1fpN4pT4aaIV1m1OdVHA_K5FqnYV54YT4CydvxmTxT65_hCt8B_1ddzulzZ3qfnmhJsiKJdZ3Hz0RPrjPLuzEuHpZs0zdafZhh8m5vA"
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