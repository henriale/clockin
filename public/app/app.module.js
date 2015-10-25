var app = angular.module('app', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

app.controller('SignupController', ['$scope', function ($scope) {
    $scope.register = function () {

    };

    $scope.passCheck = function () {
        var validity = false;

        if ($scope.passwordConfirmation === $scope.password)
            validity = true;

        $scope.formSignup.passwordConfirmation.$setValidity('passCheck', validity);

        return validity;
    };
}]);