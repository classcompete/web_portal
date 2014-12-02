var directives = angular.module('ccomp.directives',[]);

directives.directive('bsNavbar', ['$location',function ($location) {
    return {
            restrict: 'A',
            link: function postLink(scope, element, attrs, controller) {
                scope.$watch(function () {
                    return $location.path();
                }, function (newValue, oldValue) {
                    $('a[data-match-route]', element).each(function (k, li) {
                        var $li = angular.element(li), pattern = $li.attr('data-match-route'), regexp = new RegExp('^' + pattern + '$', ['i']);
                        if(pattern.search(newValue) >= 0){
                            $li.addClass('selected');
                        }else{
                            $li.removeClass('selected');
                        }
                    });
                });
            }
        };
}]);
directives.directive('backstretch', function () {
    return {
    restrict: 'A',
        link: function (scope, element, attr) {
            if(attr.backgroundUrl !== undefined)
                $.backstretch('http://cdn.classcompete.com/images/kids-bg-1.jpg');
            }
        }
});
directives.directive('imageReloader', function(){
    return {
        restrict: 'A',
        link: function(scope, elem, attrs){
            if(angular.isDefined(scope.image_changed)){
                if(angular.isDefined(scope.challenge))
                    scope.challenge.teacher_image = scope.challenge.teacher_image  + '?decache='+ Math.random();

                scope.user.teacher_image  = scope.user.teacher_image + '?decache=' + Math.random();
                scope.teacher_image = scope.teacher_image + '?decache='+ Math.random();
            }
        }
    }
});
directives.directive('imageZoomSlider',function(){
    return{
        restrict:'A',
        link: function(scope, elem, attrs){
            var imageRealWidth, imgRealHeight, clicked_image_uplader, prev_clicked_image_uplader;
            scope.$watch('scope.image',function(){
                angular.element("#crop_image") // Make in memory copy of image to avoid css issues
                    .attr("src", attrs.imageUrl)
                    .load(function () {
                        imageRealWidth = this.width;   // Note: $(this).width() will not
                        imgRealHeight = this.height; // work for in memory images.
                    });
                angular.element('#crop_image').show();
                // reset slider value
                if (typeof $('#image_zoom_slider').data('slider') !== 'undefined') {
                    var slider_zoom = $('#image_zoom_slider').data('slider').getValue();

                    if (slider_zoom !== 100) {
                        set_zoom_slider_value('#image_zoom_slider', 100);
                        imageRealWidth = 'auto';
                    }
                }


                angular.element('#crop_image').attr('src', attrs.imageUrl).draggable();
                angular.element('#crop_image').css('width', imageRealWidth);

                angular.element('#image_zoom_slider').slider({min: 0, max: 200, step: 1, value: 100}).on('slide', function (e) {
                    var value = e.value;

                    var valuePx;
                    if (value === 100) {
                        valuePx = imageRealWidth;
                    }
                    else {
                        valuePx = imageRealWidth * value / 100;
                    }

                    angular.element('#crop_image').css('height', 'auto');
                    angular.element('#crop_image').css('width', valuePx + 'px');
                });

                angular.element('.image_zoom_slider_caption').show();
            });

        }
    }
});
directives.directive('alertBar',['$parse', function($parse){
    return{
        restrict: 'A',
        template: '<span class="help-inline"'+
            'ng-show="errorMessage">' +
            '{{errorMessage}}</span>',
        link:function(scope, elem, attrs){
            var alertMessageAttr = attrs['alertmessage'];
            scope.errorMessage = null;

            scope.$watch(alertMessageAttr, function(newVal){
                scope.errorMessage = newVal;
            });

            scope.hideAlert = function(){
                scope.errorMessage = null;
                $parse(alertMessageAttr).assign(scope, null);
            };

        }
    }
}]);
directives.directive('prevent', function() {
    return function(scope, element, attrs) {
        $(element).click(function(event) {
            event.preventDefault();
        });
    }
});
directives.directive('tinyscrollbar', function(){
    return{
        restrict: 'A',
        link: function(scope, element, attrs){
            $(function(){
                $("#"+attrs.id).tinyscrollbar();
            });

        }
    }
});
directives.directive('powerTipChallenge', function(){
    return {
        link: function(scope, element, attrs){

            $('.'+attrs.class).hover(function () {
                var tooltip_content = $(this).parents().siblings('.tooltip_content').html();
                var tooltip_html = $('<div style="width: 380px">' + tooltip_content + '</div>');
                $('.'+attrs.class).data('powertipjq', tooltip_html);
            });
            $('.'+attrs.class).powerTip({
                placement: 'e',
                smartPlacement: true,
                mouseOnToPopup: true
            });
        }
    }
});
directives.directive('powerTipMarketplace', function(){
    return {
        link: function(scope, element, attrs){

            $('.'+attrs.class).hover(function () {
                var tooltip_content = $(this).siblings('.tooltip_content').html();
                var tooltip_html = $('<div style="width: 380px">' + tooltip_content + '</div>');
                $('.'+attrs.class).data('powertipjq', tooltip_html);
            });
            $('.'+attrs.class).powerTip({
                placement: 'e',
                smartPlacement: true,
                mouseOnToPopup: true
            });
        }
    }
});
directives.directive('powerTipQuestion', function(){
    return {
        link: function(scope, element, attrs){

            $('.'+attrs.class).hover(function () {
                var tooltip_content = $(this).siblings('.tooltip_content').html();
                var tooltip_html = $('<div style="width: 450px">' + tooltip_content + '</div>');
                $('.'+attrs.class).data('powertipjq', tooltip_html);
            });
            $('.'+attrs.class).powerTip({
                placement: 'e',
                smartPlacement: true,
                mouseOnToPopup: true
            });
        }
    }
});
directives.directive('autocomplete',function(SchoolResource){
    return{
        restrict:'A',
        require:'?ngModel',
        link:function(scope,element,attrs){
            scope.$watch('new_teacher',function(){
                $('#school_name').autocomplete({
                    minLength: 5,
                    cache: false,
                    focus: function (event, ui) {
                        return false;
                    },
                    select: function (event, ui) {
                        this.value = ui.item.label;
                        scope.new_teacher.school_id = ui.item.id;
                    },
                    source: function (request, response) {
                        SchoolResource.get({school: scope.new_teacher.school_name, zip_code: scope.new_teacher.zip_code}).$promise.then(function(data){
                            response($.map(data.school, function (item) {
                                return {
                                    label: item.name,
                                    id: item.school_id
                                }
                            }))
                        });
                    }
                });
            });
        }
    }
});
directives.directive('easypiechart2',function(){
    return {
        restrict:'A',
        scope:{
            percent:'@'
        },
        link:function(scope,element,attrs){
            var def_options = {
                animate: 2000,
                barColor: '#74b749',
                trackColor: '#dddddd',
                scaleColor: '#74b749',
                size: 140,
                lineWidth: 6
            };
            var def_color = {0:'#74b749',1:'#ed6d49',2:'#0daed3'};

            scope.$watch('percent',function(){
                def_options.barColor = def_color[attrs.index];
                    var pieChart = new EasyPieChart(element[0], def_options);
                    pieChart.update(scope.percent);
                });
        }
    }
});
directives.directive('easypiechart', function() {
    return {
        restrict: 'A',
        require: '?ngModel',
        link: function (scope, element, attrs) {
            var options = {};
            var fx = attrs.easypiechart;
            if (fx.length > 0) {
                fx = fx.split(';'); // CSS like syntax
                var REkey = new RegExp('[a-z]+', 'i');
                var REvalue = new RegExp(':.+');
                // Parse Effects
                for (var i in fx) {
                    var value = fx[i].match(REkey);
                    var key = fx[i].match(REvalue);
                    value = value[0];
                    key = key[0].substring(1);
                    if (!isNaN(parseInt(key, 10))) {
                        options[value] = parseFloat(key);
                    } else{
                        switch (key) {
                            case 'true':
                                options[value] = true;
                                break;
                            case 'false':
                                options[value] = false;
                                break;
                            default:
                                options[value] = key;
                            }
                        }
                    }
                }
                var pieChart = new EasyPieChart(element[0], options);

                // initial pie rendering
                if (scope.percent) {
                    pieChart.update(scope.percent);
                }

                // on change of value
                var timer = null;
                scope.$watch('percent', function(oldVal, newVal) {
                    pieChart.update(newVal);

                    // this is needed or the last value won't be updated
                    clearTimeout(timer);
                    timer = setTimeout(function() {
                        pieChart.update(scope.percent);
                    }, 1000 / 60);
                });
            }
    }
});
directives.directive("bulletcharksparkline", function() {
    return {
        restrict:"A",
        scope:{
            data:"@"
        },
        compile: function(tElement,tAttrs,transclude){
            return function(scope, element, attrs){
                scope.$watch('data',function(){
                    if(attrs.id == 'challenges_sparkline'){
                        $('#challenges_sparkline').html(scope.data);
                        $('#challenges_sparkline').sparkline('html',{
                            type: 'bar',
                            barColor: '#ED6D49',
                            barWidth: 6,
                            height: 30,
                            chartRangeMin: 0
                        });
                    }else if(attrs.id === 'teacher_sparkline'){
                        $('#teacher_sparkline').html(scope.data);
                        $('#teacher_sparkline').sparkline('html',{
                            type: 'bar',
                            barColor: '#74B749',
                            barWidth: 6,
                            height: 30,
                            chartRangeMin: 0
                        });
                    }else if(attrs.id === 'students_sparkline'){
                        $('#students_sparkline').html(scope.data);
                        $('#students_sparkline').sparkline('html',{
                            type: 'bar',
                            barColor: '#FFB400',
                            barWidth: 6,
                            height: 30,
                            chartRangeMin: 0
                        });
                    }
                });

            };
        }
    };
});
directives.directive("geochart",function(){
    return {
        restrict: 'A',
        scope:{
            data:"="
        },
        compile: function(tElement,tAttrs,transclude){
            return function(scope, element, attrs){
                scope.$watch('data',function(){
                    if(angular.isUndefined(scope.data))return;
                    var data = google.visualization.arrayToDataTable(scope.data);

                    var options = {
                            region: 'US',
                            enableRegionInteractivity: true,
                            resolution: 'provinces'
                        };

                    var chart = new google.visualization.GeoChart(element[0]);
                    chart.draw(data, options);
                });

            };
        }
    }
});
directives.directive('googleChart', function () {
    return {
            restrict: 'A',
            link: function ($scope, $elm, $attr) {
                $scope.$watch($attr.data, function (value) {
                    if(angular.isUndefined(value))return;
                    var stats       = value.stats;
                    var head_stats  = value.head_stats;
                    var data        = new google.visualization.DataTable();
                    var g_height      = 160;
                    var g_width       = 'auto';

                    if(angular.isDefined($attr.height)){g_height = $attr.height;}
                    if(angular.isDefined($attr.width)){g_width = $attr.width;}

                    angular.forEach(head_stats, function(val,key){
                        data.addColumn(val.type,val.value);
                    });

                    angular.forEach(stats, function (row,key) {
                        var p_arr = [];
                        angular.forEach(row,function(val,key){
                            p_arr.push(val);
                        });
                        data.addRow(p_arr);
                    });

                    var color_set = ['#ed6d49', '#0daed3', '#ffb400', '#74b749', '#f63131'];
                    var options = {
                        height: g_height,
                        width: g_width,
                        backgroundColor: 'transparent',
                        colors: color_set,
                        tooltip: {
                            textStyle: {
                                color: '#666666',
                                fontSize: 11
                            },
                            showColorCode: true
                        },
                        legend: {
                            textStyle: {
                                color: 'black',
                                fontSize: 12
                            },
                            position: 'right', maxLines: 4
                        },
                        chartArea: {
                            left: 60,
                            top: 10,
                            height: '80%'
                        },
                        vAxis: {
                            baseline: 0
                        }
                    };
                    var chart;
                    switch ($attr.type) {
                        case ('PieChart'):
                            chart = new google.visualization.PieChart($elm[0]);
                            break;
                        case ('ColumnChart'):
                            chart = new google.visualization.ColumnChart($elm[0]);
                            break;
                        case ('BarChart'):
                            chart = new google.visualization.BarChart($elm[0]);
                            break;
                        case ('Table'):
                            chart = new google.visualization.Table($elm[0]);
                            break;
                    }
                    chart.draw(data, options);
                });
            }
        }
});