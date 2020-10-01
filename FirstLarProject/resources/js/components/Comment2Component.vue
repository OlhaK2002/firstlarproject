<template>
    <div>
        <p>{{author}}</p><br>
    </div>

</template>

<script>
export default {
    props: ['value'],

    mounted() {
        console.log(this.value)
    },

    data() {
        return {
            author: this.value['author'],
            data: this.value['data'],
            text: this.value['text'],
            id: this.value['id'],
            nesting: this.value['nesting'],
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            margin: this.value['nesting'] * 30,
        }
    }
}
</script>
