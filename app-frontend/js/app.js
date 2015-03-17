'use strict';

/**
 * @ngdoc overview
 * @name myApp
 * @description
 * # myApp
 * Главный модуль приложения
 */
angular.module('myApp', [
        'ngAnimate',
        'ngCookies',
        'ngResource',
        'ngRoute',
        'angular-ladda'
        // 'ngSanitize',
        // 'ngTouch'
    ])
    .config(function ($httpProvider) {
        var token = angular.element('head meta[name="csrf-token"]').attr('content');

        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $httpProvider.defaults.headers.post['X-CSRF-Token'] = token;

        $httpProvider.defaults.transformRequest = [function (data) {
            var param = function (obj) {
                var query = '';
                var name, value, fullSubName, subValue, innerObj, i;
                for (name in obj) {
                    value = obj[name];
                    if (value instanceof Array) {
                        for (i = 0; i < value.length; ++i) {
                            subValue = value[i];
                            fullSubName = name + '[' + i + ']';
                            innerObj = {};
                            innerObj[fullSubName] = subValue;
                            query += param(innerObj) + '&';
                        }
                    }
                    else if (value instanceof Object) {
                        for (var subName in value) {
                            subValue = value[subName];
                            fullSubName = name + '[' + subName + ']';
                            innerObj = {};
                            innerObj[fullSubName] = subValue;
                            query += param(innerObj) + '&';
                        }
                    }
                    else if (value !== undefined && value !== null) {
                        query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
                    }
                }
                return query.length ? query.substr(0, query.length - 1) : query;
            };
            return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
        }];
    })
    .config(function (laddaProvider) {
        laddaProvider.setOption({
            style: 'expand-left'
        });
    });