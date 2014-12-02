'use strict';

describe('Service: CommonNotificationservice', function () {

  // load the service's module
  beforeEach(module('ccompparentApp'));

  // instantiate service
  var CommonNotificationservice;
  beforeEach(inject(function (_CommonNotificationservice_) {
    CommonNotificationservice = _CommonNotificationservice_;
  }));

  it('should do something', function () {
    expect(!!CommonNotificationservice).toBe(true);
  });

});
