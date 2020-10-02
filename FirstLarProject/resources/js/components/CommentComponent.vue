<template>
    <div>
        <div v-for="value in array1">
            <div class="text">
                <div id="comment0">  </div>
                <div v-bind:style="{'margin-left': value['nesting']*30+'px'}"><br>
                    <div class="cool author">{{value['author']}}</div>&nbsp
                    <div class="cool data">({{value['data']}})</div><br>
                    <div class="cool">{{value['text']}}</div><br>
                </div>
            </div>
            <div v-if="bool">
                <div class="card" v-bind:style="{'margin-left': value['nesting']*30+'px', 'background-color': '#FFFFFF'}">
                    <div  class="card-header" :id="'heading'+value['id']" v-bind:style="{'margin-left': value['nesting']*30+'px', 'background-color': '#FFFFFF'}">
                        <h2 class="mb-0">
                            <button v-bind:style="{'margin-left': -value['nesting']*30+'px'}" class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" aria-expanded="false" :data-target="'#collapse_'+value['id']" :aria-controls="'collapse_'+value['id']">
                                Ответить
                            </button>
                        </h2>
                    </div>
                    <div :id="'collapse_'+value['id']" class="collapse" :aria-labelledby="'heading'+value['id']" data-parent="#accordionExample">
                        <div class="card-body">
                            <form>
                                <input type="hidden" name="_token" :value="csrf">
                                <textarea required  name="text" :id="'text_id'+value['id']" class="form-control"></textarea><br>
                                <input type="hidden" :id="'parent_id'+value['id']" class="parent_id" name="parent_id" :value="value['id']">
                                <input type="hidden" :id="'nesting'+value['id']" class="nesting" name="nesting" :value="value['nesting']">
                                <button :id="value['id']" type="submit" class="btn btn-light button1">Отправить</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div :id="'comment'+value['id']"> </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['array1', 'bool'],

    data() {
        return {
            array1: this.array1,
            bool: this.bool,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

        }
    }
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
