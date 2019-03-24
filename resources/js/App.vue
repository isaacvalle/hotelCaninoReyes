<template>
    <div class="panel panel-default">
        <div class="panel-body">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        name: "App",
        mounted() {
            console.log('App mounted.')
        }
    }
</script>

<style scoped>

</style>