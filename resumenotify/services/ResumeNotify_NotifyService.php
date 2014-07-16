<?php
namespace Craft;

/**
*ResumeNotify Notify Service
*Used to send the email notification.
*/
class ResumeNotify_NotifyService extends 

BaseApplicationComponent{
	
	/**
	*Sends the email notification using the fromEmail and sender set in Craft Email Settings
	

*Sends to all emails entered in Resume Notify plugin settings.
	*
	*@param ResumeNotifyModel $form_data  The data from form submission 

gathered in the controller.
	*/
	public function sendNotification(ResumeNotifyModel $form_data){
		
		//Get the email address and message set in plugin settings page.
		$settings = craft()->plugins->getPlugin('resumenotify')->getSettings();
		

$emails_to_notify = $settings->eAddress;
		
		//create an array of addresses separating by the comma
		$addresses 

= explode(",", $emails_to_notify);
		
		
		$emailSettings = craft()->email->getSettings();
				
		//Iterate through emails, sending a notification to each.
		$email = new EmailModel();
		foreach($addresses 

as $key=>$value){
			
			if(strpos($value, '@') !== FALSE){//Email must have @.  What other checking can be done to ensure the address is valid? How can this be checked when creating the list of emails instead of now?
				
		

		//set all the email information
				$email->fromEmail = $emailSettings['emailAddress'];
				

$email->sender = $emailSettings['emailAddress'];
				$email->toEmail = $value;
				$email->subject = 'New Resume Submission: ' . $form_data->fullname;
				$email->body = $form_data->body;
				

//var_dump($form_data->resume);
//$criteria = craft()->elements->getCriteria(ElementType::Asset);
//$criteria->filename = 'bio.pdf';
//$resume = $criteria->find();
//var_dump($resume);
//var_dump($form_data->resume);

				if($form_data->resume){	
			$email->addAttachment($form_data->resume->getTempName(), 

$form_data->resume->getName(), 'base64', $form_data->resume->getType());
		}		}			
			

		//Try to send the email
		try{
			craft()->email->sendEmail($email);
		}catch(\phpmailerException $e){ //javascript message for too large file
			$maxFile = ini_get('upload_max_filesize');
			//echo $maxFile;
			echo '<script type="text/javascript">';
			echo "alert('Upload failed. Max file size: ' + '$maxFile' + '.'); ";
			echo '</script>';
			return;
		}			}
	craft()->runController('guestEntries/saveEntry');
		}
		


	}

