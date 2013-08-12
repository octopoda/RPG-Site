<?php

final class DataAccessor {

    private $dbConn = null;

    public function __destruct() {
        // close db connection
        $this->dbConn = null;
    }
    
    //sets the active flag to false for all users who belong to "Registered" user group (id = 2)
    public function inactivateAllMembers(){
        //echo "inactivateAllMembers() called.<br/>";
        
        $memberGroupId = $this->GetMemberGroupId();
        
        $sql = 'delete from userInGroups where group_id = :MemberGroupId';
        $statement = $this->getDbConn()->prepare($sql);
        $this->executeStatement($statement, array(':MemberGroupId' => $memberGroupId));
    }
    
    //gets the id of the Member group from the config file.
    private function GetMemberGroupId()
    {
        //echo "GetMemberGroupId() called.<br/>";
        $config = Config::getConfig("db");
        return $config['member_group_id'];
    }
    
    //adds or updates the member to the users table.
    public function AddOrUpdateMember($member)
    {
        //see if this member already exists based on the ada number
        //remove all leading zeros from the ada number
        //$adaNumber = ltrim($member->CustNo, "0");
        $adaNumber = (int)$member->CustNo;
        $matchedUser = $this->findUserByADANumber($adaNumber);
        if(is_null($matchedUser))
        {
            //member does not exist in the database. add it.
            $user_id = $this->insertUser($member);
        }
        else {
            //member already exists in the database. update it.
            $this->updateUser($member);
            $user_id = $matchedUser->user_id;
        }
        
        //assign this user to the Member group        
        $memberGroupId = $this->GetMemberGroupId();
        $this->addUserToGroup($user_id, $memberGroupId);
    }
   
    
    //checks the users table by ADA number to see if a member already exists
    public function findUserByADANumber($adaNumber) {
        $sql = 'SELECT * FROM users WHERE memberNumber = ' . $adaNumber;
        $row = $this->query($sql)->fetch();
        if (!$row) {
            return null;
        }
        
        return $row;
    }
    
    //inserts a new member in the Users table
    private function insertUser($member) {
        $now = new DateTime();
        $member->created_on = $now;
        $member->guid = uniqid('', true);
        $member->Active = 1;
        
        $sql = "INSERT INTO users (first, last, password, email, guid, created_on, memberNumber)
                VALUES (:FirstName, :LastName, :Password, :Email, :guid, :created_on, :CustNo)";
        //return $this->execute($sql, $member);
        $statement = $this->getDbConn()->prepare($sql);
        $memberAsArray = array(
            ':FirstName' => $member->FirstName, 
            ':LastName' => $member->LastName,
            ':Password' => $member->LastName,
            ':Email' => $member->Email,
            ':guid' => $member->guid,
            ':created_on' => self::formatDateTime($member->created_on),
            ':CustNo' => (int)$member->CustNo);

        $this->executeStatement($statement, $memberAsArray);
        
        //get the id of the user that was just added
        $id = $this->getDbConn()->lastInsertId('user_id');
        return $id;        
    } 
    
    //updates the details of an existing user in the Users table
    private function updateUser($memberToSave) {
        
        $sql = "UPDATE users set first = :FirstName, last = :LastName
                WHERE memberNumber = :ADANumber";

        $statement = $this->getDbConn()->prepare($sql);
        $params = array(
            ':FirstName' => $memberToSave->FirstName, 
            ':LastName' => $memberToSave->LastName,
            ':ADANumber' => (int)$memberToSave->CustNo);

        $this->executeStatement($statement, $params);
    }     
    
    //assigns a user to the Member group by adding a record in the useringroups table
    private function addUserToGroup($user_id, $group_id) {
        
        //echo "addUserToGroup() called.<br/>";
        $sql = "INSERT INTO userInGroups (user_id, group_id)
                VALUES (:UserId, :GroupId)";
        $statement = $this->getDbConn()->prepare($sql);
        $params = array(
            ':UserId' => $user_id, 
            ':GroupId' => $group_id);

        $this->executeStatement($statement, $params);
    }        
    
    //adds a new record in the memberupdates table. This table stores the summary of each member update batch process.
    public function addNewMemberUpdateRecord($numberOfMembersReceivedFromADA, 
            $numberOfErrors, $numberOfMembersSaved){
    
        //echo "addNewMemberUpdateRecord() called.<br/>";
        $now = new DateTime();
        $sql = "INSERT INTO memberUpdates (Date, NumberOfErrors, NumberOfMembersFromADA, NumberOfMembersSaved)
                VALUES (:Date, :NumberOfErrors, :NumberOfMembersFromADA, :NumberOfMembersSaved)";
        $statement = $this->getDbConn()->prepare($sql);
        $parameters = array(
            ':Date' => self::formatDateTime($now),
            ':NumberOfErrors' => $numberOfErrors,
            ':NumberOfMembersFromADA' => $numberOfMembersReceivedFromADA,
            ':NumberOfMembersSaved' => $numberOfMembersSaved);
        
        $this->executeStatement($statement, $parameters);
        
        //get the id of the record that was just added
        $id = $this->getDbConn()->lastInsertId('MemberUpdateId');
        return $id;
    }
    
    public function LogErrorToDatabase($memberUpdateBatchId, $error)
    {
        //echo "LogErrorToDatabase() called.<br/>";
        $now = new DateTime();
        $sql = "INSERT INTO MemberUpdateErrors (MemberUpdateId, ErrorDetails, CreateDate)
        VALUES (:MemberUpdateId, :ErrorDetails, :CreateDate)";
        $statement = $this->getDbConn()->prepare($sql);
        $parameters = array(
            ':MemberUpdateId' => $memberUpdateBatchId,
            ':ErrorDetails' => $error,
            ':CreateDate' => self::formatDateTime($now));
        
        $this->executeStatement($statement, $parameters);
    }
 
    
    /**
     * @return PDO connection object
     */
    private function getDbConn() {
        //echo "getDbConn() called.<br/>";
        if ($this->dbConn !== null) {
            return $this->dbConn;
        }
        $config = Config::getConfig("db");
        try {
            $this->dbConn = new PDO($config['dsn'], $config['username'], $config['password']);
        } catch (Exception $ex) {
            throw new Exception('DB connection error: ' . $ex->getMessage());
        }
        //echo "getDbConn() succeeded.<br/>";
        return $this->dbConn;
    }
    
    private function query($sql) {
        $statement = $this->getDbConn()->query($sql, PDO::FETCH_OBJ);
        if ($statement === false) {
            self::throwDbError($this->getDbConn()->errorInfo());
        }
        return $statement;
    }

    private static function throwDbError(array $errorInfo) {
        throw new Exception('DB error [' . $errorInfo[0] . ', ' . $errorInfo[1] . ']: ' . $errorInfo[2]);
    }    
    
    /*private function execute($sql, Todo $todo) {
        $statement = $this->getDbConn()->prepare($sql);
        $this->executeStatement($statement, $this->getParams($todo));
        if (!$todo->getId()) {
            return $this->findById($this->getDbConn()->lastInsertId());
        }
        if (!$statement->rowCount()) {
            throw new NotFoundException('TODO with ID "' . $todo->getId() . '" does not exist.');
        }
        return $todo;
    }*/
    
    private function executeStatement(PDOStatement $statement, array $params) {
        if (!$statement->execute($params)) {
            //echo "executeStatement() failed.<br/>";
            self::throwDbError($this->getDbConn()->errorInfo());
        }
    } 

    /**
     * @return PDOStatement
     */


    private static function formatDateTime(DateTime $date) {
        return $date->format(DateTime::ISO8601);
    }

}

?>
