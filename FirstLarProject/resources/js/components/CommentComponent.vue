<template>
    <div>
        <div v-for="value in array1">
            <div class="text">
                <div id="comment0"></div>
                <div v-bind:style="{'margin-left': value['nesting']*30+'px'}">
                    <div class="cool author">{{value['author']}}</div>&nbsp
                    <div class="cool data">({{value['data']}})</div><br>
                    <div class="cool">{{value['text']}}</div><br>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['array1'],
    data() {
        return {
            array1: this.array1,
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
.cool{
    display: inline-block;
}
</style>
