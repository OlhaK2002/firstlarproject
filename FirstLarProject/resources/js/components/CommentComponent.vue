<template>
    <div>
        <div v-for = "value in array1">
            <div class = "text">
                <div id = "comment0">  </div>
                <div v-bind:style = "{'margin-left': value['nesting']*30+'px'}"><br>
                    <div class = "cool author">{{value['author']}}</div>&nbsp
                    <div class = "cool data">({{value['data']}})</div><br>
                    <div class = "cool">{{value['text']}}</div><br>
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
                            <form @submit.prevent="onSubmit(value['id'], value['nesting'])">
                                <input type = "hidden" name = "_token" :value="csrf">
                                <textarea required  v-model="text"  name = "text" :id = "'text_id'+value['id']" class = "form-control"></textarea><br>
                                <input type = "hidden"  :id = "'parent_id'+value['id']" class = "parent_id" name = "parent_id" :value="value['id']">
                                <input type = "hidden" class = "nesting" name = "nesting" :value = "value['nesting']">
                                <button :id = "value['id']" type = "submit" class = "btn btn-light button1" >Отправить</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div v-if="array['parent_id']===value['id']">  </div>
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
            parent_id: '',
            nesting:  '',
            array: [],
        }
    },
    methods: {
        onSubmit(parent_id, nesting) {
            console.log(this.text, parent_id, nesting)
            let form = new FormData();
            form.append('text', this.text);
            form.append('parent_id', parent_id);
            form.append('nesting', nesting);
            axios({
                method: 'post',
                url: '/reply',
                data: form
                }
            )
            .then(response => {

                    let id = response.data['id'];
                    let parent_id =  response.data['parent_id'];
                    let author = response.data['author'];
                    let data = response.data['data'];
                    let nesting = response.data['nesting'];
                    let text = response.data['text'];

                    let array = {
                        id: id,
                        author: author,
                        text: text,
                        parent_id: parent_id,
                        nesting: nesting,
                        data: data,
                    }
                    this.array1.push(array)
                    console.log(this.array1)
                this.text = '';
            })
        }
    },
}
</script>

<style>
    .nesting {
        display: inline-block;
    }
    .cool{
        display: inline-block;
    }
</style>
