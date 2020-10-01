<template>
    <div>
        <form v-if="bool">
            <input type="hidden" name="_token" :value="csrf">
            <textarea rows="3" required name="text" id="text_id0" class="form-control nesting" placeholder="Введите Ваш комментарий..."></textarea>
            <input type="hidden" id="parent_id0" class="parent" name="parent_id" value="0">
            <input type="hidden" id="nesting0" class="nesting" name="nesting" value="0">
            <button id="0" type="submit" class="button1 btn btn-light">Отправить</button>
        </form>
    </div>
</template>

<script>
export default {
    name: "TitleComponent",
    props: ['bool'],
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            bool: this.bool
        }
    }
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
.nesting {
    display: inline-block;
}
</style>
