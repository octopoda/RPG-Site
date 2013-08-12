<?php

/**
 * Main application class.
 */
final class Index {

    //const DEFAULT_PAGE = 'home';
    //const PAGE_DIR = '../page/';
    //const LAYOUT_DIR = '../layout/';

    private $wsAccessKey;
    private $wsGroupKey;
    private $wsAddress;
    private $numberOfErrors = 0;
    private $numberOfMembersReceivedFromADA = 0;
    private $numberOfMembersSavedtoDB = 0;
    private $memberUpdateBatchId = 0;
    private $errors;
    private $debugMode;

    /**
     * System config.
     */
    public function init() {
        // error reporting - all errors for development (ensure you have display_errors = On in your php.ini file)
        error_reporting(E_ALL | E_STRICT);
        mb_internal_encoding('UTF-8');
        set_exception_handler(array($this, 'handleException'));
        spl_autoload_register(array($this, 'loadClass'));
        // session
        session_start();
    }

    /**
     * Run the application!
     */
    public function run() {
        try{
            $this->debugMode = false;
            $this->importMembersFromADA();
        }
        catch(Exception $e){
            echo "Member import failed. Error details: " . $e->getMessage();
            die($e);
            $this->numberOfErrors++;
            array_push($this->errors, "An exception occurred. Exception details: " . $e->getMessage());
        }
        
        $this->LogErrorsToDatabase();
        $this->NotifySiteAdmin();
    }
    
    public function importMembersFromADA(){
        $this->echoMessage("importMembersFromADA() called.");
        
        $config = Config::getConfig("webservice");
        $this->wsAccessKey = $config['ADA_DMIS_AccessKey'];
        $this->wsGroupKey = $config['ADA_DMIS_GroupKey'];
        $this->wsAddress = $config['Webservice_Address'];
        $this->errors = array();
        
        if($this->validateAccessKey())
        {
            $membersFromDMIS = $this->getMembersFromADA();
            $this->numberOfMembersReceivedFromADA = count($membersFromDMIS);
            if($this->numberOfMembersReceivedFromADA > 0)
            {
                $this->updateMembersInDatabase($membersFromDMIS);
            }
            else
            {
                $this->numberOfErrors++;
                array_push($this->errors, "No members received from ADA DMIS.");
            }
        }
        else
        {
            $this->numberOfErrors++;
            array_push($this->errors, "Access key validation failed.");
        }
        
    }
    
    //Validates the web service access key.
    private function validateAccessKey(){
        $this->echoMessage("validateAccessKey() called.");        
        $wsClient = new SoapClient($this->wsAddress);
        $result = $wsClient->ValidateAccessKey(array('key' => $this->wsAccessKey));
        return $result->ValidateAccessKeyResult->Success;
    }
    
    //Makes a web service call to ADA DMIS and gets the current members.
    private function getMembersFromADA(){
        $this->echoMessage("getMembersFromADA() called."); 
        
        try{
            $accessKey = new stdClass();
            $accessKey->Value = $this->wsAccessKey . "df";
            
            $param = new stdClass();
            $param->AccessKey = $accessKey;
            $param->groupKey = $this->wsGroupKey;
            
            $wsClient = new SoapClient($this->wsAddress);
            $result = $wsClient->RetrieveGroupMembers($param);
            $returnObj = $result->RetrieveGroupMembersResult;
            $memberInfoArray = $returnObj->MemberInfo;
            /*for($i=0; $i<100; $i++)
            {
                $member = $memberInfoArray[$i];
                echo $member->CustNo . ", " . $member->FirstName . " " . $member->LastName . "</br>";
            }*/
            
            return $memberInfoArray;
        }
        catch(Exception $e){
            echo "An exception occurred while retrieving members from ADA.";
        }
    }
    
    //Updates each member received from the DMIS into the database.
    private function updateMembersInDatabase($membersFromDMIS)
    {
        $this->echoMessage("updateMembersInDatabase() called.");      
        
        //1. Delete all the records in the useringroups table that assigns a user the Member group.
        //2. Loop through the list of members. Update it in the database if it already exists in the table. 
        //   If not, add a new record. Also, add a record in the useringroups table to assign it to
        //   the Member group.
        //3. Do Not delete the users that did not get assigned to the Member group. The user ids may be in use in other tables.
        //4. Add a record in the MembersUpdate table with the number of errors that occurred, 
        //   number of records updated and current datetime.
        
        //Inactivate all the members in the database.
        $db = new DataAccessor();
        $db->inactivateAllMembers(); 
        
        //Loop through the list of members update it in the database if it already exists in the table. 
        //If not, add a new record.
        foreach ($membersFromDMIS as $member)
        {
            //remove this after testing
            if($this->numberOfMembersSavedtoDB == 3)
            {
                break;
            }
            try
            {
                $db->AddOrUpdateMember($member);
                $this->numberOfMembersSavedtoDB++;
            }
            catch(Exception $ex)
            {
                $this->numberOfErrors++;
                array_push($this->errors, "Failed in saving member with ADA number = " . 
                        $member->CustNo . ", Firstname = " . $member->FirstName . 
                        ", Lastname = " . $member->LastName . ". Error details: " . $ex->getMessage());
            }
        }
        
        //Add a record in the MembersUpdate table with the number of errors that occurred, 
        //number of records updated and current datetime.
        $this->memberUpdateBatchId = $db->addNewMemberUpdateRecord(
                $this->numberOfMembersReceivedFromADA, 
                $this->numberOfErrors, $this->numberOfMembersSavedtoDB);
    }
    
    //adds a record for each error in the errors collection to the MemberUpdateErrors table
    private function LogErrorsToDatabase(){
        $this->echoMessage("LogErrorsToDatabase() called.");        
        try
        {
            $db = new DataAccessor();
            if(!is_null($this->errors))
            {
                foreach($this->errors as $error)
                {
                    $db->LogErrorToDatabase($this->memberUpdateBatchId, $error);
                }
            }
            echo "Import completed with " . count($this->errors) . " errors. " . 
                    $this->numberOfMembersReceivedFromADA . " members downloaded from DMIS. " .
                    $this->numberOfMembersSavedtoDB . " members saved to database." . "<br/>";
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            $this->numberOfErrors++;
            array_push($this->errors, "Failed in logging errors in the database. Error details: " + $e->getMessage());
        }
    }
        
    //Sends an email to site admin to notify if errors occurred during the membership update.
    private function NotifySiteAdmin(){
        $this->echoMessage("NotifySiteAdmin() called.");     
        try
        {
            $config = Config::getConfig("email");
            $to = $config['admin_email'];
            $notify_success = $config['notify_success'];

            if(count($this->errors) > 0) 
            {
                $subject = "Errors occurred during membership update!";
                $body = "There were some errors in today's membership update. Please check the database for details.";
                mail($to, $subject, $body);
            }
            else
            {
                $this->echoMessage("No errors occurred."); 
                if ($notify_success == "Yes")
                {
                    $this->echoMessage("Sending success message."); 
                    $subject = "Members updated successfully!";
                    $body = "Members were successfully updated from ADA DMIS to the database.";
                    mail($to, $subject, $body);
                }
            }
        }
        catch(Exception $e)
        {
            echo "Failed in sending email to system admin. " . $e->getMessage();
        }
    }
    
    /**
     * Exception handler.
     */
    public function handleException(Exception $ex) {
        echo $ex->getMessage();
    }

    /**
     * Class loader.
     */
    public function loadClass($name) {
        $classes = array(
            'Config' => 'Config.php',
            'DataAccessor' => 'DataAccessor.php',
            );
        if (!array_key_exists($name, $classes)) {
            die('Class "' . $name . '" not found.');
        }
        require_once $classes[$name];
    }

    public function echoMessage($msg)
    {
        if($this->debugMode)
        {
            echo $msg . "<br/>";
        } 
    }
}

$index = new Index();
$index->init();
// run application!
$index->run();

?>

