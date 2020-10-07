<template>
    <div class="comments">
        <div class = "text" style = "margin-left: 30px">
            <form v-if = "bool" @submit.prevent = "onSubmit(0,0, 0)">
                <input type = "hidden" name = "_token" :value = "csrf">
                <textarea rows = "3" required name = "text" v-model = "text0" class = "form-control nesting" placeholder = "Введите Ваш комментарий..."></textarea>
                <button type = "submit" class = "btn btn-light">Отправить</button>
            </form>
            <h4 v-else>  Для того чтобы оставить свой отзыв - <a style = "color: lightcoral" href = "/login">войдите</a> или <a style = "color: lightcoral" href = "/register">зарегистрируйтеся</a></h4><br><br>
        </div>
        {{displayComment}}
            <div v-for = "(value, index) in array2">
                <div class = "text" v-if="value['nesting']===0 || (value['nesting']-1)<=children_limit">
                    <div v-bind:style = "{'margin-left': value['nesting']*30+'px'}"><br>
                        <div class = "comment author">{{value['author']}}</div>&nbsp
                        <div class = "comment data">({{value['data']}})</div><br>
                        <div class = "comment">{{value['text']}}</div><br>
                    </div>
                </div>
                <form v-if="value['count_children']>0" @submit.prevent = "showMore(value['id'])">
                    <button v-bind:style = "{'margin-left': value['nesting']*30+'px'}" type="submit" class = "btn btn-light">Показать больше</button>
                </form>
        </div>
        <br><br>
        <form @submit.prevent = "showMore(0)">
            <button type="submit" class = "btn btn-light">Показать больше</button>
        </form>
    </div>
</template>

<script>
export default {
    props: ['array','bool', 'array_limit'],
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            text: '',
            text0: '',
            parent_id: '',
            nesting: '',
            array1: this.array || [],
            array2: [],
            k: 0,
            perPage: this.array_limit['perPage'],
            children_limit: this.array_limit['children_limit'],
            pages: [],
            count: 0,
            count2: 0,
            count_pages_comment: [],
            count_comment: [],
            index_comment: [],
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
            })
            .then(response => {
                this.array1 = this.array1 || [];
                response.data['page'] = this.page;
                if (parent_id === 0) {
                    this.array1.push(response.data)
                }
                else {
                    this.array1.splice(index+1, 0, response.data)
                }
                this.text = '';
                this.text0 = '';
            })
        },
        showMore(id){
            for (let index = 0; index < this.count_comment.length; index++){
                if(this.count_comment[index]['id'] === id) {this.count_pages_comment[index]++; this.newArray()}
            }
        },
        newArray() {
            let array = [], to;
            console.log(this.index_comment, this.count_comment, this.count_pages_comment)
            for (let index = 0; index < this.count_comment.length; index++) {
                let count = this.perPage * this.count_pages_comment[index];
                to = 0;
                if (count > 0) {
                    for (let id = 0; id < this.array1.length; id++) {
                        if (this.array1[id]['parent_id'] === this.count_comment[index]['id'] && count > 0) {
                            array[this.index_comment[index]+to] = this.array1[id];
                            count--; to++;
                        }
                    }
                    to = 0;
                    console.log(array)
                    this.array2 = array;
                }
            }
        }
    },
    computed: {
        displayComment() {
            let array = [];
            let count_0 = 0, count =0;
            for (let index = 0; index<this.array1.length; index++) {
                if (this.array1[index]['count_children'] > 0 && this.array1[index]['nesting'] < this.children_limit) {
                    this.count++;
                }
            }
            this.index_comment[0] = 0;
            for (let index = 0; index < this.array1.length; index++)
            {
                let count_00 = 0;
                if (this.array1[index]['parent_id'] === 0) {count_0++; count_00++}
                if (this.array1[index]['count_children'] > 0 && this.array1[index]['nesting'] < this.children_limit) {
                    count++;
                    array['id'] = this.array1[index]['id'];
                    array['count_children'] = this.array1[index]['count_children'];
                    this.count_comment.push(array);
                    if (this.k < 1) {
                        this.count_pages_comment.push(0);
                    }
                    array = [];
                    if (index === 0) {
                        this.index_comment[count] = (this.array1[index]['count_children']);
                    } else {
                        this.index_comment[count] = (this.index_comment[count - 1] + this.array1[index]['count_children'] + count_00);
                    }
                }
            }
            array = [];
            array['id'] = 0;
            array['count_children'] = count_0;
            if(this.k<1) this.count_comment.splice(0, 0, array);
            if(this.k<1)this.count_pages_comment.splice(0, 0, 1);
            this.k++;
            this.newArray()
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
