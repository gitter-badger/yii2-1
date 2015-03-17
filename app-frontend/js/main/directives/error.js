'use strict';

/**
 * @ngdoc directive
 * @name myApp.directive:error
 * @description
 * # error
 * Показывает ошибки валидации
 */
angular.module('myApp')
    .directive('error', ['$compile', '$http', '$templateCache', function ($compile, $http, $templateCache) {
        return {
            restrict: 'E',
            compile: function (element) {
                element.html('<span ng-show="foundError" class="text-danger">{{ message }}</span>');
                return function (scope, element, attrs) {
                    var fieldName = attrs.field;
                    scope.message = null;
                    scope.foundError = false;
                    if (angular.isArray(scope.errors)) {
                        angular.forEach(scope.errors, function(error) {
                            if (error.field == fieldName) {
                                scope.foundError = true;
                                scope.message = error.message;
                            }
                        });
                    };
                }
            }
        }
    }]);