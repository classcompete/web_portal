'use strict';

describe('Service: signup/registrationService', function () {

  // load the service's module
  beforeEach(module('ccompParentAppApp'));

  // instantiate service
  var signup/registrationService;
  beforeEach(inject(function (_signup/registrationService_) {
    signup/registrationService = _signup/registrationService_;
  }));

  it('should do something', function () {
    expect(!!signup/registrationService).toBe(true);
  });

});
