<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        <div v-if="bool" class="alert alert-success" role="alert">
                            {{ bool }}
                        </div>
                        <span v-else>
                        You are logged in!
                        </span>
                    </div>
                </div>
            </div>
        </div>
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
