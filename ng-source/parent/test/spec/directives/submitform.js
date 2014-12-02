'use strict';

describe('Directive: submitForm', function () {

  // load the directive's module
  beforeEach(module('ccompparentApp'));

  var element,
    scope;

  beforeEach(inject(function ($rootScope) {
    scope = $rootScope.$new();
  }));

  it('should make hidden element visible', inject(function ($compile) {
    element = angular.element('<submit-form></submit-form>');
    element = $compile(element)(scope);
    expect(element.text()).toBe('this is the submitForm directive');
  }));
});
