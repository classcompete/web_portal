'use strict';

describe('Controller: ClasscodeCtrl', function () {

  // load the controller's module
  beforeEach(module('ccompparentApp'));

  var ClasscodeCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    ClasscodeCtrl = $controller('ClasscodeCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
