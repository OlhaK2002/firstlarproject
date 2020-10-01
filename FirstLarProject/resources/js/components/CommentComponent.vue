<template>
    <div class="text">
        <div id="comment0"></div>
        <div v-bind:style="{'margin-left': margin+'px'}"><br>
            <div class="cool author">{{author}}</div>&nbsp
            <div class="cool data">({{data}})</div><br>
            <div class="cool">{{text}}</div><br>
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
<style>
    .author{
        font-style: italic;
    }
    .data{
        font-style: italic;
        color: #35848F;
    }
    .text {
        color: #35848F;
        font-size: 20px;
        padding: 0 15px;
    }
</style>
