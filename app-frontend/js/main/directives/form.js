'use strict';

/**
 * @ngdoc directive
 * @name myApp.directive:form
 * @description
 * # form
 * Следит за появлением ошибок в форме
 */
angular.module('myApp')
    .directive('form', ['$compile', function ($compile) {
        return {
            restrict: 'E',
            compile: function () {
                return function (scope, element, attrs) {
                    scope.$watch('errors', function() {
                        if (scope.errors) {
                            var errorElements = element.find('error');
                            angular.forEach(errorElements, function (errorElement) {
                                var _scope = scope.$new();
                                _scope.errors = scope.errors;
                                $compile(errorElement)(_scope);
                            });
                        }
                    });
                }
            }
        }
    }]);