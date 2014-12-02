'use strict';

describe('Service: ValidationLoginvalidation', function () {

  // load the service's module
  beforeEach(module('ccompparentApp'));

  // instantiate service
  var ValidationLoginvalidation;
  beforeEach(inject(function (_ValidationLoginvalidation_) {
    ValidationLoginvalidation = _ValidationLoginvalidation_;
  }));

  it('should do something', function () {
    expect(!!ValidationLoginvalidation).toBe(true);
  });

});
