angular.module('resources.credentials',['ngResource']);

var Credentials = function($resource, ENV){

    var credentials = $resource(ENV.url + '/forgot-credentials');


    return credentials;
};

Credentials.$inject = ['$resource','ENV'];
angular.module('resources.grades').factory('CredentialsFactory', Credentials);