angular.module('resources.students',['ngResource']);

var Students = function($resource, ENV){

    var students = $resource(ENV.url + '/student',{},{
        edit:{method:'PUT',url:ENV.url + '/student/:id', params:{id:'@id'}},
        save:{method:'POST',url:ENV.url + '/student/new'},
        saveSingle:{method:'POST',url:ENV.url + '/student/single'},
        saveConnection:{method:'POST', url:ENV.url + '/student/connection'}
    });

    students.prototype.canEdit = function(){
        return (new Date().getFullYear() - new Date(this.birthday).getFullYear()) < 12;
    };

    return students;
};

Students.$inject = ['$resource','ENV'];
angular.module('resources.students').factory('StudentsFactory', Students);

var UnusedStudents = function($resource, ENV){

    var unusedStudents = $resource(ENV.url + '/free_student',{},{
    });

    unusedStudents.prototype.getFullName = function(){
        return this.firstName + ' ' + this.lastName;
    };

    return unusedStudents;
};

UnusedStudents.$inject = ['$resource','ENV'];
angular.module('resources.students').factory('UnusedStudentsFactory', UnusedStudents);