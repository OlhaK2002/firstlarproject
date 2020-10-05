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

        <div v-for = "(value, index) in displayedPosts">
            <div class = "text">
                <div v-bind:style = "{'margin-left': value['nesting']*30+'px'}"><br>
                    <div class = "comment author">{{value['author']}}</div>&nbsp
                    <div class = "comment data">({{value['data']}})</div><br>
                    <div class = "comment">{{value['text']}}</div><br>
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
        </div>
        <br><br>
        <div class="clearfix btn-group col-md-2 offset-md-5">
            <button type="button" class="btn btn-sm btn-outline-secondary bg-white" v-if="page != 1" @click="page--"> << </button>
            <button type="button" class="btn btn-sm btn-outline-secondary bg-white"  @click="page"> {{page}} </button>
            <button type="button" @click="page++" v-if="page < pages.length" class="btn btn-sm btn-outline-secondary  bg-white"> >> </button>
        </div>
    </div>
</template>

<script>
export default {
    props: ['array','bool'],
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            text: '',
            text0: '',
            parent_id: '',
            nesting: '',
            array1: this.array || [],
            posts: [],
            page: 1,
            perPage: 5,
            pages: [],
            count: 0,
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
                    this.array1 = this.array1 || [];
                    if (parent_id === 0) {this.array1.push(response.data)}
                    else {this.array1.splice(index+1, 0, response.data)}
                    this.text = '';
                    this.text0 = '';
                })
        },
        setPages () {
            let numberOfPages = Math.ceil(this.array1.length / this.perPage);
            for (let index = 1; index <= numberOfPages; index++) {
                this.pages.push(index);
            }
        },
        paginate (array1) {
            let page = this.page;
            let perPage = this.perPage;
            let from = (page * perPage) - perPage+1;
            let to = (page * perPage)+1;
            return  array1.slice(from, to);
        }
    },
    created () {
        this.onSubmit();
    },
    watch: {
        array1 () {
            this.setPages();
        }
    },
    computed: {
        displayedPosts () {
            return this.paginate(this.array1);
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
