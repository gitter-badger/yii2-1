/**
 * @ngdoc service
 * @name myApp.rest
 * @description - описание всех REST запросов
 * # rest
 */
angular.module('myApp')
    .service('rest', function ($http, $location, $routeParams) {

        return {

            baseUrl: 'http://yii2.loc/',
            path: undefined,

            models: function () {
                return $http.get(this.baseUrl + this.path + location.search);
            },

            model: function () {
                if ($routeParams.expand != null) {
                    return $http.get(this.baseUrl + this.path + "/" + $routeParams.id + '?expand=' + $routeParams.expand);
                }
                return $http.get(this.baseUrl + this.path + "/" + $routeParams.id);
            },

            get: function () {
                return $http.get(this.baseUrl + this.path);
            },

            postModel: function (model) {
                return $http.post(this.baseUrl + this.path, model);
            },

            putModel: function (model) {
                return $http.put(this.baseUrl + this.path + "/" + $routeParams.id, model);
            },

            deleteModel: function () {
                return $http.delete(this.baseUrl + this.path);
            }
        };
    });