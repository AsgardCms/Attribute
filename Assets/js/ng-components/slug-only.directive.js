angular.module('app.directive.slug-only', [])
    .directive('slugOnly', function() {
        return {
            restrict: 'A',
            require: '?ngModel',
            link: function(scope, element, attr, ngModelCtrl) {
                ngModelCtrl.$parsers.push(function (inputValue) {
                    if (inputValue == undefined) return '';
                    var transformedInput = inputValue.replace(/[^a-z0-9-_]/g, '');
                    if (transformedInput !== inputValue) {
                        ngModelCtrl.$setViewValue(transformedInput);
                        ngModelCtrl.$render();
                    }
                    return transformedInput;
                });
            }
        };
    });
