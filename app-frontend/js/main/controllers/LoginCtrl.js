angular.module('myApp')
    .controller('LoginCtrl', ['$scope', 'rest', '$window', function ($scope, rest, $window) {

        rest.path = 'v1/user/login';

        $scope.loginLoading = false;

        var errorCallback = function (data) {
            delete $window.sessionStorage._auth;
            $scope.errors = data;
        };

        $scope.login = function () {
            $scope.loginLoading = true;
            rest.postModel($scope.model)
                .success(function (data) {
                    $window.sessionStorage._auth = data;
                    //toaster.pop('success', "Success");
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