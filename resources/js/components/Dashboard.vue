<template>
    <div>
        <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom navbar-fixed-top" role="navigation">

            <a class="navbar-brand sticky-top flex-md-nowrap" href="#">
                Hotel Canino Reyes
            </a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Cuenta <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/logout"
                               onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <router-link to="/reservations" class="nav-link active">
                            <File stroke="gray" stroke-width="1.5"></File>
                            Reservaciones <span class="sr-only">(current)</span>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/services" class="nav-link">
                            <ShoppingCart stroke="gray" stroke-width="1.5"></ShoppingCart>
                            Servicios
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <Home stroke="gray" stroke-width="1.5"></Home>
                            Habitaciones
                        </a>
                    </li>
                    <li class="nav-item">
                        <router-link to="/users" class="nav-link">
                            <Users stroke="gray" stroke-width="1.5"></Users>
                            Clientes
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/dogs" class="nav-link">
                            <Gitlab stroke="gray" stroke-width="1.5"></Gitlab>
                            Perritos
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <List stroke="gray" stroke-width="1.5"></List>
                            Inventario
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <Box stroke="gray" stroke-width="1.5"></Box>
                            Caja
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <BarChart2 stroke="gray" stroke-width="1.5"></BarChart2>
                            Reportes
                        </a>
                    </li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Saved reports</span>
                    <a class="d-flex align-items-center text-muted" href="#">
                        <PlusCircle stroke="gray" stroke-width="1.5"></PlusCircle>
                    </a>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <FileText stroke="gray" stroke-width="1.5"></FileText>
                            Current month
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <FileText stroke="gray" stroke-width="1.5"></FileText>
                            Last quarter
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <FileText stroke="gray" stroke-width="1.5"></FileText>
                            Social engagement
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <FileText stroke="gray" stroke-width="1.5"></FileText>
                            Year-end sale
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>

<script>
    import {File, ShoppingCart, Home, Users, Gitlab, List, Box, BarChart2, PlusCircle, FileText} from 'vue-feather-icon';
    export default {
        name: "Dashboard",

        components: {
            File, ShoppingCart, Home, Users, Gitlab, List, Box, BarChart2, PlusCircle, FileText
        }
    }
</script>

<style scoped>

</style>