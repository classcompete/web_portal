angular.module('resources.parent-students',['ngResource']);

var ParentStudents = function($resource, ENV){

    var p_students = $resource(ENV.url + '/parent_student',{},{});

    return p_students;
};

ParentStudents.$inject = ['$resource','ENV'];
angular.module('resources.parent-students').factory('ParentStudentsFactory', ParentStudents);