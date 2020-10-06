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
            <div v-for = "(value, index) in array1">
                 {{displayedPosts}}
                <div class = "text" v-if="value['page'] === page">
                    <div v-bind:style = "{'margin-left': array1[index]['nesting']*30+'px'}"><br>
                        <div class = "comment author">{{value['author']}}</div>&nbsp
                        <div class = "comment data">({{value['data']}})</div><br>
                        <div class = "comment">{{value['text']}}</div><br>
                    </div>
                </div>
                <div v-if = "bool && value['page'] === page">
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
            <button type="button" @click="page++" class="btn btn-sm btn-outline-secondary  bg-white"> >> </button>
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
            page: 1,
            perPage: 3,
            pages: [],
            count: 0,
            pages_count: [],
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
        setPages () {
            let numberOfPages = Math.ceil(this.array1.length / this.perPage);
            for (let index = 0; index <= numberOfPages; index++) {
                this.pages.push(index);
                this.pages_count[index] = 0;

            }
        },
        paginate() {
            this.setPages();
            let id;
            for (id = 1; id < this.pages.length; id++)
            {
                let from = (id * this.perPage) - this.perPage;
                let to = (id * this.perPage);
                let difference = this.pages_count[id - 1];
                if(difference>0) {
                    from = from + difference;
                    to = to + difference;
                }
                while (to < this.array1.length && this.array1[to]['parent_id'] !== 0) {
                    to++;
                }
                if (to >= this.array1.length) {to = this.array1.length}
                let index;
                for (index = from; index < to; index++)
                {
                    this.array1[index]['page'] = id;
                }
                this.pages_count[id] = (to - (id * this.perPage));
            }

        }
    },
    computed: {
        displayedPosts() {
             this.paginate();
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
