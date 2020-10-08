<template>
    <div class="comments">
        <div class = "text" style = "margin-left: 30px">
            <form v-if = "bool" @submit.prevent = "onSubmit(0,0, 0)">
                <input type = "hidden" name = "_token" :value = "csrf">
                <textarea rows = "3" required name = "text" v-model = "text_parent_id_0" class = "form-control nesting" placeholder = "Введите Ваш комментарий..."></textarea>
                <button type = "submit" class = "btn btn-light">Отправить</button>
            </form>
            <h4 v-else>  Для того чтобы оставить свой отзыв - <a style = "color: lightcoral" href = "/login">войдите</a> или <a style = "color: lightcoral" href = "/register">зарегистрируйтеся</a></h4><br><br>
        </div>
            {{displayComment}}
            <div v-for = "(value, index) in array_comment">
                <div class = "text" v-if = "(value['number_in_parent'] <= (count_comment[value['parent_id']]*perPage)) && (value['nesting']===0 || (value['nesting']-1)<=children_limit)">
                    <div v-bind:style = "{'margin-left': value['nesting']*30+'px'}"><br>
                        <div class = "comment author">{{value['author']}}</div>&nbsp
                        <div class = "comment data">({{value['data']}})</div><br>
                        <div class = "comment">{{value['text']}}</div>
                    </div>
                </div>
                <div v-if = "bool && (value['number_in_parent'] <= (count_comment[value['parent_id']]*perPage)) && (value['nesting']-1)<children_limit">
                    <div class = "card" v-bind:style = "{'margin-left': value['nesting']*30+'px', 'background-color': '#FFFFFF'}">
                        <div  class = "card-header" :id = "'heading'+value['id']" v-bind:style = "{'margin-left': value['nesting']*30+'px', 'background-color': '#FFFFFF', 'border': '#FFFFFF'}">
                            <h2 class = "mb-0">
                                <button v-bind:style = "{'margin-left': -value['nesting']*30+'px'}" class = "btn btn-link btn-block text-left" type = "button" data-toggle = "collapse" aria-expanded = "false" :data-target = "'#collapse_'+value['id']" :aria-controls = "'collapse_'+value['id']">
                                    Ответить
                                </button>
                            </h2>
                        </div>
                        <div :id = "'collapse_'+value['id']" class = "collapse" :aria-labelledby = "'heading'+value['id']" data-parent = "#accordionExample">
                            <div class = "card-body">
                                <form @submit.prevent = "onSubmit(value['id'], value['nesting'], index)">
                                    <input type = "hidden" name = "_token" :value = "csrf">
                                    <textarea required v-model="text" name = "text" class = "form-control"></textarea><br>
                                    <button type = "submit" class = "btn btn-light">Отправить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <form @submit.prevent = "showMore(value['id'])" v-if = "count_comment[value['id']] === 0 && value['count_children'] > 0 && (value['number_in_parent'] <= (count_comment[value['parent_id']] * perPage))">
                        <button v-bind:style = "{'margin-left': value['nesting']*30+'px'}" type="submit" class = "btn btn-light">Показать ответы</button>
                    </form>
                    <form @submit.prevent = "showMore(value['id'])" v-else-if = "(value['number_in_parent'] <= (count_comment[value['parent_id']] * perPage)) && value['count_children'] > (count_comment[value['id']] * perPage)">
                        <button v-bind:style = "{'margin-left': value['nesting']*30+'px'}" type="submit" class = "btn btn-light">Показать больше</button>
                    </form>
                    <form @submit.prevent = "coverUp(value['id'])" v-if = "count_comment[value['id']] > 0 && (value['number_in_parent'] <= (count_comment[value['parent_id']] * perPage)) && value['count_children'] > 0">
                        <button v-bind:style = "{'margin-left': value['nesting']*30+'px'}" type="submit" class = "btn btn-light">Скрыть ответы</button>
                    </form>
                </div>
        </div>
        <br><br>
        <div>
            <form @submit.prevent = "showMore(0)" v-if = "this.count_parent_id0 > (this.count_comment[0] * perPage)">
                <button type="submit" class = "btn btn-light">Показать больше </button>
            </form>
            <form @submit.prevent = "coverUp(0)" v-if = "this.count_comment[0] > 1">
                <button type="submit" class = "btn btn-light">Скрыть ответы</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props: ['array','bool', 'array_limit'],
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            text: '',
            text_parent_id_0: '',
            parent_id: '',
            nesting: '',
            array_comment: this.array || [],
            perPage: this.array_limit['perPage'],
            children_limit: this.array_limit['children_limit'],
            count: 0,
            count_parent_id0: 0,
            count_comment: [],
        }
    },
    methods: {
        onSubmit(parent_id, nesting, index) {
            let form = new FormData();
            if (parent_id === 0) {form.append('text', this.text_parent_id_0);}
            else {form.append('text', this.text);}
            form.append('parent_id', parent_id);
            form.append('nesting', nesting);
            axios({
                    method: 'post',
                    url: '/reply',
                    data: form
            })
            .then(response => {
                this.array_comment = this.array_comment || [];
                response.data['number_in_parent'] = this.array[index]['count_children'] + 1;
                this.array[index]['count_children']++;

                if (parent_id === 0) {
                    this.array_comment.push(response.data)
                }
                else {
                    this.array_comment.splice(index+1, 0, response.data)
                }
                this.text = '';
                this.text0 = '';
                console.log(this.array_comment);
            })
        },
        showMore(id){
            let count = this.count_comment[id] + 1;
            this.count_comment.splice(id, 1, count);
        },
        coverUp(id){
            if (id === 0) {this.count_comment.splice(id, 1, 1);}
            else {
                for( let index = 0; index < this.array_comment.length; index++)
                {
                    if(this.array[index]['parent_id'] === id){this.coverUp(this.array[index]['id']);}
                }
                this.count_comment.splice(id, 1, 0);
            }
        },

    },
    computed: {
        displayComment() {
            let array = [];
            for (let index = 0; index < this.array_comment.length; index++)
            {
                if (this.array_comment[index]['parent_id'] === 0) this.count_parent_id0++;
                array[this.array_comment[index]['id']] = 0;
            }
            array[0] = 1;
            if (this.count<1) this.count_comment = array;
            this.count++;
        }

    },
}
</script>

<style>
    .nesting {
        display: inline-block;
    }
    .comment{
        font-size: 20px;
        display: inline-block;
    }
    .comments{
        margin-right: 10px;
    }
</style>
