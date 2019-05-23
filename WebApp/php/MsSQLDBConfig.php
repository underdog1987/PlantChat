<?php

final class MsSQLDB2Config{
    
    private $dbServer;
    private $dbName;
    private $dbUser;
    private $dbPassword;

    public function __construct() {
        $this->dbServer='0.0.0.0';
        $this->dbName='b021mx';
        $this->dbUser='your_usr';
        $this->dbPassword='your_pass';

    }

    public function getDbServer() {
        return $this->dbServer;
    }

    public function getDbName() {
        return $this->dbName;
    }

    public function getDbUser() {
        return $this->dbUser;
    }

    public function getDbPassword() {
        return $this->dbPassword;
    }
		
}
