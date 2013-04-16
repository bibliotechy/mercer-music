'use strict';

/* Controllers */

function SongList($scope, $http) {
  $http.get('/m2/api/songs/all').success(function(data) {
    $scope.songs = data;
  });

  $scope.orderProp = 'Title';
}

function MovieList($scope, $http) {
  $http.get('/m2/api/movies/all').success(function(data) {
    $scope.movies = data;
  });

  $scope.orderProp = 'Title';
}

function ShowList($scope, $http) {
  $http.get('/m2/api/shows/all').success(function(data) {
    $scope.shows = data;
  });

  $scope.orderProp = 'Title';
}

function SongDetail($scope, $routeParams, $http) {
  $http.get('/m2/api/songs/' + $routeParams.songId).success(function(data) {
    $scope.song = data[0];
  });
}

function MovieDetail($scope, $routeParams, $http) {
  $http.get('/m2/api/movies/' + $routeParams.movieId).success(function(data) {
    $scope.movie = data[0];
  });
}

function ShowDetail($scope, $routeParams, $http) {
  $http.get('/m2/api/shows/' + $routeParams.showId).success(function(data) {
    $scope.show = data[0];
  });
}
