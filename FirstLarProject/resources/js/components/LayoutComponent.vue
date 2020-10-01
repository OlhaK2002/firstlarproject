<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container text">
                <a class="navbar-brand text" href="/">
                    Laravel
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <div v-if="bool">
                               <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    User <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item text" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="/logout" method="POST" style="display: none;">
                                        <input type="hidden" name="_token" :value="csrf">
                                    </form>
                                </div>
                            </li>
                        </div>
                        <div v-else>
                            <li class="nav-item ">
                                <a class="nav-link text" href="/login">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text" href="/register">Register</a>
                            </li>

                        </div>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</template>
<script>
export default {
    props: ['bool'],
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            bool: this.bool,
        }
    }
}
</script>
