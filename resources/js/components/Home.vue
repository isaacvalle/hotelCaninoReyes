<template>
    <div class="flex-center position-ref full-height">
        <div class="top-right links">
            <router-link :to="{ name: 'login' }">Login</router-link>
        </div>

        <div class="content">
            <div class="title m-b-md">
                Hotel Canino Reyes
            </div>
            <strong>Sitio constantemente monitoriado.</strong>
            <p>
                Éste portal es de uso exclusivo para la administración del Hotel Canino Reyes,
                si no pertenece a esta organización, favor de abandonar el sitio.
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Home",
        mounted() {
            console.log('Home mounted.')
        }
    }
</script>

<style scoped>
    html, body {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Nunito', sans-serif;
        font-weight: 200;
        height: 100vh;
        margin: 0;
    }

    .full-height {
        height: 100vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }

    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
    }

    .content {
        text-align: center;
    }

    .title {
        font-size: 84px;
    }

    .links > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }

    .m-b-md {
        margin-bottom: 30px;
    }
</style>