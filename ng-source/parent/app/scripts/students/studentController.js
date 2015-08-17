'use strict';

var StudentCtrl = function(students, grades, StudentValidation, NotificationService, IMG, StudentsFactory, StudentConnectionValidation, ParentStudentsFactory, NavigationService){
    $(window).width() < 1024 ? NavigationService.showMainNav() : NavigationService.menu(1);
    this.imageUrl = IMG.url;
    this.studentsFactory = StudentsFactory;
    this.notification = NotificationService;
    this.students = students;
    this.grades = grades;
    this.validation = StudentValidation;
    this.studentConnectionValidation = StudentConnectionValidation;
    this.parentStudentFactory = ParentStudentsFactory;
    this.defStudent = {firstName:'',lastName:'',grade:'',email:'',username:'',password:'',retypePassword:'',gender:''};
    this.defStudentConnection = {username:'',password:''};
    this.newStudent = null;
    this.newStudentConnection = null;

    this.gender = [{id: 1, desc:'female',name:'Female'},{id:2, desc:'male',name:"Male"}];
    this.addStudentForm = false;
    this.addConnectionStudentForm = false;
    this.showAddStudentForm = false;
};

StudentCtrl.prototype.editStudent = function(student){
    var self = this;
    if(this.validation.run(student) === false){
        this.notification.showMessage(this.validation.getErrors(), 'Edit student', 'error');
        return;
    }

    student.$edit({id:student.studentId}).then(function(resp){
        self.notification.success('Student data was successfully updated','');
    });
};

StudentCtrl.prototype.addStudent = function(){
    var self = this;
    if(this.validation.run(this.newStudent) === false){
        this.notification.showMessage(this.validation.getErrors(),'Add student','error');
        return;
    }

    this.studentsFactory.saveSingle(this.newStudent).$promise.then(function(r){
        self.students.push(r);
        self.showAddStudentForm = false;
        self.newStudent = angular.copy(self.defStudent);
        self.notification.success('New student successfully added!');
    });

};

StudentCtrl.prototype.showStudentForm = function(type){
    if(type === "addNew"){
        this.addStudentForm = true;
        this.newStudent = angular.copy(this.defStudent);
    }
    else{
        this.addConnectionStudentForm = true;
        this.newStudentConnection = angular.copy(this.defStudentConnection);
    }
};
StudentCtrl.prototype.hideStudentForm = function(type){
    if(type === "addNew"){
        this.addStudentForm = false;
        this.newStudent = null;
    }
    else{
        this.addConnectionStudentForm = false;
        this.newStudentConnection = null;
    }
};

StudentCtrl.prototype.addStudentConnection = function(){
    var self = this;
    if(this.studentConnectionValidation.run(this.newStudentConnection) === false){
        this.notification.showMessage(this.studentConnectionValidation.getErrors(),'Add Student connection','error');
        return;
    }

    this.studentsFactory.saveConnection(this.newStudentConnection).$promise.then(function(r){
        self.students.push(r);
        self.addConnectionStudentForm = false;
        self.newStudentConnection = angular.copy(self.defStudentConnection);
        self.notification.success("New student successfully added!");
    });
};

StudentCtrl.resolve ={
    students: ['$q','StudentsFactory', function($q, StudentsFactory){
        var deferred = $q.defer();
        StudentsFactory.query().$promise.then(function(data){
            return deferred.resolve(data);
        });
        return deferred.promise;
    }],
    grades:['GradesFactory', function(GradesFactory){
        return GradesFactory.query();
    }]
};

StudentCtrl.$inject = ['students','grades','StudentValidation','NotificationService','IMG','StudentsFactory','StudentConnectionValidation','ParentStudentsFactory','NavigationService'];
angular.module('students').controller('StudentCtrl', StudentCtrl);