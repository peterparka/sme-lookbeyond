// IE8 Polyfill
if (!Array.prototype.filter) {
  Array.prototype.filter = function(fun/*, thisArg*/) {
	'use strict';

	if (this === void 0 || this === null) {
	  throw new TypeError();
	}

	var t = Object(this);
	var len = t.length >>> 0;
	if (typeof fun !== 'function') {
	  throw new TypeError();
	}

	var res = [];
	var thisArg = arguments.length >= 2 ? arguments[1] : void 0;
	for (var i = 0; i < len; i++) {
	  if (i in t) {
		var val = t[i];

		// NOTE: Technically this should Object.defineProperty at
		//       the next index, as push can be affected by
		//       properties on Object.prototype and Array.prototype.
		//       But that method's new, and collisions should be
		//       rare, so use the more-compatible alternative.
		if (fun.call(thisArg, val, i, t)) {
		  res.push(val);
		}
	  }
	}

	return res;
  };
}


/**
 * @name Rampup Filter
 * @author Anthony Roberts <anth0nyr0berts@hotmail.com>
 * @version 0.0.1
 * @description Application setup
 * @changelog
 * - 0.0.1
 * --- Initial release
 *
 * @param {object} Angular module with dependencies
 **/
(function(app) {

	// app.config([ function () {

	// }]);

	app.run(['$rootScope', function ($rootScope) {

	}]);

	// Filter to allow for separated string searching
	app.filter('filterMultipleOr', function(){
		return function(input, searchText){

			var returnArray = [];

			var searchProperties = Object.keys(searchText);

			for(var x = 0; x < input.length; x++) {

				for (var i = searchProperties.length - 1; i >= 0; i--) {

					// Get first key (in this case name or nickname)
					var searchTextSplit = searchText[ searchProperties[i] ].toLowerCase().split(' ');
					var count = 0;

					for(var y = 0; y < searchTextSplit.length; y++){

						if(input[x][ searchProperties[i] ].toLowerCase().indexOf(searchTextSplit[y]) !== -1){
							count++;
						}
					}

					if(count == searchTextSplit.length){
						 returnArray.push(input[x]);
						 break; // only check one attr
					}
				}
			}

			return returnArray;
		}
	});


	app.filter('html',function($sce){
	    return function(input){
	        return $sce.trustAsHtml(input);
	    }
	})

	app.controller('AgendaController', ['$sce', '$scope', '$rootScope', '$timeout', '$filter',
		function ($sce, $scope, $rootScope, $timeout, $filter) {

			$scope.show = {};
			$scope.show.modal = false;
			$scope.featured = {};

			if( typeof people_filters !== 'undefined' ) {

				items = people_filters.people;

				$scope.showPersonModal = function(event, personId) {

					event.preventDefault();

					for (var i = people_filters.people.length - 1; i >= 0; i--) {

						if( people_filters.people[i].id === personId ) {

							$scope.featured.speaker = people_filters.people[i];
							break;
						}
					}

					console.log( $scope.featured.speaker );

					$scope.show.modal = true;
				}
			}
		}
	]);

	app.controller('FilterCtl', ['$sce', '$scope', '$rootScope', '$timeout', '$filter', '$sce',
		function ($sce, $scope, $rootScope, $timeout, $filter, $sce) {




			// Filter options
			var options = {};
			options.random = false;
			options.display_count = 999;

			if( typeof filter_data !== 'undefined' ) {

				$scope.show = {};
				$scope.show.filterBlock = false;
				$scope.show_filter = {};

				//$scope.show_filter.last_name = false;
				$scope.filter = {};

				$scope.active_filters = {};
				$scope.filter.searchText = '';
				$scope.filter.schoolSearchText = '';
				$scope.filter.last_name = [];

				var matched = {};
				var items, all_practice_areas, all_offices;

				var filters = filter_data.filters;

				$scope.filteredItems = [];

				$scope.limit = 30;

				$timeout( function() {

					$scope.limit = filter_data.display_count;

				}, 3000);

				// Loading
				$scope.loading = true;

				console.log( 'filter_data' );
				console.log( filter_data );


				// ONLY FOR LIVERAMP ABOUT PAGE
				// If options.all_button
				$scope.show.all = true;

				$scope.toggleDetail = function( item ) {

					if( item.showDetails ) {

						item.showDetails = false;

					} else {

						for (var i = $scope.filteredItems.length - 1; i >= 0; i--) {

							$scope.filteredItems[i].showDetails = false;
						}

						item.showDetails = true;
					}
				};

				//^^ ONLY FOR LIVERAMP ABOUT PAGE

				// var availablePreFilters = ['office', 'practice_area']; // filter_data.available_pre_filters ?

				// Filter options - used for *****
				// Setting filter options
				$scope.filter_options = {};

				for (var i = filters.length - 1; i >= 0; i--) {

					filters[i].allActive = true;
					$scope.filter_options[ filters[i].name ] = [];
					$scope.show_filter[ filters[i].name ] = false;
					$scope.active_filters[ filters[i].name ] = [];
				}

				$scope.filters = filters;

				var positions_lookup = [];
				var school_id = 1;

				// We only attach the information to item for display purposes ( e.g. on the people page )

				// function seoUrl($string) {
				//     //Lower case everything
				//     $string = strtolower($string);
				//     //Make alphanumeric (removes all other characters)
				//     $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
				//     //Clean up multiple dashes or whitespaces
				//     $string = preg_replace("/[\s-]+/", " ", $string);
				//     //Convert whitespaces and underscore to dash
				//     $string = preg_replace("/[\s_]/", "-", $string);
				//     return $string;
				// }

				function seoUrl( str ) {

					return str.replace(/\s+/g, '-').toLowerCase();
				}

				// if the data isn't sent through the filter property
				// function setOfficesFilter( item ) {

				// 	if( item.offices ) {

				// 		for (var j = item.office_ids.length - 1; j >= 0; j--) {

				// 			var matchedIndex = false;

				// 			// Attach information to the practice area
				// 			for (var k = 0; k < all_offices.length; k++) {

				// 				if( all_offices[k].id === item.office_ids[j] ) {

				// 					matchedIndex = k;
				// 					item.offices.push( all_offices[k] );
				// 					break;
				// 				}
				// 			}

				// 			// Sometimes a reference post may be deleted, so we must check an index has been identified
				// 			if( matchedIndex || matchedIndex === 0 ) {

				// 				if( office_ids_included.indexOf( item.office_ids[j] ) < 0 ) {

				// 					office_ids_included.push( item.office_ids[j] );

				// 					$scope.filter_options.offices.push({
				// 						id: all_offices[matchedIndex].id, // include ID for speedier lookup
				// 						value: $sce.trustAsHtml( all_offices[matchedIndex].name ),
				// 						url_value: seoUrl( all_offices[matchedIndex].name ), // only used for url filter
				// 						active: false
				// 					});
				// 				}
				// 			}
				// 		}
				// 	}
				// }

				items = filter_data.all_items;

				function shuffle(array) {

					var currentIndex = array.length, temporaryValue, randomIndex;

					// While there remain elements to shuffle...
					while (0 !== currentIndex) {

						// Pick a remaining element...
						randomIndex = Math.floor(Math.random() * currentIndex);
						currentIndex -= 1;

						// And swap it with the current element.
						temporaryValue = array[currentIndex];
						array[currentIndex] = array[randomIndex];
						array[randomIndex] = temporaryValue;
					}

					return array;
				}

				if( options.random ) {

					shuffle( items );
				}

				$scope.filteredItems = angular.copy( items );

				console.log( '$scope.filteredItems' );
				console.log( $scope.filteredItems );

				var filteredItemsNoTextFilter = items;

				// Delete
				// for (var i = 0; i < filters.length; i++) {

				// 	$scope.active_filters[ filters[i] ] = [];
				// }

				$scope.clear = {}

				$scope.clear.all = function() {

					$scope.show.filterBlock = false;

					for (var i = $scope.filters.length - 1; i >= 0; i--) {

						for (var j = $scope.filters[i].options.length - 1; j >= 0; j--) {

							$scope.filters[i].options[j].active = false;
						}
					}

					// @todo - is this needed??? Is filter options needed anymore??
					// for( var i in $scope.filter_options ) {

					// 	for( var j = $scope.filter_options[i].length - 1; j >= 0; j-- ) {

					// 		$scope.filter_options[i][j].active = false;
					// 	}
					// }

					for (var i in $scope.active_filters ) {

						$scope.active_filters[i] = [];
					}

					resetFilters();
				};


				// @todo - is this used anymore??
				$scope.showFilter = function(filterName) {

					for( property in $scope.show_filter ) {

						if( property === filterName ) {

							if( $scope.show_filter[property] ) {

								// Hit a tab that's already open
								$scope.show_filter[property] = false;

								return;

							} else {

								$scope.show_filter[property] = true;
							}

						} else {

							$scope.show_filter[property] = false;
						}
					}
				};

				var $practiceAreas;

				$scope.show.practiceChildren = [];

				$scope.hideFilters = function() {

					for( property in $scope.show_filter ) {

						$scope.show_filter[property] = false;
					}
				};

				function applyTextFilter() {

					// if( additional_text_string_to_filter === 'people' ) {

					// 	$scope.filteredItems = $filter('filterMultipleOr')( $scope.filteredItems, { name: $scope.filter.searchText, nickname: $scope.filter.searchText } );
					// }

					$scope.filteredItems = $filter('filterMultipleOr')( $scope.filteredItems, { name: $scope.filter.searchText } );
				}

				function callbackAction() {

					// Once angular changes are made in dom
					$timeout( function() {

						// Enter callback action

					});
				}

				$scope.loadMore = function() {

					console.log( 'loading more' );

					$scope.loadingMore = true;

					$scope.limit = $scope.limit + 30;

					callbackAction();

					$scope.loadingMore = false;
				};


				/**
					When search text changes, hide all menu items, and filter everyone
				*/
				$scope.changeFilterText = function() {



					// store list in filteredItemsNoTextFilter, so text filters dont accumulate
					$scope.filteredItems = filteredItemsNoTextFilter;

					applyTextFilter();
					callbackAction();
				};

				$scope.changeFilter = function( type, filterOption ) {

					console.log( type );
					console.log( filterOption );

					filterOption.active = !filterOption.active;

					if( filterOption.active ) {

						$scope.active_filters[ type ].push( filterOption );

						$scope.show.filterBlock = true;

					} else {

						$scope.active_filters[ type ].splice( $scope.active_filters[ type ].indexOf( filterOption ), 1 );

						$scope.show.filterBlock = false;

						for (var i in $scope.active_filters ) {

							if( $scope.active_filters[i].length ) {

								$scope.show.filterBlock = true;
							}
						}
					}

					resetFilters();
				};

				$scope.loadMore = function() {

					$scope.limit = $scope.limit + 30;
					callbackAction();
				}

				/**
					For the filter in the template
				*/
				$scope.random = function() {

					return 0.5 - Math.random();
				};

				resetItemMatchBooleans = function() {

					for (var i = filters.length - 1; i >= 0; i--) {

						matched[ filters[i].name ] = true;
					}
				}

				resetItemMatchBooleans();

				var resetFilter = {};

				// resetFilter.categories = function( item ) {

				// 	if( $scope.active_filters.categories && $scope.active_filters.categories.length ) {

				// 		// Need to match at least one result
				// 		matched.categories = false;

				// 		if( item.categories !== null ) {

				// 			for( var j = $scope.active_filters.categories.length - 1; j >= 0; j-- ) {

				// 				if( typeof item.category[0] !== 'undefined' ) {

				// 					if( $scope.active_filters.categories[j].cat_ID === item.category[0].cat_ID ) { // @note - this assumes only one category/taxonomy is allowed

				// 						matched.categories = true;

				// 						break;
				// 					}
				// 				}
				// 			}
				// 		}
				// 	}
				// };

				// resetFilter.media_types = function( item ) {

				// 	if( $scope.active_filters.media_types && $scope.active_filters.media_types.length ) {

				// 		// Need to match at least one result
				// 		matched.media_types = false;

				// 		if( item.video !== null || item.pdf !== null ) {

				// 			for( var j = $scope.active_filters.media_types.length - 1; j >= 0; j-- ) {

				// 				if( ( $scope.active_filters.media_types[j].id === 1 && item.pdf !== null ) || ( $scope.active_filters.media_types[j].id === 2 && item.video !== null ) ) {

				// 					matched.media_types = true;

				// 					break;
				// 				}
				// 			}
				// 		}
				// 	}
				// };

				// resetFilter.positions = function( item ) {

				// 	if( $scope.active_filters.positions && $scope.active_filters.positions.length ) {

				// 		// Need to match at least one result
				// 		matched.positions = false;

				// 		if( item.position !== null ) {

				// 			for( var j = $scope.active_filters.positions.length - 1; j >= 0; j-- ) {

				// 				if( $scope.active_filters.positions[j].id === item.position.term_id ) {

				// 					matched.positions = true;

				// 					break;
				// 				}
				// 			}
				// 		}
				// 	}
				// };

				// resetFilter.practice_areas = function( item ) {

				// 	if( $scope.active_filters.practice_areas && $scope.active_filters.practice_areas.length ) {

				// 		if( item.practice_area_and_parent_ids ) {

				// 			// Check ALL practice areas are included

				// 			// [8, 1, 10, 2, 3, 4, 5, 9].filter(function (elem) {
				// 			//     return arr1.indexOf(elem) > -1;
				// 			// }).length == arr1.length
				// 			// index of wouldnt work because we make a new object earlier

				// 			matched.practice_areas = item.practice_area_and_parent_ids.filter(function (id) {

				// 				for (var c = $scope.active_filters.practice_areas.length - 1; c >= 0; c--) {

				// 					if( $scope.active_filters.practice_areas[c].id === id ) {

				// 						return true;
				// 					}
				// 				}

				// 				return false;

				// 			}).length == $scope.active_filters.practice_areas.length;

				// 		} else {

				// 			matched.practice_areas = false;
				// 		}
				// 	}
				// };

				// resetFilter.offices = function( item ) {

				// 	if( $scope.active_filters.offices && $scope.active_filters.offices.length && item.office_ids ) {

				// 		// Need to match at least one office
				// 		matched.offices = item.office_ids.filter(function (id) {

				// 			for (var c = $scope.active_filters.offices.length - 1; c >= 0; c--) {

				// 				if( $scope.active_filters.offices[c].id === id ) {

				// 					return true;
				// 				}
				// 			}

				// 			return false;

				// 		}).length > 0;
				// 	}
				// };

				// resetFilter.schools = function( item ) {

				// 	if( $scope.active_filters.schools && $scope.active_filters.schools.length && item.schools ) {

				// 		// Check ALL schools are included
				// 		matched.schools = item.schools.filter(function (school) {

				// 			for (var c = $scope.active_filters.schools.length - 1; c >= 0; c--) {

				// 				if( $scope.active_filters.schools[c].value === school ) {

				// 					return true;
				// 				}
				// 			}

				// 			return false;

				// 		}).length > 0;
				// 	}
				// };

				function resetFilters( type ) {

					$scope.loading = true;

					$scope.filteredItems = [];

					// opted for setting booleans in case we can more quickly check.. perhaps by setting properties on the person. check for performance first
					for (var i = 0; i < items.length; i++) {

						resetItemMatchBooleans();

						// @todo improve performance
						//if( check.position = true ) {

							//var matched.positions = true;
						//}

						// @TODO - CAN WE JUST LOOP THE ACTIVE FILTERS INSTEAD OF DOING THIS CHECK ON ALL FILTERS?????
						// NO - because need to know if its or and, instead put active_options on the filter itself to stop all these checks
						// so active_filters are separated out to avoid looping through

						// Call all the functions to match the filters
						for (var j = filters.length - 1; j >= 0; j--) {

							if( filters[j].type === 'or' ) {

								// Check if active filter exists
								if( $scope.active_filters[ filters[j].name ] && $scope.active_filters[ filters[j].name ].length && items[i][ filters[j].name ] ) {

									// Need to match at least one office
									matched[ filters[j].name ] = items[i][ filters[j].name ].filter(function (id) {

										for (var c = $scope.active_filters[ filters[j].name ].length - 1; c >= 0; c--) {

											if( $scope.active_filters[ filters[j].name ][c].id === id ) {

												return true;
											}
										}

										return false;

									}).length > 0;

									// console.log( 'matched' + filters[j].name );
									// console.log( matched[filters[j].name] );
								}

							} else if( filters[j].type === 'and' ) {


								// if( $scope.active_filters.schools && $scope.active_filters.schools.length && item.schools ) {

								// 	// Check ALL schools are included
								// 	matched.schools = item.schools.filter(function (school) {

								// 		for (var c = $scope.active_filters.schools.length - 1; c >= 0; c--) {

								// 			if( $scope.active_filters.schools[c].value === school ) {

								// 				return true;
								// 			}
								// 		}

								// 		return false;

								// 	}).length > 0;
								// }

							} else if( filters[j].type === 'name_compare' ) {

								if( $scope.active_filters[ filters[j].name ] && $scope.active_filters[ filters[j].name ].length ) {

									matched[ filters[j].name ] = false;

									for (var c = $scope.active_filters[ filters[j].name ].length - 1; c >= 0; c--) {

										// console.log( items[i].display_name )
										// console.log( $scope.active_filters[ filters[j].name ][c].name );
										// console.log( items[i][ $scope.active_filters[ filters[j].name ][c].name ] );

										if( items[i][ $scope.active_filters[ filters[j].name ][c].name ] ) {

											matched[ filters[j].name ] = true;
										}
									}
								}

							} else if( filters[j].type === 'count' ) {

								if( $scope.active_filters[ filters[j].name ] && $scope.active_filters[ filters[j].name ].length ) {

									matched[ filters[j].name ] = false;



									for( var c = $scope.active_filters[ filters[j].name ].length - 1; c >= 0; c-- ) {

										// console.log('count');
										// console.log( $scope.active_filters[ filters[j].name ][c].name );
										// console.log( items[i] );
										// console.log( items[i][ $scope.active_filters[ filters[j].name ][c].name ] );

										// @todo - stop likes creating an empty array
										if( items[i][ 'favourites' ] > 0 ) {

										//if( items[i][ $scope.active_filters[ filters[j].name ][c].name ] > 0 ) {

											matched[ filters[j].name ] = true;
										}
									}
								}
							}

							//resetFilter[ filters[j] ]( items[i] );
						}

						var matchedAll = true;

						for (var k = filters.length - 1; k >= 0; k--) {

							if( !matched[ filters[k].name ] ) {

								matchedAll = false;
								break;
							}
						}

						if( matchedAll ) { $scope.filteredItems.push( items[i] ); }
					}

					filteredItemsNoTextFilter = JSON.parse(JSON.stringify( $scope.filteredItems ) );

					// Check for search text and filter again
					if( $scope.filter.searchText !== '' ) {

						applyTextFilter();
					}

					$scope.loading = false;

					callbackAction();
				};

				// // Only show one item type to begin with
				// if( pageType === 'people' ) {
				// 	// Only show partners to begin with

				// 	for (var i = $scope.filteredItems.length - 1; i >= 0; i--) {

				// 		if( $scope.filteredItems[i].position === null || $scope.filteredItems[i].position.name !== 'Partner' ) {

				// 			$scope.filteredItems.splice( i, 1 );
				// 		}
				// 	}
				// }

				// NOW CHECK IF THERE'S ANY PRE FILTERS
				var params = function() {

					function urldecode(str) {
						return decodeURIComponent((str+'').replace(/\+/g, '%20'));
					}

					function transformToAssocArray( prmstr ) {
						var params = {};
						var prmarr = prmstr.split("&");
						for ( var i = 0; i < prmarr.length; i++) {
							var tmparr = prmarr[i].split("=");
							params[tmparr[0]] = urldecode(tmparr[1]);
						}
						return params;
					}

					var prmstr = window.location.search.substr(1);
					return prmstr != null && prmstr != "" ? transformToAssocArray(prmstr) : {};
				}();

				// var preFilters = {};

				// for( var i = availablePreFilters.length - 1; i >= 0; i-- ) {

				// 	if( params.hasOwnProperty( availablePreFilters[i] ) ) {

				// 		var thisType = availablePreFilters[i] + 's';

				// 		preFilters[ thisType ] = params[ availablePreFilters[i] ];

				// 		for (var j = $scope.filter_options[ thisType ].length - 1; j >= 0; j--) {

				// 			if( $scope.filter_options[ thisType ][j].id == preFilters[ thisType ] || $scope.filter_options[ thisType ][j].url_value === preFilters[ thisType ] ) {

				// 				if( pageType === 'news' || pageType === 'people' ) {

				// 					$scope.changeFilter( thisType, $scope.filter_options[ thisType ][j] );
				// 				}

				// 				if( pageType === 'practice_areas' ) {

				// 					$scope.changeFilterPA( thisType, $scope.filter_options[ thisType ][j] );
				// 				}

				// 				break;
				// 			}
				// 		}
				// 	}
				// }

				$scope.loading = false;
				callbackAction();

			} // Ends if has data condition
		}

	]);

}(angular.module("filterApp", ['ngSanitize'] )));
