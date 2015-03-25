<script type="text/javascript">
	var app = angular.module('delivery', []);
    //var classFeedback='';
    //var classFeedbackShow=false;
	var produtos = [];
	var moduleItems = {
		hide: true,
		mostrarValor: false,
		mostrarAlerta: false

	};
	var painelTitle='';

	app.controller('SiteController', function($scope){
		//this.showSocialBox=<?php //echo (Helpers::isOnline() ? 'true':'false');?>;

        //$scope.classFeedback="has-success";
        //$scope.classFeedbackShow = true;
        /*
        $scope.classFeedback = function(){
            return classFeedback;
        }
        $scope.classFeedbackShow = function(){
            return classFeedbackShow;
        }//*/
/*
        $scope.changeClass = function(){
            if ($scope.class === "red")
                $scope.class = "blue";
            else
                $scope.class = "red";
        };*/
	});

	// partindo da idéia que já temos uma variável `app` definida como
	// modulo principal da nossa aplicação, criamos a diretiva:
	app.directive('numbersOnly', function () {
		return {
			// atribuímos em forma de classe css nesse caso
			restrict: 'C',
			link: function (scope, element, attrs) {
				// atribuímos o plugin jQuery ao parâmetro `element`
				// nesse caso, o element do DOM que foi bindado a diretiva
				element.keypress(function (e) {
					//if the letter is not digit then display error and don't type anything
					if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
						//$(element).tooltipster('content', myNewContent);
						$(element).tooltip({
							animation: true,//'fade',
							title: "<?php echo Helpers::t('appUi', 'Digite somente números',null,null,null,false);?>",
							//delay: 200,
							//theme: 'tooltipster-default',
							//touchDevices: false,
							trigger: 'manual'//'custom'
						});
						//$(element).tooltipster('content',"");
						$(element).tooltip('show');
						$(element).on('shown.bs.tooltip', function(){setTimeout(function () {$(element).tooltip('destroy');}, 2000);});
						//setTimeout(function () {$(element).tooltip('hide');}, 2000);
						return false;
					};
					if (this.value.length > (attrs.maxlength-1)) return false;
				});
			}
		}
	});

	app.directive('validaCpfCnpj', function () {
		return {
			// atribuímos em forma de classe css nesse caso
			restrict: 'C',
			link: function (scope, element, attrs) {
				// atribuímos o plugin jQuery ao parâmetro `element`
				// nesse caso, o element do DOM que foi bindado a diretiva
				element.blur(function(){
					if ( (this.value.length==11 && !valida_cpf(this.value)) || (this.value.length==14 && !valida_cnpj(this.value)) ) {
						$(element).tooltip({
							animation: true,
							title: "<?php echo Helpers::t('appUi', 'CPF/CNPJ Inválido!',null,null,null,false);?>",
							trigger: 'manual'
						});
						$(element).tooltip('show');
						$(element).on('shown.bs.tooltip', function(){setTimeout(function () {$(element).tooltip('destroy');}, 2000);});
						return false;
					};

				});
			}
		}
	});

	app.directive('dateOnly', function () {
		return {
			// atribuímos em forma de classe css nesse caso
			restrict: 'C',
			link: function (scope, element, attrs) {
				// atribuímos o plugin jQuery ao parâmetro `element`
				// nesse caso, o element do DOM que foi bindado a diretiva
				element.keypress(function (e) {
					//if the letter is not digit then display error and don't type anything
					if (e.which != 8 && e.which != 0 && (e.which < 47 || e.which > 57)) {
						$(element).tooltip({
							animation: true,
							title: "<?php echo Helpers::t('appUi', 'Digite somente números',null,null,null,false);?>",
							trigger: 'manual'
						});
						$(element).tooltip('show');
						$(element).on('shown.bs.tooltip', function(){setTimeout(function () {$(element).tooltip('destroy');}, 2000);});
						return false;
					};
					if (this.value.length > (attrs.maxlength-1)) return false;
				});
			}
		}
	});

	app.directive('payleven', function () {
		return {
			// atribuímos em forma de classe css nesse caso
			restrict: 'C',
			link: function (scope, element, attrs) {
				// atribuímos o plugin jQuery ao parâmetro `element`
				// nesse caso, o element do DOM que foi bindado a diretiva
				$(element).tooltip({
					animation: true,
					html: true,
					placement: 'right',
					title: "<?php echo Helpers::t('appUi','Maquina de Cartão payleven via celular. Recibo por email.') ?><img class='img-responsive' src='/images/payleven.png'>"
					//trigger: 'manual'
				});

			}
		}
	});

	app.directive('datetimepicker', function () {
		return {
			// atribuímos em forma de classe css nesse caso
			restrict: 'C',
			link: function (scope, element, attrs) {
				// atribuímos o plugin jQuery ao parâmetro `element`
				// nesse caso, o element do DOM que foi bindado a diretiva
				$(element).datetimepicker({
					//animation: true,
					//html: true,
					//placement: 'right',
					//title: "<?php //echo Helpers::t('appUi','Maquina de Cartão payleven via celular. Recibo por email.') ?><img class='img-responsive' src='/images/payleven.png'>"
					//trigger: 'manual'
				});

			}
		}
	});
	/*
	app.directive('initTooltipster', function () {
		return {
			// atribuímos em forma de classe css nesse caso
			restrict: 'C',
			link: function (scope, element, attrs) {
				// atribuímos o plugin jQuery ao parâmetro `element`
				// nesse caso, o element do DOM que foi bindado a diretiva

				element.tooltipster({
					animation: 'fade',
					delay: 200,
					theme: 'tooltipster-default',
					touchDevices: false,
					trigger: 'custom'
				});

			}
		}
	});
	 */
	app.directive('priceFormat', function () {
		return {
			// atribuímos em forma de classe css nesse caso
			restrict: 'C',
			link: function (scope, element, attrs) {
				// atribuímos o plugin jQuery ao parâmetro `element`
				// nesse caso, o element do DOM que foi bindado a diretiva
				element.priceFormat({
					prefix: '',
					centsSeparator: ',',
					thousandsSeparator: '.'
				});
			}
		}
	});

	app.directive('clickOnce', function($timeout) {
		return {
			restrict: 'A',
			link: function(scope, element, attrs) {
				var replacementText = attrs.clickOnce;

				element.bind('click', function() {
					window.onbeforeunload = null;
					$timeout(function() {
						if (replacementText) {
							element.html(replacementText);
							element.val(replacementText);
						}
						element.attr('disabled', true);
					}, 0);
				});
			}
		};
	});

	app.directive('enviar', function() {
		return {
			restrict: 'C',
			link: function(scope, element, attrs) {
				element.submit();
			}
		};
	});

	app.directive('confirma', function() {
		return {
			restrict: 'A',
			link: function(scope, element, attrs) {
				$( element ).ready(function(){

					$(":submit").click(function() {
						window.onbeforeunload = null;
					});

					window.onbeforeunload = function() {
						return attrs.confirma;
					};
				});
			}
		};
	});

	app.directive('verifica', function() {
		return {
			restrict: 'A',
			link: function(scope, element, attrs) {
				//$( document ).ready(function(){
				$( element ).ready(function(){
					var formObject = $(element);
					formObject.data('mudou', false);

					$( element ).change(function(){
						formObject.data('mudou', true);
					} );

					$(":submit").click(function() {
						window.onbeforeunload = null;
					});

					window.onbeforeunload = function() {
						if (formObject.data('mudou')) {
							return attrs.verifica;
						}
					};
				});
			}
		};
	});

	app.directive('productPanels', function() {
		return {
			restrict: 'E',
			//templateUrl: '/themes/delivery/views/layouts/product-panels.html',
			controller: function(){
				this.produtos = produtos;
				this.moduleItems = moduleItems;
				this.freteText="<?php echo Helpers::t('appUi', 'Frete Grátis',array(),'i18n',null,false);?>";
				this.painelTitle = painelTitle;

				this.textoIndisponivel = "<?php echo Helpers::t('appUi', 'Indisponível no momento',array(),'i18n',null,false);?>";
				this.tipo_classe='bloco';

				this.getClasse  = function() {
					return {
						//li: (this.tipo_classe=='bloco'? 'sb1 vb1':' sb4 col-md-6'),
						//div: (this.tipo_classe=='bloco'? '':' sb5 vb5'),
						//promocao: (this.tipo_classe=='bloco'? 'block-delivery-image-promocao':''),
						//pImagem: (this.tipo_classe=='bloco'? 'sb2 vb2':'sb7 vb7')
					};

				};
				this.altBreak  = function(x) {
					return x.replace(" ", "\n");
				};
			},
			controllerAs: 'painel'

		};
	});

	app.directive('carrinho', function() {
		return {
			restrict: 'E',
			templateUrl: '/themes/delivery/views/layouts/carrinho.php',
			link: function(scope, element, attrs) {
				//element.submit();
				//element.show();
				element.hide();

			},
			controller: function(){
				this.altText="<?php echo Helpers::t('appUi', 'Carrinho de Compras',array(),'i18n',null,false);?>";

				//this.carrinhoShow = carrinhoShow;
				//this.moduleItems = moduleItems;

				//this.textoValor = "<?php //echo Helpers::t('appUi', 'Por: ',array(),'i18n',null,false);?>";
				//this.textoValorOld = "<?php //echo Helpers::t('appUi', 'De: ',array(),'i18n',null,false);?>";
				//this.textoIndisponivel = "<?php //echo Helpers::t('appUi', 'Indisponível no momento',array(),'i18n',null,false);?>";



			},
			controllerAs: 'painel'

		};
	});
</script>