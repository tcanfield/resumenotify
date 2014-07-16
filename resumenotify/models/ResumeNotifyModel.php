<?php

namespace Craft;

/**
*ResumeNotify Model
*/
class ResumeNotifyModel extends BaseModel{

	/**
	*Attributes of the ResumeNotifyModel
	*Used to store the values of all employment form data entered.
	*
	*@return array for storing the information sent from the employment form.
	*/
	protected function defineAttributes(){
	
		return array( 'fullname' => array(AttributeType::String, 'label' => 'title'),
						  'phone'    => array(AttributeType::String, 'label' => 'emp_phone'),
					 	  'email'	  => array(AttributeType::Email, 'label' => 'emp_email'),
				 		  'website'  => array(AttributeType::String, 'label' => 'emp_website'),
						  'notes'    => array(AttributeType::String, 'label' => 'emp_notes'),
						  'fields'    => array(AttributeType::String, 'label' => 'fields'),
						  'resume'   => AttributeType::Mixed,
			  			  //body will store the above data in a string to send in the email body.
						  'body' => '', 
						);
	
	}


}