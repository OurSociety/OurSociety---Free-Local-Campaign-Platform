<script>
    import Vue from 'vue'
    import {
        createFromAlgoliaCredentials,
        Clear,
        Index,
        Input,
//        SearchBox,
        Results,
        Pagination,
        RefinementList,
        Stats,
        TreeMenu,
    } from 'vue-instantsearch';
    import SearchBox from './Algolia/SearchBox';

    export default {
        algoliaApplicationId: null,
        algoliaSearchApiKey: null,
        props: [
            'algoliaApplicationId',
            'algoliaSearchApiKey',
        ],
        components: {
            'index': Index,
            'pagination': Pagination,
            'results': Results,
            'algolia-refinement-list': RefinementList,
            'algolia-tree-menu': TreeMenu,
            'algolia-search-box': SearchBox,
            'algolia-stats': Stats,
        },
        data() {
            return {
                searchStore: createFromAlgoliaCredentials(this.algoliaApplicationId, this.algoliaSearchApiKey),
            }
        }
    }
</script>

<template>
    <index
        :search-store="searchStore"
        index-name="places"
        url-sync="true"
    >
        <div class="card text-center">
            <div class="card-header">
                <div class="form">
                    <algolia-search-box></algolia-search-box>
                </div>
            </div>
            <div class="row text-left">
                <div class="col-md-4 py-3 pl-3">
                    <div id="stats" class="mb-3">
                        <algolia-stats
                            :class-names="{
                                'ais-stats': 'small text-muted'
                            }"
                        ></algolia-stats>
                    </div>

                    <hr>

                    <div id="tree" class="mb-3">
                        <algolia-tree-menu
                            :attributes="['tree.lvl0', 'tree.lvl1', 'tree.lvl2']"
                        >
                            <h3 class="ais-hierarchical-menu--header ais-header" slot="header">Filter by Place</h3>
                        </algolia-tree-menu>
                        <!-- RefinementList widget will appear here -->
                    </div>

                    <div id="refinement-list" class="mb-3">
                        <algolia-refinement-list
                            attributeName="parent"
                        ></algolia-refinement-list>
                        <!-- RefinementList widget will appear here -->
                    </div>

                    <div id="current-refined-values" class="mb-3">
                        <algolia-refined-values></algolia-refined-values>
                        <!-- CurrentRefinedValues widget will appear here -->
                    </div>

                    <div id="clear-all">
                        <algolia-clear-all></algolia-clear-all>
                        <!-- ClearAll widget will appear here -->
                    </div>
                </div>
                <div class="col">
                    <results>
                        <ul class="list-group list-group-flush" id="hits">
                            <!-- Hits widget will appear here -->
                        </ul>
                    </results>
                </div>
            </div>
            <div class="card-footer text-muted">
                <div id="pagination">
                    <!-- Pagination widget will appear here -->
                </div>
            </div>
        </div>

    </index>
</template>

<style lang="scss">
    @import '~instantsearch.js/dist/instantsearch.css';
    @import '~instantsearch.js/dist/instantsearch-theme-algolia.css';
    @import "../../scss/variables";
    @import "~bootstrap/scss/bootstrap";

    .ais-tree-menu__list {
        @extend .list-unstyled;
    }

    .ais-tree-menu__list ul {
        @extend .list-unstyled;
        @extend .ml-3;
    }

    .ais-tree-menu__count {
        @extend .badge;
        @extend .badge-pill;
        @extend .badge-primary;
        @extend .ml-1;
    }

    .ais-refinement-list__count {
        @extend .ais-tree-menu__count;
    }

    /*
    @import "../../scss/main";

    .ais-input {
        @extend .form-control;
    }

    .ais-search-box__submit {
        @extend .btn;
        @extend .btn-primary;
        @extend .text-white;
    }

    .ais-clear {
        @extend .btn;
        @extend .btn-sm;
        @extend .btn-outline-danger;
        @extend .text-danger;
    }

    .ais-clear--disabled {
        @extend .disabled;
    }
    */
</style>
