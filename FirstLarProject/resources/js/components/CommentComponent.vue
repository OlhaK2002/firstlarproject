<template>
    <div>
        <div id="'comment0"></div>
        <div v-bind:style="{'margin-left': margin+'px'}"><br>
            <div class="cool" style=" font-style: italic;">{{author}}</div>&nbsp
            <div class="cool" style="font-style: italic; color: #35848F; ">({{data}})</div><br>
            <div class="cool">{{text}}</div><br>
        </div>
        <div class="accordion" id="accordionExample">
            <div class="card" v-bind:style="{'margin-left': margin+'px', 'background-color': '#FFFFFF'}">
                <div  class="card-header" :id="'heading'+id" v-bind:style="{'margin-left': margin+'px', 'background-color': '#FFFFFF'}">
                    <h2 class="mb-0">
                        <button v-bind:style="{'margin-left': -margin+'px'}" class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" aria-expanded="false" :data-target="'#collapse_'+id" :aria-controls="'collapse_'+id">
                            Ответить
                        </button>
                    </h2>
                </div>
                <div :id="'collapse_'+id" class="collapse" :aria-labelledby="'heading'+id" data-parent="#accordionExample">
                    <div class="card-body">
                        <form>
                            <input type="hidden" name="_token" :value="csrf">
                            <textarea required  name="text" :id="'text_id'+id" class="form-control"></textarea><br>
                            <input type="hidden" :id="'parent_id'+id" class="parent_id" name="parent_id" :value="id">
                            <input type="hidden" :id="'nesting'+id" class="nesting" name="nesting" :value="nesting">
                            <button :id='id' type="submit" class="btn btn-light button1">Отправить</button>
                        </form>
                    </div>
                </div>
            </div>
            <div :id="'comment'+id"></div>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['value'],

        data() {
            return {
                author: this.value['author'],
                data: this.value['data'],
                text: this.value['text'],
                id: this.value['id'],
                parent_id: this.value['parent_id'],
                nesting: this.value['nesting'],
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                margin: this.value['nesting']*30,


            }
        }
    }

</script>

