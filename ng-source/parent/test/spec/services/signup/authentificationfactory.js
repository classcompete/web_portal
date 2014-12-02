'use strict';

describe('Service: signup/AuthentificationFactory', function () {

  // load the service's module
  beforeEach(module('ccompparentApp'));

  // instantiate service
  var signup/AuthentificationFactory;
  beforeEach(inject(function (_signup/AuthentificationFactory_) {
    signup/AuthentificationFactory = _signup/AuthentificationFactory_;
  }));

  it('should do something', function () {
    expect(!!signup/AuthentificationFactory).toBe(true);
  });

});
