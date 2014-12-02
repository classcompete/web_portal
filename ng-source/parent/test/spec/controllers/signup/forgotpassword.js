'use strict';

describe('Controller: SignupForgotpasswordCtrl', function () {

  // load the controller's module
  beforeEach(module('ccompparentApp'));

  var SignupForgotpasswordCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    SignupForgotpasswordCtrl = $controller('SignupForgotpasswordCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
