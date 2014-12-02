'use strict';

describe('Directive: mainNavigation', function () {

  // load the directive's module
  beforeEach(module('ccompparentApp'));

  var element,
    scope;

  beforeEach(inject(function ($rootScope) {
    scope = $rootScope.$new();
  }));

  it('should make hidden element visible', inject(function ($compile) {
    element = angular.element('<main-navigation></main-navigation>');
    element = $compile(element)(scope);
    expect(element.text()).toBe('this is the mainNavigation directive');
  }));
});
