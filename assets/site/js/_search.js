// instantsearch() function without reference to the widgets or connectors
import instantsearch from 'instantsearch.js/es';

// import connectors individually
// import {connectSearchBox} from 'instantsearch.js/es/connectors';

// import widgets individually
// import {searchBox} from 'instantsearch.js/es/widgets';

// const search = instantsearch({ ... });

// search.addWidget(searchBox({ ... }));
// search.addWidget(connectSearchBox(function() { ... })({ ... }))

// noinspection SpellCheckingInspection
// import instantsearch from 'instantsearch.js';
// import searchBox from 'instantsearch.js/es/widgets';

function enableSearch(opts) {

  // ---------------------
  //
  //  Init
  //
  // ---------------------
  const search = instantsearch({
    appId: opts.appId,
    apiKey: opts.apiKey,
    indexName: opts.indexName,
    urlSync: true,
  });

  // ---------------------
  //
  //  Default widgets
  //
  // ---------------------
  search.addWidget(
    instantsearch.widgets.searchBox({
      container: '#search-input',
      placeholder: 'Search for products by name, type, brand, ...',
    })
  );

//   search.addWidget(
//     instantsearch.widgets.hits({
//       container: '#hits',
//       hitsPerPage: 10,
//       templates: {
//         item: getTemplate('hit'),
//         empty: getTemplate('no-results'),
//       },
//       transformData: {
//         item: function (item) {
//           item.starsLayout = getStarsHTML(item.rating);
//           item.categories = getCategoryBreadcrumb(item);
//           return item;
//         },
//       },
//     })
//   );
//
//   search.addWidget(
//     instantsearch.widgets.stats({
//       container: '#stats',
//     })
//   );
//
//   search.addWidget(
//     instantsearch.widgets.sortBySelector({
//       container: '#sort-by',
//       autoHideContainer: true,
//       indices: [{
//         name: opts.indexName, label: 'Most relevant',
//       }, {
//         name: `${opts.indexName}_price_asc`, label: 'Lowest price',
//       }, {
//         name: `${opts.indexName}_price_desc`, label: 'Highest price',
//       }],
//     })
//   );
//
//   search.addWidget(
//     instantsearch.widgets.pagination({
//       container: '#pagination',
//       scrollTo: '#search-input',
//     })
//   );
//
//   // ---------------------
//   //
//   //  Filtering widgets
//   //
//   // ---------------------
//   search.addWidget(
//     instantsearch.widgets.hierarchicalMenu({
//       container: '#hierarchical-categories',
//       attributes: [
//         'hierarchicalCategories.lvl0',
//         'hierarchicalCategories.lvl1',
//         'hierarchicalCategories.lvl2'],
//       sortBy: ['isRefined', 'count:desc', 'name:asc'],
//       showParentLevel: true,
//       limit: 10,
//       templates: {
//         header: getHeader('Category'),
//         item: `
//             <a href="javascript:void(0);" class="facet-item {{#isRefined}}active{{/isRefined}}">
//                 <span class="facet-name">
//                     <i class="fa fa-angle-right"></i>
//                     {{name}}
//                 </span class="facet-name">
//                 <span class="ais-hierarchical-menu--count">{{count}}</span>
//             </a>
//         ` // eslint-disable-line
//       },
//     })
//   );
//
//   search.addWidget(
//     instantsearch.widgets.refinementList({
//       container: '#brand',
//       attributeName: 'brand',
//       sortBy: ['isRefined', 'count:desc', 'name:asc'],
//       limit: 5,
//       operator: 'or',
//       showMore: {
//         limit: 10,
//       },
//       searchForFacetValues: {
//         placeholder: 'Search for brands',
//         templates: {
//           noResults: '<div class="sffv_no-results">No matching brands.</div>',
//         },
//       },
//       templates: {
//         header: getHeader('Brand'),
//       },
//       collapsible: {
//         collapsed: false,
//       },
//     })
//   );
//
//   search.addWidget(
//     instantsearch.widgets.rangeSlider({
//       container: '#price',
//       attributeName: 'price',
//       tooltips: {
//         format: function (rawValue) {
//           return `$${Math.round(rawValue).toLocaleString()}`;
//         },
//       },
//       templates: {
//         header: getHeader('Price'),
//       },
//       collapsible: {
//         collapsed: false,
//       },
//     })
//   );
//
//   search.addWidget(
//     instantsearch.widgets.priceRanges({
//       container: '#price-range',
//       attributeName: 'price',
//       labels: {
//         currency: '$',
//         separator: 'to',
//         button: 'Apply',
//       },
//       templates: {
//         header: getHeader('Price range'),
//       },
//       collapsible: {
//         collapsed: true,
//       },
//     })
//   );
//
//   search.addWidget(
//     instantsearch.widgets.starRating({
//       container: '#stars',
//       attributeName: 'rating',
//       max: 5,
//       labels: {
//         andUp: '& Up',
//       },
//       templates: {
//         header: getHeader('Rating'),
//       },
//       collapsible: {
//         collapsed: false,
//       },
//     })
//   );
//
//   search.addWidget(
//     instantsearch.widgets.toggle({
//       container: '#free-shipping',
//       attributeName: 'free_shipping',
//       label: 'Free Shipping',
//       values: {
//         on: true,
//       },
//       templates: {
//         header: getHeader('Shipping'),
//       },
//       collapsible: {
//         collapsed: true,
//       },
//     })
//   );
//
//   search.addWidget(
//     instantsearch.widgets.menu({
//       container: '#type',
//       attributeName: 'type',
//       sortBy: ['isRefined', 'count:desc', 'name:asc'],
//       limit: 10,
//       showMore: true,
//       templates: {
//         header: getHeader('Type'),
//       },
//       collapsible: {
//         collapsed: true,
//       },
//     })
//   );
//
//   search.start();
}
//
// // ---------------------
// //
// //  Helper functions
// //
// // ---------------------
// function getTemplate(templateName) {
//   return document.querySelector(`#${templateName}-template`).innerHTML;
// }
//
// function getHeader(title) {
//   return `<h5>${title}</h5>`;
// }
//
// function getCategoryBreadcrumb(item) {
//   const highlightValues = item._highlightResult.categories || [];
//   return highlightValues.map(category => category.value).join(' > ');
// }
//
// function getStarsHTML(rating, maxRating) {
//   let html = '';
//   maxRating = maxRating || 5;
//
//   for (let i = 0; i < maxRating; ++i) {
//     html += `<span class="ais-star-rating--star${i < rating ? '' : '__empty'}"></span>`;
//   }
//
//   return html;
// }

if (window.searchOptions) {
  enableSearch(window.searchOptions);
}


// -----------------------

// const search = instantsearch({
//   appId: "KLU08ZIK64",
//   apiKey: 'YourSearchOnlyApiKey',
//   indexName: 'indexName'
// });
//
// search.addWidget(
//   instantsearch.widgets.searchBox({
//     container: '#search',
//     placeholder: 'Search for actors'
//   })
// );

// document.getElementById('search_query_query').addEventListener('keydown', function (e) {
//   if (e.keyCode === 13) {
//     e.preventDefault();
//   }
// });
//
// var search = instantsearch({
//   appId: algoliaConfig.app_id,
//   apiKey: algoliaConfig.search_key,
//   indexName: algoliaConfig.index_name,
//   urlSync: true,
//   searchFunction: function(helper) {
//     var searchResults = $('#search-container');
//     if (helper.state.query === '' && helper.state.hierarchicalFacetsRefinements.type === undefined && helper.state.hierarchicalFacetsRefinements.tags === undefined) {
//       searchResults.addClass('hidden');
//     } else {
//       helper.search();
//       searchResults.removeClass('hidden');
//     }
//   }
// });
//
// search.addWidget(
//   instantsearch.widgets.searchBox({
//     container: '#search_query_query',
//     magnifier: false,
//     reset: false,
//     wrapInput: false,
//     autofocus: true,
//     //queryHook: function (query, search) {
//     //    search(query);
//     //}
//   })
// );
//
// search.addWidget(
//   instantsearch.widgets.hits({
//     container: '.search-list',
//     transformData: function (hit) {
//       if (hit.type === 'virtual-package') {
//         hit.virtual = true;
//       }
//
//       return hit;
//     },
//     templates: {
//       empty: 'No packages found.',
//       item: `
// <div data-url="/packages/{{ name }}" class="col-xs-12 package-item">
//     <div class="row">
//         <div class="col-sm-9 col-lg-10">
//             <p class="pull-right language">{{ language }}</p>
//             <h4 class="font-bold">
//                 <a href="/packages/{{ name }}" tabindex="2">{{{ _highlightResult.name.value }}}</a>
//                 {{#virtual}}
//                     <small>(Virtual Package)</small>
//                 {{/virtual}}
//             </h4>
//
//             <p>{{{ _highlightResult.description.value }}}</p>
//
//             {{#abandoned}}
//             <p class="abandoned">
//                 <i class="glyphicon glyphicon-exclamation-sign"></i> Abandoned!
//                 {{#replacementPackage}}
//                     See <a href="/packages/{{ replacementPackage }}">{{ replacementPackage }}</a>
//                 {{/replacementPackage}}
//             </p>
//             {{/abandoned}}
//         </div>
//
//         <div class="col-sm-3 col-lg-2">
//             {{#meta}}
//                 <p class="metadata">
//                     <span class="metadata-block"><i class="glyphicon glyphicon-arrow-down"></i> {{ meta.downloads_formatted }}</span>
//                     <span class="metadata-block"><i class="glyphicon glyphicon-star"></i> {{ meta.favers_formatted }}</span>
//                 </p>
//             {{/meta}}
//         </div>
//     </div>
// </div>
// `
//     },
//     cssClasses: {
//       root: 'packages',
//       item: 'row'
//     }
//   })
// );
//
// search.addWidget(
//   instantsearch.widgets.pagination({
//     container: '.pagination',
//     maxPages: 200,
//     scrollTo: false,
//     showFirstLast: false,
//   })
// );
//
// search.addWidget(
//   instantsearch.widgets.currentRefinedValues({
//     container: '.search-facets-active-filters',
//     clearAll: 'before',
//     clearsQuery: false,
//     cssClasses: {
//       clearAll: 'pull-right'
//     },
//     templates: {
//       header: 'Active filters',
//       item: function (filter) {
//         if ('tags' == filter.attributeName) {
//           return 'tag: ' + filter.name
//         } else {
//           return filter.attributeName + ': ' + filter.name
//         }
//       }
//     },
//     onlyListedAttributes: true,
//   })
// );
//
// search.addWidget(
//   instantsearch.widgets.menu({
//     container: '.search-facets-type',
//     attributeName: 'type',
//     limit: 15,
//     showMore: true,
//     templates: {
//       header: 'Package type'
//     }
//   })
// );
//
// search.addWidget(
//   instantsearch.widgets.menu({
//     container: '.search-facets-tags',
//     attributeName: 'tags',
//     limit: 15,
//     showMore: true,
//     templates: {
//       header: 'Tags'
//     }
//   })
// );
//
// search.start();
