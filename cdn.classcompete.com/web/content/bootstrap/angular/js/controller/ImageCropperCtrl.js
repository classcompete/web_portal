angular.module('ccomp').controller('ImageCropperCtrl', function($scope, $rootScope, $modalInstance, ImageMakerResource, image_url, image_name){

    $scope.percent = '';
    $scope.files = [];
    $scope.uploadedImage = [];
    $scope.new_image = {};
    $scope.image_name = '';
    $scope.created_image = '';
    $scope.background_image_color = null;

    if(angular.isDefined(image_url) && angular.isDefined(image_name)){
        $scope.image = image_url;
        $scope.image_name = image_name
    }

    $scope.imageUploaded = function(){
        $scope.image = $rootScope.images_upload_url + $scope.uploadedImage[$scope.uploadedImage.length - 1].response;
        $scope.image_name = $scope.uploadedImage[$scope.uploadedImage.length - 1].response;
        $('.loading-spinner').fadeOut();
    };

    $scope.$watch(function(){
        $scope.background_image_color = angular.element('#background_color').val();
        if($scope.background_image_color !== null){
            $('#crop_image_wrapper').css('background-color',$scope.background_image_color);
        }
    });

    $scope.done = function(){
        $scope.new_image.image  =  $scope.image_name;
        $scope.new_image.x_axis =  angular.element('#crop_image').css('left').replace('px', '');
        $scope.new_image.y_axis =  angular.element('#crop_image').css('top').replace('px', '');
        $scope.new_image.width  =  angular.element('#crop_wrapper #crop_image_wrapper').css('width').replace('px', '');
        $scope.new_image.height =  angular.element('#crop_wrapper #crop_image_wrapper').css('height').replace('px', '');
        $scope.new_image.zoom   =  angular.element('#image_zoom_slider').data('slider').getValue();

        var background_color    = angular.element('#background_color').val();

        background_color =  background_color.replace("rgb(","");
        background_color = background_color.replace(')',"");

        var rgb = background_color.split(",");

        $scope.new_image.red = rgb[0];
        $scope.new_image.green = rgb[1];
        $scope.new_image.blue = rgb[2];

        ImageMakerResource.save($scope.new_image).$promise.then(function(data){
            $modalInstance.close(data.image);
        });
    };

    $scope.cancel = function(){
        $modalInstance.dismiss('close');
    };
});