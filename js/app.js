'use strict';

/* App Module */

angular.module('phonecat', []).
  config(['$routeProvider', function($routeProvider) {
  $routeProvider.
      when('/songs', {templateUrl: 'partials/song-list.html',   controller: SongList}).
      when('/movies', {templateUrl: 'partials/movie-list.html', controller: MovieList}).
      when('/shows', {templateUrl: 'partials/show-list.html', controller: ShowList}).
      when('/songs/:songId', {templateUrl: 'partials/song-detail.html', controller: SongDetail}).
      when('/movies/:movieId', {templateUrl: 'partials/movie-detail.html', controller: MovieDetail}).
      when('/shows/:showId', {templateUrl: 'partials/show-detail.html', controller: ShowDetail}).
      otherwise({redirectTo: '/songs'});
}]);
