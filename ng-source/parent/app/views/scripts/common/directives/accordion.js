angular.module('directives')
    .directive("accordion", function () {
        return {
            restrict: "A",
            link: function (scope, elem, attrs) {
                var options = {
                    collapsible:true,
					heightStyle:'content',
					active:false
                };
                elem.accordion(options);
            }
        }
    });