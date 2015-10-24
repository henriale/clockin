var app = angular.module('app', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

app.controller('SignupController', ['$scope', function ($scope) {
    $scope.user = {};

    $scope.register = function () {

    };

    $scope.passCheck = function () {
        var validity = false;

        if ($scope.user.passwordConfirmation === $scope.user.password)
            validity = true;

        $scope.formSignup.$setValidity('passCheck', validity);

        return validity;
    };
}]);