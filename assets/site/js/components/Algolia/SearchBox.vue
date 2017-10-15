<script>
    import {
        Clear,
        Input,
        SearchBox,
    } from 'vue-instantsearch';

    export default {
        components: {
            'algolia-clear': Clear,
            'algolia-input': Input,
        },
        'extends': SearchBox,
    }
</script>

<template>
    <form role="search" action="" @submit.prevent="onFormSubmit">
        <div class="input-group mb-2 mb-sm-0">
            <algolia-input
                :class-names="{
                    'ais-input': 'form-control form-control-lg'
                }"
                :search-store="searchStore"
                placeholder="Search for places"
                autofocus
            >
            </algolia-input>
            <button type="submit" class="btn btn-lg btn-secondary rounded-0">
                <i class="fa fa-search"></i>
                Search
            </button>
            <algolia-clear
                :class-names="{
                    'ais-clear': 'btn btn-lg btn-danger rounded-0-left'
                }"
            >
                <i class="fa fa-times"></i>
                Clear
            </algolia-clear>
        </div>
    </form>
</template>
