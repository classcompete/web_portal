'use strict';

describe('Controller: SignupForgotusernameCtrl', function () {

  // load the controller's module
  beforeEach(module('ccompparentApp'));

  var SignupForgotusernameCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    SignupForgotusernameCtrl = $controller('SignupForgotusernameCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
