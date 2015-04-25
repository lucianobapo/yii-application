<?php

class Helpers {

	public static function cloudFront(){
		if (!class_exists('S3')) require_once 'S3.php';

// AWS access info
		if (!defined('awsAccessKey')) define('awsAccessKey', '');
		if (!defined('awsSecretKey')) define('awsSecretKey', '');


// Check for CURL
		if (!extension_loaded('curl') && !@dl(PHP_SHLIB_SUFFIX == 'so' ? 'curl.so' : 'php_curl.dll'))
			exit("\nERROR: CURL extension not loaded\n\n");

// Pointless without your keys!
		if (awsAccessKey == 'change-this' || awsSecretKey == 'change-this')
			exit("\nERROR: AWS access information required\n\nPlease edit the following lines in this file:\n\n".
				"define('awsAccessKey', 'change-me');\ndefine('awsSecretKey', 'change-me');\n\n");


		S3::setAuth(awsAccessKey, awsSecretKey);


		function test_createDistribution($bucket, $cnames = array()) {
			if (($dist = S3::createDistribution($bucket, true, $cnames, 'New distribution created')) !== false) {
				echo "createDistribution($bucket): "; var_dump($dist);
			} else {
				echo "createDistribution($bucket): Failed to create distribution\n";
			}
		}

		function test_listDistributions() {
			if (($dists = S3::listDistributions()) !== false) {
				if (sizeof($dists) == 0) echo "listDistributions(): No distributions\n";
				foreach ($dists as $dist) {
					var_dump($dist);
				}
			} else {
				echo "listDistributions(): Failed to get distribution list\n";
			}
		}

		function test_updateDistribution($distributionId, $enabled = false, $cnames = array()) {
			// To enable/disable a distribution configuration:
			if (($dist = S3::getDistribution($distributionId)) !== false) {
				$dist['enabled'] = $enabled;
				$dist['comment'] = $enabled ? 'Enabled' : 'Disabled';
				if (!isset($dist['cnames'])) $dist['cnames'] = array();
				foreach ($cnames as $cname) $dist['cnames'][$cname] = $cname;

				echo "updateDistribution($distributionId): "; var_dump(S3::updateDistribution($dist));
			} else {
				echo "getDistribution($distributionId): Failed to get distribution information for update\n";
			}
		}

		function test_deleteDistribution($distributionId) {
			// To delete a distribution configuration you must first set enable=false with
			// the updateDistrubution() method and wait for status=Deployed:
			if (($dist = S3::getDistribution($distributionId)) !== false) {
				if ($dist['status'] == 'Deployed') {
					echo "deleteDistribution($distributionId): "; var_dump(S3::deleteDistribution($dist));
				} else {
					echo "deleteDistribution($distributionId): Distribution not ready for deletion (status is not 'Deployed')\n";
					var_dump($dist);
				}
			}
		}


	}

	public function initS3(){
		if (!class_exists('S3')) require_once 'S3.php';

// AWS access info
		if (!defined('awsAccessKey')) define('awsAccessKey', '');
		if (!defined('awsSecretKey')) define('awsSecretKey', '');

		$uploadFile = dirname(__FILE__).'/S3.php'; // File to upload, we'll use the S3 class since it exists
		$bucketName = uniqid('delivery-imagens'); // Temporary bucket

// If you want to use PECL Fileinfo for MIME types:
//if (!extension_loaded('fileinfo') && @dl('fileinfo.so')) $_ENV['MAGIC'] = '/usr/share/file/magic';


// Check if our upload file exists
		if (!file_exists($uploadFile) || !is_file($uploadFile))
			exit("\nERROR: No such file: $uploadFile\n\n");

// Check for CURL
		if (!extension_loaded('curl') && !@dl(PHP_SHLIB_SUFFIX == 'so' ? 'curl.so' : 'php_curl.dll'))
			exit("\nERROR: CURL extension not loaded\n\n");

// Pointless without your keys!
		if (awsAccessKey == 'change-this' || awsSecretKey == 'change-this')
			exit("\nERROR: AWS access information required\n\nPlease edit the following lines in this file:\n\n".
				"define('awsAccessKey', 'change-me');\ndefine('awsSecretKey', 'change-me');\n\n");

// Instantiate the class
		$s3 = new S3(awsAccessKey, awsSecretKey);

// List your buckets:
		echo "S3::listBuckets(): ".print_r($s3->listBuckets(), 1)."\n";


// Create a bucket with public read access
		if ($s3->putBucket($bucketName, S3::ACL_PUBLIC_READ)) {
			echo "Created bucket {$bucketName}".PHP_EOL;

			// Put our file (also with public read access)
			if ($s3->putObjectFile($uploadFile, $bucketName, baseName($uploadFile), S3::ACL_PUBLIC_READ)) {
				echo "S3::putObjectFile(): File copied to {$bucketName}/".baseName($uploadFile).PHP_EOL;


				// Get the contents of our bucket
				$contents = $s3->getBucket($bucketName);
				echo "S3::getBucket(): Files in bucket {$bucketName}: ".print_r($contents, 1);


				// Get object info
				$info = $s3->getObjectInfo($bucketName, baseName($uploadFile));
				echo "S3::getObjectInfo(): Info for {$bucketName}/".baseName($uploadFile).': '.print_r($info, 1);


				// You can also fetch the object into memory
				// var_dump("S3::getObject() to memory", $s3->getObject($bucketName, baseName($uploadFile)));

				// Or save it into a file (write stream)
				// var_dump("S3::getObject() to savefile.txt", $s3->getObject($bucketName, baseName($uploadFile), 'savefile.txt'));

				// Or write it to a resource (write stream)
				// var_dump("S3::getObject() to resource", $s3->getObject($bucketName, baseName($uploadFile), fopen('savefile.txt', 'wb')));



				// Get the access control policy for a bucket:
				// $acp = $s3->getAccessControlPolicy($bucketName);
				// echo "S3::getAccessControlPolicy(): {$bucketName}: ".print_r($acp, 1);

				// Update an access control policy ($acp should be the same as the data returned by S3::getAccessControlPolicy())
				// $s3->setAccessControlPolicy($bucketName, '', $acp);
				// $acp = $s3->getAccessControlPolicy($bucketName);
				// echo "S3::getAccessControlPolicy(): {$bucketName}: ".print_r($acp, 1);


				// Enable logging for a bucket:
				// $s3->setBucketLogging($bucketName, 'logbucket', 'prefix');

				// if (($logging = $s3->getBucketLogging($bucketName)) !== false) {
				// 	echo "S3::getBucketLogging(): Logging for {$bucketName}: ".print_r($contents, 1);
				// } else {
				// 	echo "S3::getBucketLogging(): Logging for {$bucketName} not enabled\n";
				// }

				// Disable bucket logging:
				// var_dump($s3->disableBucketLogging($bucketName));


				// Delete our file
				if ($s3->deleteObject($bucketName, baseName($uploadFile))) {
					echo "S3::deleteObject(): Deleted file\n";

					// Delete the bucket we created (a bucket has to be empty to be deleted)
					if ($s3->deleteBucket($bucketName)) {
						echo "S3::deleteBucket(): Deleted bucket {$bucketName}\n";
					} else {
						echo "S3::deleteBucket(): Failed to delete bucket (it probably isn't empty)\n";
					}

				} else {
					echo "S3::deleteObject(): Failed to delete file\n";
				}
			} else {
				echo "S3::putObjectFile(): Failed to copy file\n";
			}
		} else {
			echo "S3::putBucket(): Unable to create bucket (it may already exist and/or be owned by someone else)\n";
		}
	}

	public static function getThumbnail($img=null){
		if ( ($img==null) || (substr($img,-4)!='.png') ) return false;
		$new_img=substr($img,0,-4).'-thumb.png';
		if (file_exists($_SERVER['DOCUMENT_ROOT'].$new_img)) return $new_img;
		if (file_exists($_SERVER['DOCUMENT_ROOT'].$img)) {
			$image = new SimpleImage();
			$image->load($_SERVER['DOCUMENT_ROOT'].$img);
			$image->resizeToWidth(60);
			//$image->output();
			//$new_img=substr($img,0,-4).'-thumb.png';
			$image->save($_SERVER['DOCUMENT_ROOT'].$new_img,IMAGETYPE_PNG);
			return $new_img;
		} else return false;

	}


	/**
	 * @param $sugestao
	 * @return bool
     */
	public static function enviaSugestao($sugestao){
		$msg='Usuário: '.Yii::app()->user->name."<br>\n";
		$msg=$msg.'Horário: '.date('d/m/Y H:i:s')."<br>\n";
		$msg=$msg.'Local: '.Yii::app()->getController()->pageTitle."<br>\n";
		$msg=$msg."Mensagem: $sugestao<br>\n";
		$subject='=?UTF-8?B?'.base64_encode('Sugestão - '.Yii::app()->name).'?=';
		return self::sendMail(array('email'=>Yii::app()->params['adminEmail'],'name'=>Yii::app()->user->name),
			$subject,$msg);
	}


	public static function sendSms() {
		//stub
	}

	public static function registraErro($erro) {
		if (isset(Yii::app()->user->dados)) $msg='Usuário: '.Yii::app()->user->dados['displayName']."<br>\n";
		else $msg='Usuário: '.Yii::app()->user->name."<br>\n";

		$msg=$msg.'Horário: '.date('d/m/Y H:i:s')."<br>\n";
		$msg=$msg.'Local: '.Yii::app()->getController()->pageTitle."<br>\n";
		$msg=$msg."Mensagem: <br>\n";
		foreach ($erro as $key => $value)
			foreach ($value as $id => $txt)
				$msg=$msg.$txt."<br>\n";
		$subject='=?UTF-8?B?'.base64_encode('Erro no site - '.Yii::app()->name).'?=';
		self::sendMail(array('email'=>Yii::app()->params['adminEmail'],'name'=>Yii::app()->user->name),$subject,$msg);
			
	}
	
	public static function gravaArquivoErro($erro) {
		Yii::trace("Grava arquivo de erro: ".$erro,'application.delivery.arquivoErro');
		/*
		$msg='Usuário: '.Yii::app()->user->name."<br>\n";
		$msg=$msg.'Horário: '.date('d/m/Y H:i:s')."<br>\n";
		$msg=$msg.'Local: '.Yii::app()->getController()->pageTitle."<br>\n";
		$msg=$msg."Erro: $erro<br>\n";
		
		if ($f = fopen($_SERVER['DOCUMENT_ROOT'].'/protected/data/'.date('Ymd').'-erro.txt', 'a')) {
			fwrite($f, "\n".$msg."\n");
			fclose($f);
			return true;
		} else return false;*/
	}
	
	public static function setFlash($tipo,$mensagem){
		if ($tipo=='erro') {
			//Log de evento
			$msg='Erro: '.Yii::app()->name.' - '.date('d/m/Y H:i:s').
				".<br>\nSite: ".$_SERVER['HTTP_HOST'].
				".<br>\nLocal: ".Yii::app()->getController()->pageTitle.
				".<br>\nMensagem: ".$mensagem;
			Yii::log($msg,CLogger::LEVEL_ERROR,'application.delivery');

			$msg='Usuário: '.Yii::app()->user->name."<br>\n";
			$msg=$msg.'Horário: '.date('d/m/Y H:i:s')."<br>\n";
			$msg=$msg.'Local: '.Yii::app()->getController()->pageTitle."<br>\n";
			$msg=$msg.'Mensagem: '.$mensagem."<br>\n";
			self::sendMail(array('email'=>Yii::app()->params['adminEmail'],'name'=>Yii::app()->user->name),'Erro no site',$msg);
			
		}
		return Yii::app()->user->setFlash($tipo,$mensagem);
	}
	
	public static function t($category,$message,$params=array(),$source='i18n',$language=null,$converte=true,$utf8=false){
		//if (($cache=Yii::app()->getComponent('cache'))!==null )
		if (is_array($params))
			foreach ($params as $key=>$value)
				$params[$key]=utf8_decode($value);

		$original=Yii::t($category,$message,$params,$source,$language);
		//if (mb_detect_encoding($original)=='UTF-8') $original=utf8_encode($original);

		//return htmlentities(Yii::t($category,$message,$params,$source,$language),ENT_COMPAT,'UTF-8',false);
		//return mb_detect_encoding (Yii::t($category,$message,$params,$source,$language));
		//return $original.mb_detect_encoding($original).htmlentities(($original),ENT_COMPAT,'UTF-8',false);
		if ($converte) $original= htmlentities(($original),ENT_COMPAT,'UTF-8',false);
		if ($utf8) $original= utf8_encode($original);
		return $original;

	}
	
	public static function getQuoteBRL($timestamp,$currency='USD',$i=1){
		/*
		 0-Data
		1-Cod Moeda
		2-Tipo
		3-Moeda
		4-Taxa Compra
		5-Taxa Venda
		6-Paridade Compra
		7-Paridade Venda
		*/
		$arquivo=$_SERVER['DOCUMENT_ROOT'].'/protected/data/'.date('Ymd',$timestamp).'.csv';
		if (file_exists ($arquivo)) {
			if (!$f = fopen($arquivo, 'r')) return utf8_encode('Erro ao abrir o arquivo');
			while (!feof($f)) {
				$linha = fgetcsv($f, 0, ';', '"');
				if ($linha[3]==$currency) {
					fclose($f);
					return utf8_encode($linha[0].': '.$linha[3].'='.$linha[4].'/1,00 BRL');
				}
			}
			fclose($f);
			return utf8_encode('Moeda '.$currency.' não encontrada no Banco Central. Dia '.date('d/m/Y',$timestamp));
		} elseif ($i<4) {
			$i++;		
			return Helpers::getQuoteBRL(strtotime("-1 day",$timestamp),$currency,$i);
		}else return utf8_encode('Arquivo não encontrado até a data '.date('d/m/Y',$timestamp));
	}
	
	public static function getQuote($timestamp,$currency='USD',$i=1){
		/*
		 0-Data
		1-Cod Moeda
		2-Tipo
		3-Moeda
		4-Taxa Compra
		5-Taxa Venda
		6-Paridade Compra
		7-Paridade Venda
		*/
		$arquivo=$_SERVER['DOCUMENT_ROOT'].'/protected/data/'.date('Ymd',$timestamp).'.csv';
		if (file_exists ($arquivo)) {
			if (!$f = fopen($arquivo, 'r')) return 1;
			while (!feof($f)) {
				$linha = fgetcsv($f, 0, ';', '"');
				if ($linha[3]==$currency) {
					fclose($f);
					return str_replace(',', '.', $linha[4]);//Yii::app()->numberFormatter->formatCurrency($linha[4],'');
				}
			}
			fclose($f);
			return 1;
		} elseif ($i<4) {
			$i++;
			return Helpers::getQuote(strtotime("-1 day",$timestamp),$currency,$i);
		}else return 1;
	}

	/**
	 * @param array $to
	 * @param string $subject
	 * @param string $msg
	 * @param string $erro
	 * @param array $headers
	 * @return bool
     */
	public static function sendMail($to=array(),$subject='Blank e-mail',$msg='Blank e-mail',&$erro='',$headers=array()){
		if (self::isOnline()) {
			$mail=Yii::app()->Smtpmail;
			$mail->AddBCC(Yii::app()->params['adminEmail'], Yii::app()->name);
			$mail->AddBCC(Yii::app()->params['adminEmail2'], Yii::app()->name);
			$mail->SetFrom(Yii::app()->params['adminEmail'],  Yii::app()->name);
			$mail->Subject=$subject;
			$mail->MsgHTML($msg);
			$mail->AddAddress($to['email'], $to['name']);

			foreach ($headers as $value) {
				$mail->AddCustomHeader($value);
			}

			if (!$mail->Send()) {
				//$erro=$mail->ErrorInfo;
                self::gravaArquivoErro($mail->ErrorInfo);

				return false;
			} else return true;
		} else {
			Yii::trace("Envio de e-mail: ".
				Yii::app()->name.' - '.date('d/m/Y H:i:s').".<br>\nSite: ".$_SERVER['HTTP_HOST'].
				"\n".$to['email']."\n".$to['name']."\n".$subject."\n".$msg
				,'application.delivery.email');
			return true;
		}
			/*
			if ($f = fopen($_SERVER['DOCUMENT_ROOT'].'/protected/data/'.date('Ymd').'.txt', 'a')) {
			fwrite($f, $erro."\n".$to['email']."\n".$to['name']."\n".$subject."\n".$msg);
			fclose($f);
			return true;
		} else return false;*/
	}

	public static function getFacebookLike($tipo){
		if (!Yii::app()->params['boxSocial']) return '';
		if ($tipo=='script'){
			//return '<div id="fb-root"></div><script>(function(d, s, id) {  var js, fjs = d.getElementsByTagName(s)[0];  if (d.getElementById(id)) return;  js = d.createElement(s); js.id = id;  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId=1581785262035600&version=v2.0";  fjs.parentNode.insertBefore(js, fjs);}(document, \'script\', \'facebook-jssdk\'));</script>';
            return '<div id="fb-root"></div>';
		} elseif($tipo=='botao') {
			return '<div class="fb-like" data-href="'.Yii::app()->params['appSiteURL'].'" data-layout="box_count" data-action="like" data-show-faces="true" data-share="true"></div>';
		} elseif($tipo=='botao2') {
			return '<div class="fb-like" data-href="'.Yii::app()->params['appSiteURL'].'" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>';
		}
	}

	public static function getGoogleLike($tipo){
		if (!Yii::app()->params['boxSocial']) return '';
		if ($tipo=='script'){
			return '<script src="https://apis.google.com/js/platform.js" async defer> {lang: \'pt-BR\'} </script>';
		} elseif($tipo=='botao'){
			return '<div class="g-plusone" data-size="medium" data-href="'.Yii::app()->params['appSiteURL'].'"></div>';
		} elseif($tipo=='botao2'){
			return '<div class="g-plusone" data-size="small" data-annotation="inline" data-width="162" data-href="'.Yii::app()->params['appSiteURL'].'"></div>';
		}
	}


	public static function getGoogleAnalytics(){
		if ((Helpers::isOnline())&&(Yii::app()->params['GoogleAnalytics']))
			if (Yii::app ()->user->isGuest)
				echo Yii::app()->params['GoogleAnalyticsCode'];
			else {
				$aux=explode(';',Yii::app()->params['GoogleAnalyticsCode']);
				$aux2=$aux[count($aux)-2];
				$aux[count($aux)-2]="\n	ga('set', '&uid', '".Yii::app ()->user->id."')";
				$aux3=$aux[count($aux)-1];
				$aux[count($aux)-1]=$aux2;
				array_push($aux,$aux3);
				$aux=implode(';',$aux);
				//$aux[count($aux)];

				//die ('<pre>'.CVarDumper::dumpAsString(Yii::app()->params['GoogleAnalyticsCode'].$aux).'</pre>');
				//die ('<pre>'.CVarDumper::dumpAsString($aux).'</pre>');
				echo $aux;
			}
	}

	public static function getMenu(){
		//self::$errors = array();
		//$menu = new HelpersDynamic();
		//return $menu->renderMenu();
		return Yii::app()->menu->renderMenu();
	}


	
	public static function getModuleName() {
		if (strpos ( $_SERVER ['HTTP_HOST'], '.' ) === false)
			return '';
		$module = explode ( '.', $_SERVER ['HTTP_HOST'] );
		if ($module [0]=='www') $module [0]=$module [1];
		if (! isset ( Yii::app ()->modules [$module [0]] ))
			return '';
		else
			return $module [0];
	}

	/**
	 * @return bool
     */
	public static function isOnline() {
		return !strpos ( $_SERVER ['HTTP_HOST'], 'localhost' );		
	}
	
	
	
	/**
	 * Valida CNPJ
	 *
	 * @author Luiz Ot�vio Miranda <contato@tutsup.com>
	 * @param string $cnpj
	 * @return bool true para CNPJ correto
	 *
	 */
	public static function valida_cnpj ( $cnpj ) {
		// Deixa o CNPJ com apenas n�meros
		$cnpj = preg_replace( '/[^0-9]/', '', $cnpj );
	
		// Garante que o CNPJ � uma string
		$cnpj = (string)$cnpj;
	
		// O valor original
		$cnpj_original = $cnpj;
	
		// Captura os primeiros 12 n�meros do CNPJ
		$primeiros_numeros_cnpj = substr( $cnpj, 0, 12 );
	
		/**
		 * Multiplica��o do CNPJ
		 *
		 * @param string $cnpj Os digitos do CNPJ
		 * @param int $posicoes A posi��o que vai iniciar a regress�o
		 * @return int O
		 *
		*/
		function multiplica_cnpj( $cnpj, $posicao = 5 ) {
			// Vari�vel para o c�lculo
			$calculo = 0;
	
			// La�o para percorrer os item do cnpj
			for ( $i = 0; $i < strlen( $cnpj ); $i++ ) {
				// C�lculo mais posi��o do CNPJ * a posi��o
				$calculo = $calculo + ( $cnpj[$i] * $posicao );
					
				// Decrementa a posi��o a cada volta do la�o
				$posicao--;
					
				// Se a posi��o for menor que 2, ela se torna 9
				if ( $posicao < 2 ) {
					$posicao = 9;
				}
			}
			// Retorna o c�lculo
			return $calculo;
		}
	
		// Faz o primeiro c�lculo
		$primeiro_calculo = multiplica_cnpj( $primeiros_numeros_cnpj );
	
		// Se o resto da divis�o entre o primeiro c�lculo e 11 for menor que 2, o primeiro
		// D�gito � zero (0), caso contr�rio � 11 - o resto da divis�o entre o c�lculo e 11
		$primeiro_digito = ( $primeiro_calculo % 11 ) < 2 ? 0 :  11 - ( $primeiro_calculo % 11 );
	
		// Concatena o primeiro d�gito nos 12 primeiros n�meros do CNPJ
		// Agora temos 13 n�meros aqui
		$primeiros_numeros_cnpj .= $primeiro_digito;
	
		// O segundo c�lculo � a mesma coisa do primeiro, por�m, come�a na posi��o 6
		$segundo_calculo = multiplica_cnpj( $primeiros_numeros_cnpj, 6 );
		$segundo_digito = ( $segundo_calculo % 11 ) < 2 ? 0 :  11 - ( $segundo_calculo % 11 );
	
		// Concatena o segundo d�gito ao CNPJ
		$cnpj = $primeiros_numeros_cnpj . $segundo_digito;
	
		// Verifica se o CNPJ gerado � id�ntico ao enviado
		if ( $cnpj === $cnpj_original ) {
			return true;
		}
	}
	
	/**
	 * Valida CPF
	 *
	 * @author Luiz Ot�vio Miranda <contato@tutsup.com>
	 * @param string $cpf O CPF com ou sem pontos e tra�o
	 * @return bool True para CPF correto - False para CPF incorreto
	 *
	 */
	public static function valida_cpf( $cpf = false ) {
		// Exemplo de CPF: 025.462.884-23
	
		/**
		 * Multiplica d�gitos vezes posi��es
		 *
		 * @param string $digitos Os digitos desejados
		 * @param int $posicoes A posi��o que vai iniciar a regress�o
		 * @param int $soma_digitos A soma das multiplica��es entre posi��es e d�gitos
		 * @return int Os d�gitos enviados concatenados com o �ltimo d�gito
		 *
		 */
		function calc_digitos_posicoes( $digitos, $posicoes = 10, $soma_digitos = 0 ) {
			// Faz a soma dos d�gitos com a posi��o
			// Ex. para 10 posi��es:
			//   0    2    5    4    6    2    8    8   4
			// x10   x9   x8   x7   x6   x5   x4   x3  x2
			// 	 0 + 18 + 40 + 28 + 36 + 10 + 32 + 24 + 8 = 196
			for ( $i = 0; $i < strlen( $digitos ); $i++  ) {
				$soma_digitos = $soma_digitos + ( $digitos[$i] * $posicoes );
				$posicoes--;
			}
	
			// Captura o resto da divis�o entre $soma_digitos dividido por 11
			// Ex.: 196 % 11 = 9
			$soma_digitos = $soma_digitos % 11;
	
			// Verifica se $soma_digitos � menor que 2
			if ( $soma_digitos < 2 ) {
				// $soma_digitos agora ser� zero
				$soma_digitos = 0;
			} else {
				// Se for maior que 2, o resultado � 11 menos $soma_digitos
				// Ex.: 11 - 9 = 2
				// Nosso d�gito procurado � 2
				$soma_digitos = 11 - $soma_digitos;
			}
	
			// Concatena mais um d�gito aos primeiro nove d�gitos
			// Ex.: 025462884 + 2 = 0254628842
			$cpf = $digitos . $soma_digitos;
	
			// Retorna
			return $cpf;
		}
	
		// Verifica se o CPF foi enviado
		if ( ! $cpf ) {
			return false;
		}
	
		// Remove tudo que n�o � n�mero do CPF
		// Ex.: 025.462.884-23 = 02546288423
		$cpf = preg_replace( '/[^0-9]/is', '', $cpf );
	
		// Verifica se o CPF tem 11 caracteres
		// Ex.: 02546288423 = 11 n�meros
		if ( strlen( $cpf ) != 11 ) {
			return false;
		}
	
		// Captura os 9 primeiros d�gitos do CPF
		// Ex.: 02546288423 = 025462884
		$digitos = substr($cpf, 0, 9);
	
		// Faz o c�lculo dos 9 primeiros d�gitos do CPF para obter o primeiro d�gito
		$novo_cpf = calc_digitos_posicoes( $digitos );
	
		// Faz o c�lculo dos 10 d�gitos do CPF para obter o �ltimo d�gito
		$novo_cpf = calc_digitos_posicoes( $novo_cpf, 11 );
	
		// Verifica se o novo CPF gerado � id�ntico ao CPF enviado
		if ( $novo_cpf === $cpf ) {
			// CPF v�lido
			return true;
		} else {
			// CPF inv�lido
			return false;
		}
	}
	
	
	public static function login_social(&$haComp) {
		$haComp = new HybridAuthIdentity();
		if (!$haComp->validateProviderName($_GET['provider']))
			throw new CHttpException ('500', 'Invalid Action. Please try again.');
		
		//$haComp->adapter = $haComp->hybridAuth->authenticate($_GET['provider']);
		//$haComp->userProfile = $haComp->adapter->getUserProfile();

		if ($haComp->authenticate()){
			Yii::app()->user->login($haComp, 0);
			return true;
		} //else echo '<pre>'.CVarDumper::dumpAsString($haComp).'</pre>';
		
		
	}
}
