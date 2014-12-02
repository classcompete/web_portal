'use strict';

describe('Service: ValidationRegistrvalidation', function () {

  // load the service's module
  beforeEach(module('ccompparentApp'));

  // instantiate service
  var ValidationRegistrvalidation;
  beforeEach(inject(function (_ValidationRegistrvalidation_) {
    ValidationRegistrvalidation = _ValidationRegistrvalidation_;
  }));

  it('should do something', function () {
    expect(!!ValidationRegistrvalidation).toBe(true);
  });

});
