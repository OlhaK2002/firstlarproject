<template>
    <form @submit.prevent="onSubmit">
        <input type="text" v-model="title">
        <button type="submit">Create</button>
    </form>
</template>

<script>
export default {
    data(){
        return {
            title: ''
        }
    },
 methods: {
     onSubmit() {
        if(this.title.trim()){
            const newTodo = {
                title: this.title,
                completed: false
            }
            this.$emit('add-todo', newTodo)
        }
     }
 }
}
</script>

<style scoped>

</style>
