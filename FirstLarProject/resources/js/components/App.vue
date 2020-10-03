<template>
    <div>
        <h1>Todo application</h1>
        <AppTodo v-on:add-todo="addTodo"/>
        <Todolist
              v-bind:todos = "todos"
              v-on:remove="Remove"
        />

    </div>
</template>

<script>
import TodoList from "./TodoList";
import AppTodo from "./AppTodo";
export default {
name: "App",
    data() {
        return {
            todos: [
                {id: 1, title: "Придбати молоко", completed: false},
                {id: 2, title: "Придбати хліб", completed: false},
                {id: 3, title: "Придбати масло", completed: false}

            ]
        }
    },
    components:{
        Todolist: TodoList, AppTodo: AppTodo,
    },
    methods: {
        Remove(id) {
            this.todos = this.todos.filter(t => t.id !== id)
        },
        addTodo(todo){
            this.todos.push(todo)
            console.log(this.todos)
            this.text = '';
        }
    },
}
</script>

<style scoped>
h1{
    text-align: center;
}
.text{
    font-size: 25px;
}

</style>
