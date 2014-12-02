'use strict';

describe('Controller: SetupstudentsCtrl', function () {

  // load the controller's module
  beforeEach(module('ccompparentApp'));

  var SetupstudentsCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    SetupstudentsCtrl = $controller('SetupstudentsCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
