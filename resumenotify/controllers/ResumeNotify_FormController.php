<?php
namespace Craft;

//Constants
define("SHOW_EMPTY_FIELDS", TRUE);  //Defines whether email should display blank fields or leave them out.

/**
*ResumeNotify Form Controller
*/
class ResumeNotify_FormController extends BaseController{
		
	
	/**
	*Gets the data from the form and stores it to the model variables
	*/
	public function actionGetForm(){
		$this->requirePostRequest();
			
		//Run GuestEntries Plugin to save the information
		craft()->runController('guestEntries/saveEntry');
	
	
		//Gather all form data
		$emp_form = new ResumeNotifyModel();
		
		$emp_form->fullname = craft()->request->getPost('title');
		$emp_form->phone = craft()->request->getPost('fields.emp_phone');
		$emp_form->email = craft()->request->getPost('fields.emp_email');
		$emp_form->website = craft()->request->getPost('fields.emp_website');
		$emp_form->notes = craft()->request->getPost('fields.emp_notes');
		
		$emp_form->resume = \CUploadedFile::getInstanceByName('fields[emp_resume]'); //??????????
		
		//Create a string for the body of the email.  <br />\n in case it is html or not html email.
		$body_name = "Full Name: " . $emp_form->fullname . "<br />\n";
		$body_phone = "Phone: " . $emp_form->phone . "<br />\n";
		$body_email = "Email: " . $emp_form->email . "<br />\n";
		$body_website = "Website: " . $emp_form->website . "<br />\n";
		$body_notes = "Notes: " . $emp_form->notes . "<br />\n";
		//Email will contain the title for fields even if left blank.
		if(constant("SHOW_EMPTY_FIELDS") === TRUE){
					$emp_form->body = $body_name .
								 			$body_phone . 
											$body_email . 
								 			$body_website .
								 			$body_notes 
											;
											
		} else{ //Else leave out any empty fields' labels. (Cleaner way to write this?)
					if($emp_form->fullname !== ""){
						$emp_form->body = $emp_form->body . $body_name;					
					}
					if($emp_form->phone !== ""){
						$emp_form->body = $emp_form->body . $body_phone;					
					}
					if($emp_form->email !== ""){
						$emp_form->body = $emp_form->body . $body_email;					
					}
					if($emp_form->website !== ""){
						$emp_form->body = $emp_form->body . $body_website;					
					}
					if($emp_form->notes !== ""){
						$emp_form->body = $emp_form->body . $body_notes;					
					}
		}
		
		//call service method to send notifications
		craft()->resumeNotify_notify->sendNotification($emp_form);
	}
}