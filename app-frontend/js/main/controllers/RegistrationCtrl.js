'use strict';

/**
 * @ngdoc function
 * @name myApp.controller:RegistrationCtrl
 * @description
 * # RegistrationCtrl
 * Контроллер для регистрации на сайте
 */

angular.module('myApp')
    .controller('RegistrationCtrl', ['$scope', 'rest', 'toaster', '$window', function ($scope, rest, toaster, $window) {

        rest.path = 'v1/user/registration';

        var defaultModel = {
            first_name: '',
            last_name: '',
            email: '',
            phone: '',
            password: '',
            verifyPassword: ''
        };

        $scope.loading = false;
        $scope.model = angular.copy(defaultModel);
        $scope.errors = [];

        var errorCallback = function (data) {
            $scope.errors = data;
            toaster.pop('error', "Исправьте пожалуйста ошибки.");
        };

        $scope.registration = function () {
            $scope.loading = true;

            rest.postModel($scope.model)
                .success(function (data) {
                    toaster.pop('success', "Регистрация прошла успешно. На Ваш имейл отправлено письмо для активации акаунта.");
                    $scope.model = angular.copy(defaultModel);
                    $scope.errors = [];
                    window.setTimeout(function () {
                        document.location = document.location.origin;
                    }, 3000);
                })
                .error(errorCallback)
                .finally(function() {
                    $scope.loading = false;
                });
        };

    }]);