angular.module('directives')
    .directive('easypiechart', [function() {
        return {
            restrict:'A',
            scope:{
                percent:'@'
            },
            link:function(scope,element,attrs){
                var def_color = {0:'#636c7b',1:'#7bb55e',2:'#973739'};
                var def_options = {
                    animate: 2000,                      // Time in milliseconds for a eased animation of the bar growing, or false to deactivate.
                    barColor: def_color[attrs.index],   // The color of the curcular bar. You can pass either a css valid color string like rgb, rgba hex or string colors. But you can also pass a function that accepts the current percentage as a value to return a dynamically generated color.
                    trackColor: '#dddddd',              // The color of the track for the bar, false to disable rendering.
                    scaleColor: false,                  // The color of the scale lines, false to disable rendering.
                    size: 100,                          // Size of the pie chart in px. It will always be a square.
                    lineWidth: 8,                       // Width of the bar line in px.
                    lineCap: 'round'                   // butt, round, square
//                    onStart: '',                        // Callback function that is called at the start of any animation (only if animate is not false).
//                    onStop:'',                          // Callback function that is called at the end of any animation (only if animate is not false).
//                    onStep:''                           // Callback function that is called during animations providing the current value (the context is the plugin, so you can access the DOM element via this.$el).

                };

                $(element).easyPieChart(def_options);
                $(element).data('easyPieChart').update(attrs.percent);
            }
        }
    }])
    .directive('easypiechararrow',[function(){
        return{
            restrict:'A',
            scope:{
                percent:'@',
                color:'@'
            },
            link: function(scope, element, attrs){
                var percent = parseFloat(scope.percent) * 3.6;
                element.css('background-color',scope.color);
                element.animate({deg:percent},{
                    duration:2000,
                    step:function(now){
                        element.css('transform','rotate('+now+'deg)');
                        element.css('-webkit-transform','rotate('+now+'deg)');
                        element.css('-ms-transform','rotate('+now+'deg)');
                    }

                });
            }
        }
    }]);