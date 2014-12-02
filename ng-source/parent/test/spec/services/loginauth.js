'use strict';

describe('Service: loginAuth', function () {

  // load the service's module
  beforeEach(module('ccompparentApp'));

  // instantiate service
  var loginAuth;
  beforeEach(inject(function (_loginAuth_) {
    loginAuth = _loginAuth_;
  }));

  it('should do something', function () {
    expect(!!loginAuth).toBe(true);
  });

});
