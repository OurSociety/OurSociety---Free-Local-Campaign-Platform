<?php
$searchOptions = [
    'appId' => env('ALGOLIA_APPLICATION_ID'),
    'apiKey' => env('ALGOLIA_SEARCH_API_KEY'),
    'indexName' => 'places',
];
?>

<script>
    //window.searchOptions = <?//= json_encode($searchOptions) ?>//;
</script>

<!--
<link rel="stylesheet" href="https://cdn.jsdelivr.net/leaflet/1/leaflet.css" />
<script src="https://cdn.jsdelivr.net/leaflet/1/leaflet.js"></script>

<div id="map-example-container"></div>
<input type="search" id="input-map" class="form-control" placeholder="Where are we going?" />

<style>
    #map-example-container {height: 300px};
</style>

<script src="https://cdn.jsdelivr.net/npm/places.js@1.4.15"></script>
<script>
    (function() {
        var latlng = {
            lat: 40.7116,
            lng: -74.0648
        };

        var placesAutoComplete = places({
            container: document.querySelector('#input-map')
        });

        var map = L.map('map-example-container', {
            scrollWheelZoom: false,
            zoomControl: false
        });

        var osmLayer = new L.TileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                minZoom: 1,
                maxZoom: 13,
                attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
            }
        );

        var markers = [];

        map.setView(new L.LatLng(0, 0), 1);
        map.addLayer(osmLayer);

        placesAutoComplete.on('suggestions', handleOnSuggestions);
        placesAutoComplete.on('cursorchanged', handleOnCursorchanged);
        placesAutoComplete.on('change', handleOnChange);
        placesAutoComplete.on('clear', handleOnClear);

        function handleOnSuggestions(e) {
            markers.forEach(removeMarker);
            markers = [];

            if (e.suggestions.length === 0) {
                map.setView(new L.LatLng(0, 0), 1);
                return;
            }

            e.suggestions.forEach(addMarker);
            findBestZoom();
        }

        function handleOnChange(e) {
            markers
                .forEach(function(marker, markerIndex) {
                    if (markerIndex === e.suggestionIndex) {
                        markers = [marker];
                        marker.setOpacity(1);
                        findBestZoom();
                    } else {
                        removeMarker(marker);
                    }
                });
        }

        function handleOnClear() {
            map.setView(new L.LatLng(0, 0), 1);
            markers.forEach(removeMarker);
        }

        function handleOnCursorchanged(e) {
            markers
                .forEach(function(marker, markerIndex) {
                    if (markerIndex === e.suggestionIndex) {
                        marker.setOpacity(1);
                        marker.setZIndexOffset(1000);
                    } else {
                        marker.setZIndexOffset(0);
                        marker.setOpacity(0.5);
                    }
                });
        }

        function addMarker(suggestion) {
            var marker = L.marker(suggestion.latlng, {opacity: .4});
            marker.addTo(map);
            markers.push(marker);
        }

        function removeMarker(marker) {
            map.removeLayer(marker);
        }

        function findBestZoom() {
            var featureGroup = L.featureGroup(markers);
            map.fitBounds(featureGroup.getBounds().pad(0.5), {animate: false});
        }
    })();
</script>
-->



<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/instantsearch.js@2.2.0/dist/instantsearch.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/instantsearch.js@2.2.0/dist/instantsearch-theme-algolia.min.css">
<script src="https://cdn.jsdelivr.net/npm/instantsearch.js@2.2.0/dist/instantsearch.min.js"></script>

<div class="card text-center">
    <div class="card-header">
        <div id="search-box">
            <!-- SearchBox widget will appear here -->
        </div>
    </div>
    <div class="row text-left">
        <div class="col-md-4 py-3 pl-3">
            <div id="stats" class="mb-3">
                <!-- Stats widget will appear here -->
            </div>

            <hr>

            <div id="tree" class="mb-3">
                <!-- RefinementList widget will appear here -->
            </div>

            <div id="refinement-list" class="mb-3">
                <!-- RefinementList widget will appear here -->
            </div>

            <div id="current-refined-values" class="mb-3">
                <!-- CurrentRefinedValues widget will appear here -->
            </div>

            <div id="clear-all">
                <!-- ClearAll widget will appear here -->
            </div>
        </div>
        <div class="col">
            <ul class="list-group list-group-flush" id="hits">
                <!-- Hits widget will appear here -->
            </ul>
        </div>
    </div>
    <div class="card-footer text-muted">
        <div id="pagination">
            <!-- Pagination widget will appear here -->
        </div>
    </div>
</div>

<script>
    const search = instantsearch({
        appId: '<?= env('ALGOLIA_APPLICATION_ID') ?>',
        apiKey: '<?= env('ALGOLIA_SEARCH_API_KEY') ?>',
        indexName: 'places',
        urlSync: true
    });

    // initialize currentRefinedValues
    search.addWidget(
        instantsearch.widgets.currentRefinedValues({
            container: '#current-refined-values',
            // This widget can also contain a clear all link to remove all filters,
            // we disable it in this example since we use `clearAll` widget on its own.
            clearAll: false,
            templates: {
                header: 'Selected categories'
            }
        })
    );

    search.addWidget(instantsearch.widgets.hierarchicalMenu({
        container: '#tree',
        attributes: ['tree.lvl0', 'tree.lvl1', 'tree.lvl2'],
        templates: {
            header: 'Hierarchical categories'
        }
    }));

    search.addWidget(
        instantsearch.widgets.stats({
            container: '#stats',
            autoHideContainer: false
        })
    );

    // initialize clearAll
    search.addWidget(
        instantsearch.widgets.clearAll({
            container: '#clear-all',
            templates: {
                link: 'Reset everything'
            },
            autoHideContainer: false
        })
    );

    // initialize pagination
    search.addWidget(
        instantsearch.widgets.pagination({
            container: '#pagination',
            maxPages: 20,
            // default is to scroll to 'body', here we disable this behavior
            scrollTo: false
        })
    );

    // initialize RefinementList
    search.addWidget(
        instantsearch.widgets.refinementList({
            container: '#refinement-list',
            attributeName: 'parent',
            templates: {
                header: 'Flat categories'
            }
        })
    );

    // initialize SearchBox
    search.addWidget(
        instantsearch.widgets.searchBox({
            container: '#search-box',
            placeholder: 'Search for places',
            poweredBy: true
        })
    );

    // initialize hits widget
    search.addWidget(
        instantsearch.widgets.hits({
            container: '#hits',
            templates: {
                empty: 'No results',
                item: `
                    <li class="list-group-item border border-light">
                        <!--<em>Hit {{objectID}}</em>: -->
                        <a class="card-link" href="/place/{{{_highlightResult.slug.value}}}">{{{_highlightResult.name.value}}}</a>
                    </li>
                `
            }
        })
    );

    search.start();
</script>
