<nav class="navbar navbar-default">
	<section id="navigation-main">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<?php
                //die ('<pre>'.CVarDumper::dumpAsString($this->action).'</pre>');
                //$this->getController;

                Yii::app()->menu->setController($this->id);
                if (is_object($this->action)) Yii::app()->menu->setAction($this->action->id);
                //die ('<pre>'.CVarDumper::dumpAsString(Yii::app()->menu).'</pre>');
                Yii::app()->menu->renderMenu();
                //Helpers::getMenu(); ?>
			</div>

		</div>
	</section>
</nav>