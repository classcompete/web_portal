'use strict';

describe('Service: signup/registerfactory', function () {

  // load the service's module
  beforeEach(module('ccompparentApp'));

  // instantiate service
  var signup/registerfactory;
  beforeEach(inject(function (_signup/registerfactory_) {
    signup/registerfactory = _signup/registerfactory_;
  }));

  it('should do something', function () {
    expect(!!signup/registerfactory).toBe(true);
  });

});
