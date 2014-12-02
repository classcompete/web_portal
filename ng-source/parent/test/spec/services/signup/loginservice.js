'use strict';

describe('Service: signup/loginService', function () {

  // load the service's module
  beforeEach(module('ccompparentApp'));

  // instantiate service
  var signup/loginService;
  beforeEach(inject(function (_signup/loginService_) {
    signup/loginService = _signup/loginService_;
  }));

  it('should do something', function () {
    expect(!!signup/loginService).toBe(true);
  });

});
