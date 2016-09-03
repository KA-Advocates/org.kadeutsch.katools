<?php
 
 
class CRM_CivirulesConditions_Created_Days_Ago extends CRM_Civirules_Condition {
	
	/**
	 * Method is mandatory, in this case no additional data input is required
	 * so it returns FALSE
	 *
	 * @param int $ruleConditionId
	 * @return bool
	 * @access public
	 */
	public function getExtraDataInputUrl($ruleConditionId) {
	  return FALSE;
	}


	/**
	 * Method is mandatory and checks if the condition is met
	 *
	 * @param CRM_Civirules_TriggerData_TriggerData $triggerData
	 * @return bool
	 * @access public
	 */
	public function isConditionValid(CRM_Civirules_TriggerData_TriggerData $triggerData)
	{
	  $contactId = $triggerData->getContactId();
	  
	  $params = array('contact_id' => $contactId, 'financial_type_id' => 1);
	  $contact = civicrm_api3('Contact', 'Get', $contributionParams);
	  
	  //TODO should check if the date when contact was created is older than XX days
	  
	  return FALSE;
	}
	

	/**
	 * Returns an array with required entity names
	 *
	 * @return array
	 * @access public
	 */
	public function requiredEntities() {
	  return array('Contribution');
	}
	
} 
 
 
return array (
  0 =>
    array (
      'name' => 'Civirules:Condition.CreatedDaysAgo',
      'entity' => 'CiviRuleCondition',
      'params' =>
        array (
          'version' => 3,
          'name' => 'created_days_ago',
          'label' => 'Contact created x days Ago',
          'class_name' => 'CRM_CivirulesConditions_Created_Days_Ago,
          'is_active' => 1
        ),
    ),
);

