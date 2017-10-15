<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 */
?>

<!-- Include stylesheet -->
<style>
    @import 'https://fonts.googleapis.com/css?family=Montserrat:400,700';

    .aa-input-container {
        display: inline-block;
        position: relative;
    }

    .aa-input-search {
        width: 300px;
        padding: 12px 28px 12px 12px;
        /*border: 2px solid #e4e4e4;*/
        border: 0;
        border-radius: 4px;
        -webkit-transition: .2s;
        transition: .2s;
        font-family: "Montserrat", sans-serif;
        /*box-shadow: 4px 4px 0 rgba(241, 241, 241, 0.35);*/
        font-size: 11px;
        box-sizing: border-box;
        color: #333;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    .aa-input-search::-webkit-search-decoration, .aa-input-search::-webkit-search-cancel-button,
    .aa-input-search::-webkit-search-results-button, .aa-input-search::-webkit-search-results-decoration {
        display: none;
    }

    .aa-input-search:focus {
        outline: 0;
        border-color: #3a96cf;
        /*box-shadow: 4px 4px 0 rgba(58, 150, 207, 0.1);*/
    }

    .aa-input-icon {
        height: 16px;
        width: 16px;
        position: absolute;
        top: 50%;
        right: 16px;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        fill: #e4e4e4;
        pointer-events: none;
    }

    .aa-hint {
        color: #e4e4e4;
    }

    .aa-dropdown-menu {
        background-color: #fff;
        border: 2px solid rgba(228, 228, 228, 0.6);
        border-top-width: 0;
        font-family: "Montserrat", sans-serif;
        width: 300px;
        margin-top: 10px;
        /*box-shadow: 4px 4px 0 rgba(241, 241, 241, 0.35);*/
        font-size: 11px;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .aa-suggestion {
        padding: 6px 12px;
        cursor: pointer;
        -webkit-transition: .2s;
        transition: .2s;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
    }

    .aa-suggestion:hover, .aa-suggestion.aa-cursor {
        background-color: rgba(241, 241, 241, 0.35);
    }

    .aa-suggestion > div {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        width: 100%;
    }

    .aa-suggestion span:first-child {
        color: #333;
    }

    .aa-suggestion span:last-child {
        text-transform: uppercase;
        color: #a9a9a9;
    }

    .aa-suggestion img {
        max-width: 80px;
        margin-right: 10px;
    }

    .aa-suggestions-category {
        text-transform: uppercase;
        border-bottom: 2px solid rgba(228, 228, 228, 0.6);
        border-top: 2px solid rgba(228, 228, 228, 0.6);
        padding: 10px;
        color: #a9a9a9;
        padding: 6px 12px;
        text-align: left;
    }

    .aa-suggestion span:first-child em, .aa-suggestion span:last-child em {
        font-weight: 700;
        font-style: normal;
        background-color: rgba(58, 150, 207, 0.1);
        padding: 2px 0 2px 2px;
    }

    .aa-dropdown-menu {
        /*width: 600px;*/
    }

    .aa-dropdown-menu > div {
        display: inline-block;
        width: 50%;
        vertical-align: top;
    }

    .aa-empty {
        padding: 6px 12px;
    }
</style>

<!-- HTML Markup -->
<div class="d-none d-lg-block">
    <div class="aa-input-container" id="aa-input-container">
        <input type="search" id="aa-search-input" class="aa-input-search" placeholder="Search for people or places..."
               name="search" autocomplete="off"/>
        <svg class="aa-input-icon" viewBox="654 -372 1664 1664">
            <path
                d="M1806,332c0-123.3-43.8-228.8-131.5-316.5C1586.8-72.2,1481.3-116,1358-116s-228.8,43.8-316.5,131.5  C953.8,103.2,910,208.7,910,332s43.8,228.8,131.5,316.5C1129.2,736.2,1234.7,780,1358,780s228.8-43.8,316.5-131.5  C1762.2,560.8,1806,455.3,1806,332z M2318,1164c0,34.7-12.7,64.7-38,90s-55.3,38-90,38c-36,0-66-12.7-90-38l-343-342  c-119.3,82.7-252.3,124-399,124c-95.3,0-186.5-18.5-273.5-55.5s-162-87-225-150s-113-138-150-225S654,427.3,654,332  s18.5-186.5,55.5-273.5s87-162,150-225s138-113,225-150S1262.7-372,1358-372s186.5,18.5,273.5,55.5s162,87,225,150s113,138,150,225  S2062,236.7,2062,332c0,146.7-41.3,279.7-124,399l343,343C2305.7,1098.7,2318,1128.7,2318,1164z"></path>
        </svg>
    </div>
</div>

<div class="d-block d-lg-none">
    <div class="aa-input-container" id="aa-input-container">
        <svg class="aa-input-icon" viewBox="654 -372 1664 1664">
            <path
                d="M1806,332c0-123.3-43.8-228.8-131.5-316.5C1586.8-72.2,1481.3-116,1358-116s-228.8,43.8-316.5,131.5  C953.8,103.2,910,208.7,910,332s43.8,228.8,131.5,316.5C1129.2,736.2,1234.7,780,1358,780s228.8-43.8,316.5-131.5  C1762.2,560.8,1806,455.3,1806,332z M2318,1164c0,34.7-12.7,64.7-38,90s-55.3,38-90,38c-36,0-66-12.7-90-38l-343-342  c-119.3,82.7-252.3,124-399,124c-95.3,0-186.5-18.5-273.5-55.5s-162-87-225-150s-113-138-150-225S654,427.3,654,332  s18.5-186.5,55.5-273.5s87-162,150-225s138-113,225-150S1262.7-372,1358-372s186.5,18.5,273.5,55.5s162,87,225,150s113,138,150,225  S2062,236.7,2062,332c0,146.7-41.3,279.7-124,399l343,343C2305.7,1098.7,2318,1128.7,2318,1164z"></path>
        </svg>
    </div>
</div>

<!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
<script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
<script>
    var client = algoliasearch('<?= env('ALGOLIA_APPLICATION_ID') ?>', '<?= env('ALGOLIA_SEARCH_API_KEY') ?>')
    var people = client.initIndex('people');
    var places = client.initIndex('places');

    autocomplete('#aa-search-input', {}, [
        {
            source: autocomplete.sources.hits(people, {hitsPerPage: 3}),
            displayKey: 'name',
            templates: {
                header: '<div class="aa-suggestions-category">People</div>',
                //suggestion: function(suggestion) {
                //    return '<span>' +
                //        suggestion._highlightResult.name.value + '</span><span>'
                //        + suggestion._highlightResult.place.value + '</span>';
                //}
            }
        },
        {
            source: autocomplete.sources.hits(places, {hitsPerPage: 3}),
            displayKey: 'name',
            templates: {
                header: '<div class="aa-suggestions-category">Places</div>',
                //suggestion: function(suggestion) {
                //    return '<span>' +
                //        suggestion._highlightResult.name.value + '</span><span>'
                //        + suggestion._highlightResult.location.value + '</span>';
                //}
            }
        }
    ]);
</script>
