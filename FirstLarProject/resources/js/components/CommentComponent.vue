<template>
    <div>
        <div class="text">
            <form v-if="bool" @submit.prevent="onSubmit(0,0, 0)">
                <input type="hidden" name="_token" :value="csrf">
                <textarea rows="3" required name="text" v-model="text0" id="text_id0" class="form-control nesting" placeholder="Введите Ваш комментарий..."></textarea>
                <button type="submit" class="btn btn-light">Отправить</button>
            </form>
            <h4 v-else>  Для того чтобы оставить свой отзыв - <a style = "color: lightcoral" href="/login">войдите</a> или <a style = "color: lightcoral" href="/register">зарегистрируйтеся</a></h4><br><br>
        </div>
        <div v-for = "(value, index) in array1">
            <div class = "text">
                <div v-bind:style = "{'margin-left': value['nesting']*30+'px'}"><br>
                    <div class = "comment author">{{value['author']}}</div>&nbsp
                    <div class = "comment data">({{value['data']}})</div><br>
                    <div class = "comment">{{value['text']}}</div><br>
                </div>
            </div>
            <div v-if = "bool">
                <div class = "card" v-bind:style = "{'margin-left': value['nesting']*30+'px', 'background-color': '#FFFFFF'}">
                    <div  class = "card-header" :id = "'heading'+value['id']" v-bind:style = "{'margin-left': value['nesting']*30+'px', 'background-color': '#FFFFFF'}">
                        <h2 class="mb-0">
                            <button v-bind:style = "{'margin-left': -value['nesting']*30+'px'}" class = "btn btn-link btn-block text-left" type = "button" data-toggle="collapse" aria-expanded="false" :data-target="'#collapse_'+value['id']" :aria-controls="'collapse_'+value['id']">
                                Ответить
                            </button>
                        </h2>
                    </div>
                    <div :id = "'collapse_'+value['id']" class = "collapse" :aria-labelledby = "'heading'+value['id']" data-parent = "#accordionExample">
                        <div class="card-body">
                            <form @submit.prevent="onSubmit(value['id'], value['nesting'], index)">
                                <input type = "hidden" name = "_token" :value="csrf">
                                <textarea required  v-model="text" name = "text" class = "form-control"></textarea><br>
                                <button type = "submit" class = "btn btn-light">Отправить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['array1', 'bool'],
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            text: '',
            text0: '',
            parent_id: '',
            nesting:  '',
        }
    },
    methods: {
        onSubmit(parent_id, nesting, index) {
            let form = new FormData();
            if (parent_id === 0) {form.append('text', this.text0);}
            else {form.append('text', this.text);}
            form.append('parent_id', parent_id);
            form.append('nesting', nesting);
            axios({
                method: 'post',
                url: '/reply',
                data: form
                }
            )
            .then(response => {
                if(parent_id === 0){this.array1.push(response.data)}
                else {this.array1.splice(index+1, 0, response.data)}
                this.text = '';
                this.text0 = '';
            })
        }
    },
}
</script>

<style>
    .nesting {
        display: inline-block;
    }
    .comment{
        display: inline-block;
    }
</style>
