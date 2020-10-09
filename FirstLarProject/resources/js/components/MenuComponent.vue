<template>
    <div>
        <nav class = "navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <a class = "navbar-brand nav-item top-left" href = "/">Laravel</a>
            <button class = "navbar-toggler" type = "button" data-toggle = "collapse" data-target = "#navbarSupportedContent" aria-controls = "navbarSupportedContent" aria-expanded = "false">
                <span class = "navbar-toggler-icon"></span>
            </button>
            <div class = "collapse navbar-collapse top-right" id = "navbarSupportedContent">
                <ul class = "navbar-nav ml-auto">
                    <div v-if = "bool">
                        <li class = "nav-item dropdown">
                            {{user['name']}}
                            <a id = "navbarDropdown" class = "dropdown-toggle" style = "color: #35848F" href = "#" role = "button" data-toggle = "dropdown" aria-haspopup = "true" aria-expanded = "false" v-pre></a>
                            <div class = "dropdown-menu dropdown-menu-right" aria-labelledby = "navbarDropdown">
                                <a class = "dropdown-item nav-item" href = "/logout" onclick = "event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                <form id = "logout-form" action = "/logout" method="POST" style="display: none;">
                                    <input type = "hidden" name = "_token" :value = "csrf">
                                </form>
                            </div>
                        </li>
                    </div>
                    <div  v-else>
                        <li class = "nav-item ">
                            <a  href = "/login">Login</a>
                        </li>
                        <li class = "nav-item">
                            <a  href = "/register">Register</a>
                        </li>

                    </div>

                </ul>
            </div>

        </nav>
    </div>
</template>
<script>
export default {
    props: ['bool', 'users'],
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            user: this.users || [],
        }
    }
}
</script>

<style>
    .links > a {
        color: #35848F;
        padding: 0 25px;
        font-size: 20px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }
    .nav-item {
        display: inline-block;
        font-size: 20px;
    }
    .top-left {
        margin-left: 40px;
    }
    .top-right {
        margin-right: 40px;
    }
</style>
