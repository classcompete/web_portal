'use strict';

describe('Service: ValidationValidation', function () {

  // load the service's module
  beforeEach(module('ccompparentApp'));

  // instantiate service
  var ValidationValidation;
  beforeEach(inject(function (_ValidationValidation_) {
    ValidationValidation = _ValidationValidation_;
  }));

  it('should do something', function () {
    expect(!!ValidationValidation).toBe(true);
  });

});
