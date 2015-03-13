'use strict';

var SetupStudentCtrl = function ($location, Security, grades, SetupStudentValidation, NotificationService, StudentsFactory, $q) {

    this.location = $location;
    this.security = Security;
    this.validation = SetupStudentValidation;
    this.notification = NotificationService;
    this.grades = grades;
    this.studentsFactory = StudentsFactory;
    this.$q = $q;
    this.students = [];
    this.defStudent = {
        rb: 1,
        firstName: '',
        lastName: '',
        birthday: '',
        grade: '',
        email: '',
        username: '',
        password: '',
        retypePassword: '',
        gender: ''
    };
//    this.defStudent1 = {rb:1,firstName:'Darko1',lastName:'Lazic1',birthday:'2009/04/08',grade:'6',email:'darko.student1@codeanvil.co',username:'darko-student-1',password:'asdasd',retypePassword:'asdasd',gender:'male'};
//    this.defStudent2 = {rb:1,firstName:'Darko2',lastName:'Lazic2',birthday:'2001/04/08',grade:'6',email:'darko.student2@codeanvil.co',username:'darko-student-2',password:'asdasd',retypePassword:'asdasd',gender:'female'};
    this.activeStudent = 1;
    this.countStudents = 1;
    this.countStudentsSelected = 1;
    this.gender = [{desc: 'female', name: 'Female'}, {desc: 'male', name: "Male"}];

    this.students.push(this.defStudent);
};
SetupStudentCtrl.prototype.setStudent = function ($count) {
    $count = parseInt($count);
    if (this.countStudents < $count) {
        while (this.countStudents < $count) {
            this.addStudent();
        }
    }

    if (this.countStudents > $count) {
        while (this.countStudents > $count) {
            this.removeStudent();
        }
    }
};

SetupStudentCtrl.prototype.addStudent = function () {
    this.countStudents++;
    this.students.push({
        rb: this.countStudents,
        firstName: '',
        lastName: '',
        birthday: '',
        grade: '',
        email: '',
        username: '',
        password: '',
        retypePassword: '',
        gender: ''
    });
};

SetupStudentCtrl.prototype.removeStudent = function () {
    this.countStudents--;
    this.students.splice(this.students.length - 1, 1)
};
SetupStudentCtrl.prototype.setActiveStudent = function (index) {
    this.activeStudent = index + 1;
};
SetupStudentCtrl.prototype.saveStudents = function () {
    var studentsLength = this.students.length, i = 0, self = this;

    for (i; i < studentsLength; i++) {
        if (this.validation.run(this.students[i]) === false) {
            this.notification.showMessage(this.validation.getErrors(), 'Student ' + (i + 1), 'error');
            return;
        }
    }

    this.studentsFactory.save(this.students).$promise.then(function () {
        self.location.path('/intro');
    });

};
SetupStudentCtrl.prototype.goToHome = function () {
    //this.security.setRole(3);
    this.location.path('/intro');
};

SetupStudentCtrl.resolve = {
    grades: ['GradesFactory', function (GradesFactory) {
        return GradesFactory.query();
    }]
};

SetupStudentCtrl.$inject = ['$location', 'Security', 'grades', 'SetupStudentValidation', 'NotificationService', 'StudentsFactory', '$q'];
angular.module('setupstudent').controller('SetupStudentCtrl', SetupStudentCtrl);