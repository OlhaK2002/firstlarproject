<template>
    <div class="comments">
        {{displayComment}}
        <div class = "text" style = "margin-left: 30px">
            <form v-if = "bool" @submit.prevent = "onSubmit(0,0, 0)">
                <input type = "hidden" name = "_token" :value = "csrf">
                <textarea rows = "3" required name = "text" v-model = "text_parent_id_0" class = "form-control nesting" placeholder = "Введите Ваш комментарий..."></textarea>
                <button type = "submit" class = "btn btn-light">Отправить</button>
            </form>
            <h4 v-else>  Для того чтобы оставить свой отзыв - <a style = "color: lightcoral" href = "/login">войдите</a> или <a style = "color: lightcoral" href = "/register">зарегистрируйтеся</a></h4><br><br>
        </div>
        <div v-for = "(value, index) in array_comment">
            <div class = "text" v-if="value['number_in_parent']">
                <div v-bind:style = "{'margin-left': value['nesting']*30+'px'}"><br>
                    <div class = "comment author">{{value['author']}}</div>&nbsp
                    <div class = "comment data">({{value['data']}})</div><br>
                    <div class = "comment">{{value['text']}}</div>
                </div>
            </div>
            <div v-if = "bool">
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
                <form @submit.prevent = "coverUp(value['id'], index)" v-if="count_comment[index + 1] > 0 ">
                    <button v-bind:style = "{'margin-left': value['nesting']*30+'px'}" type="submit" class = "btn btn-light">Скрыть ответы</button>
                </form>

                <form @submit.prevent = "showMore(value['id'], index)" v-if = "value['count_children'] > 0 && count_comment[index + 1] === 0">
                    <button v-bind:style = "{'margin-left': value['nesting']*30+'px'}" type="submit" class = "btn btn-light">Показать ответы</button>
                </form>

                <form @submit.prevent = "showMore(value['id'], index)" v-if = "value['count_children'] > 0 && count_comment[index + 1] !== 0 && value['count_children'] > (count_comment[index + 1]*perPage)">
                    <button v-bind:style = "{'margin-left': value['nesting']*30+'px'}" type="submit" class = "btn btn-light">Показать больше</button>
                </form>
            </div>
        </div>
        <br><br>

        <form @submit.prevent = "showMore(0, -1)" v-if="count_parent_id0 < count_parent_id0_in_db">
            <button v-bind:style = "{'margin-left': 30+'px'}" type="submit" class = "btn btn-light">Показать больше</button>
        </form>
        <form @submit.prevent = "coverUp(0, -1)" v-if="count_parent_id0 > 3">
            <button v-bind:style = "{'margin-left': 30+'px'}" type="submit" class = "btn btn-light">Скрыть ответы</button>
        </form>
    </div>
</template>

<script>
export default {
    props: ['array', 'bool', 'array_limit'],
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            text: '',
            text_parent_id_0: '',
            parent_id: '',
            nesting: '',
            array_comment: this.array || [],
            array_first: [],
            perPage: this.array_limit['perPage'],
            children_limit: this.array_limit['children_limit'],
            count: 0,
            count_element: [],
            count_parent_id0: 0,
            count_parent_id0_in_db: this.array_limit['comment_parent_id0'],
            count_comment: [],
            parent_comment: [],
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
                    this.array_comment[index]['count_children']++;
                    this.text = '';
                    this.text_parent_id_0 = '';
                })

                .catch(function (error) {
                    console.log(error.response);
                })
        },
        showMore(id, index) {
            index = index+1;
            let to, from, count_comment_id = 0;
            count_comment_id = this.count_comment[index] + 1;
            from = count_comment_id * this.perPage - this.perPage + 1;
            to = count_comment_id * this.perPage;
            console.log(from, to);
            let form = new FormData();
            form.append('id', id);
            form.append('from', from);
            form.append('to', to);
            axios({
                method: 'post',
                url: '/comment',
                data: form
            })
                .then( response => {
                    let i;
                    if (index === 0) {i = this.array_comment.length;}
                    else if (count_comment_id > 0) {i = count_comment_id * this.perPage - this.perPage + index;}
                    else i = 0;
                    for (let index1 = 0; index1 < response.data.length; index1++)
                    {
                        this.array_comment.splice(index1 + i, 0, response.data[index1]);
                        this.count_comment.splice(index1 + i, 0, 0);
                    }
                    this.count_comment.splice(index, 1, count_comment_id);

                    console.log(this.count_comment);
                })
        },
        coverUp(id, index) {
            let array_length = this.array_comment.length;
            this.count_element = [];
            for (let index1 = 0; index1 < this.array_comment.length; index1++) {
                let comment = this.array_comment[index1];
                if (comment['parent_id'] === id) {
                    if(index !== -1){
                        this.count_element.push(index1);
                        this.deleteElement(this.array_comment[index1]['id']);
                    }
                    else if (comment['id'] !== this.array_first[0]['id'] && comment['id'] !== this.array_first[1]['id'] && comment['id'] !== this.array_first[2]['id']) {
                        this.count_element.push(index1);
                        this.deleteElement(this.array_comment[index1]['id']);
                    }
                }
            }
            if (index !== -1) {
                this.array_comment.splice(index + 1, this.count_element.length);
                this.count_comment.splice(index + 1, this.count_element.length);
            }
            else {
                this.array_comment.splice(index + (array_length - this.count_element.length) + 1, this.count_element.length);
                this.count_comment.splice(index + (array_length - this.count_element.length) , this.count_element.length);
                this.count_comment.splice(0, 1, 1);
            }
            console.log(this.array_comment, this.count_comment);
        },

        deleteElement(id) {
            for (let index1 = 0; index1 < this.array_comment.length; index1++) {
                if (this.array_comment[index1]['parent_id'] === id) {
                    this.count_element.push(index1);
                    this.deleteElement(this.array_comment[index1]['id']);
                }
            }
        }
    },

    computed: {
        displayComment() {
            this.count_parent_id0 = 0;
            for (let index = 0; index < this.array_comment.length; index++) {
                if (this.array_comment[index]['parent_id'] === 0) this.count_parent_id0++;
                if (!(this.count_comment[index] >= 0)) {this.count_comment.splice(index, 0, 0);}
            }
            if (this.count < 1) {
                this.array_first = [];
                this.array_first.splice(0, 0, this.array_comment['0'])
                this.array_first.splice(1, 0, this.array_comment['1'])
                this.array_first.splice(2, 0, this.array_comment['2'])

                this.count_comment.fill(0);
                this.count_comment.splice(0,0,1);
            }
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
