'use strict';

/**
 * @ngdoc function
 * @name myApp.controller:LoginCtrl
 * @description
 * # LoginCtrl
 * Контроллер для входа на сайт
 */

angular.module('myApp')
    .controller('LoginCtrl', ['$scope', 'rest', '$window', function ($scope, rest, $window) {

        rest.path = 'v1/user/login';

        $scope.loginLoading = false;
        $scope.model = {
            username: '',
            password: ''
        };

        var errorCallback = function (data) {
            delete $window.sessionStorage._auth;
            $scope.errors = data;
        };

        $scope.login = function () {
            $scope.loginLoading = true;
            rest.postModel($scope.model)
                .success(function (data) {
                    $window.sessionStorage._auth = data;
                    window.setTimeout(function () {
                        document.location = '';
                    }, 1000);
                })
                .error(errorCallback)
                .finally(function() {
                    $scope.loginLoading = false;
                });
        };

    }]);