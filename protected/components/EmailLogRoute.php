<?php
/**
 * CEmailLogRoute class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CEmailLogRoute sends selected log messages to email addresses.
 *
 * The target email addresses may be specified via {@link setEmails emails} property.
 * Optionally, you may set the email {@link setSubject subject}, the
 * {@link setSentFrom sentFrom} address and any additional {@link setHeaders headers}.
 *
 * @property array $emails List of destination email addresses.
 * @property string $subject Email subject. Defaults to CEmailLogRoute::DEFAULT_SUBJECT.
 * @property string $sentFrom Send from address of the email.
 * @property array $headers Additional headers to use when sending an email.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package system.logging
 * @since 1.0
 */
class EmailLogRoute extends CEmailLogRoute
{
	/**
	 * Sends an email.
	 * @param string $email single email address
	 * @param string $subject email subject
	 * @param string $message email content
	 */
	protected function sendEmail($email,$subject,$message)
	{
		$headers=$this->getHeaders();
		if($this->utf8)
		{
			$headers[]="MIME-Version: 1.0";
			$headers[]="Content-Type: text/plain; charset=UTF-8";
			$subject='=?UTF-8?B?'.base64_encode($subject).'?=';
		}
		if(($from=$this->getSentFrom())!==null)
		{
			$matches=array();
			preg_match_all('/([^<]*)<([^>]*)>/iu',$from,$matches);
			if(isset($matches[1][0],$matches[2][0]))
			{
				$name=$this->utf8 ? '=?UTF-8?B?'.base64_encode(trim($matches[1][0])).'?=' : trim($matches[1][0]);
				$from=trim($matches[2][0]);
				$headers[]="From: {$name} <{$from}>";
			}
			else
				$headers[]="From: {$from}";
			$headers[]="Reply-To: {$from}";
		}
		//mail($email,$subject,$message,implode("\r\n",$headers));
		$erro='';
		Helpers::sendMail(array('email'=>$email,'name'=>'EmailLogRoute'),$subject,$message,$erro,$headers);
	}
}