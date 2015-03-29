'use strict';

/**
 * @ngdoc directive
 * @name myApp.directive:flash
 * @description
 * # flash
 * Показывает flash сообщения на сайте
 */
angular.module('myApp')
    .directive('flash', function () {
        return {
            restrict: 'E',
            scope:{
                message:'@message',
                className: '@className'
            },
            controller: function ($scope, $element, $attrs, $modal) {
                var modalInstance = $modal.open({
                    templateUrl: '/templates/main/modal/flash-alert.html',
                    backdrop: 'static',
                    scope: $scope,
                    controller: function ($scope, $modalInstance){
                        $scope.cancel = function () {
                            $modalInstance.dismiss('cancel');
                        };
                    }
                });
            }
        }
    });