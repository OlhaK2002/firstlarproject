<template>
    <div>
        <ul>
            <TodoItem
                v-for="(todo, index) in todos"
                v-bind:todo="todo"
                v-bind:index="index"
                v-on:remove-todo="removeTodo"
            />
        </ul>
    </div>
</template>

<script>
import TodoItem from "./TodoItem";
export default {
name: "TodoList",
    components: {TodoItem},
    props: ['todos'],
    comments:{
        TodoItem: TodoItem,
    },
    methods: {
        removeTodo(id) {
            this.$emit('remove', id)
        }
    }
}
</script>

<style scoped>

</style>
