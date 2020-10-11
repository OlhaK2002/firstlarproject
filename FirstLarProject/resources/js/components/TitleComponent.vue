<template>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <hr>
            <div class="title m-b-md">
                Guest Book
            </div>
            <hr>
        </div>
    </div>
</template>

<script>
    export default {
        name: "TitleComponent"
    }
</script>

<style scoped>
html, body {
    background-color:#CFEDF1;
    color: #35848F;
    font-family: 'Nunito', sans-serif;
    font-weight: 200;
    height: 100vh;
    margin: 0;
}

.full-height {
    height: 40vh;
}

.flex-center {
    margin: 0 0 0 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.position-ref {
    position: relative;
}

.title {
   font-size: 10vw;
}


</style>
