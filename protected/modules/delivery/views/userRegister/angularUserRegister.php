<script type="text/javascript">
    app.controller('UserFormController', function($scope){
        $scope.change = function() {
            if (($scope.cpf.length==11)||($scope.cpf.length==14)) {
                if ($scope.cpf.length==11) {
                    if (valida_cpf($scope.cpf)) {
                        $scope.inputValid();
                    } else {
                        $scope.inputInvalid();
                    };
                };

                if ($scope.cpf.length==14) {
                    if (valida_cnpj($scope.cpf)) {
                        $scope.inputValid();
                    } else {
                        $scope.inputInvalid();
                    };
                };
            } else {
                $scope.inputNone();
            };
        };

        $scope.inputValid = function() {
            $scope.classFeedbackIcon="glyphicon glyphicon-ok form-control-feedback";
            $scope.classFeedback="has-success";
        };
        $scope.inputInvalid = function() {
            $scope.classFeedbackIcon="glyphicon glyphicon-remove form-control-feedback";
            $scope.classFeedback="has-error";
        };
        $scope.inputNone = function() {
            $scope.classFeedbackIcon="";
            $scope.classFeedback="";
        };
    });
</script>