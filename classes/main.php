<?php
class Projectiles {
    private $configFile;
    private $configData;
    protected $mysqli;

    public function __construct($rootDir = '/') {
        $this->configFile = $rootDir . '/config.php';
        $this->configData = $this->getconfigData();
        $this->mysqli = $this->dbconn();
    }
    
    private function getconfigData() {
        $configData = array();
        if(file_exists($this->configFile)) {
            if(is_readable($this->configFile)) {
                $fp = fopen($this->configFile, 'rb');
                if($fp) {
                    while (!feof($fp)) {
                        $line = trim(fgets($fp, 1024));
                        if($line === '' || strpos($line, ';') === 0) {
                            continue;
                        }
                        if(preg_match('/^\[\[(.+)\]\]/', $line, $matches)) {
                            $currentSection = $matches[1];
                            if(!isset($configData[$currentSection])) {
                                $configData[$currentSection] = array();
                            }
                        } else if(strpos($line, '=') !== false) {
                            list($key, $value) = explode('=', $line, 2);
                            $key = trim($key);
                            $value = trim($value);
                            if(preg_match('/^[\"\'](.*)[\"\']$/', $value, $matches)) {
                                $value = stripslashes($matches[1]);
                            } else {
                                preg_match('/^([\S]*)/', $value, $matches);
                                $value = $matches[1];
                                
                            }
                            if($currentSection === false) {
                                $configData[$key] = $this->cleanvar($value);
                            } else if(is_array($configData[$currentSection])) {
                                $configData[$currentSection][$key] = $this->cleanvar($value);
                            }
                        }
                    }
                    fclose($fp);
                    return $configData;
                }
            }
        }
        return $configData;
    }

    public function cleanvar($value) {
        if($value === '') {
            $value = null;
        } else if(is_numeric($value)) {
            if(strstr($value, '.')) {
                $value = (float) $value;
            } else if(substr($value, 0, 2) == '0x') {
                $value = intval($value, 16);
            } else if(substr($value, 0, 1) == '0') {
                $value = intval($value, 8);
            } else {
                $value = (int) $value;
            }
        } else if(strtolower($value) == 'true' || strtolower($value) == 'on') {
            $value = true;
        } else if(strtolower($value) == 'false' || strtolower($value) == 'off') {
            $value = false;
        } else if(defined($value)) {
            $value = constant($value);
        }
        return $value;
    }

    private function dbconn() {
        if(isset($this->configData['DATABASE']['server'], $this->configData['DATABASE']['user'], $this->configData['DATABASE']['password'], $this->configData['DATABASE']['database'])) {
            $mysql = new mysqli($this->configData['DATABASE']['server'],$this->configData['DATABASE']['user'],$this->configData['DATABASE']['password'],$this->configData['DATABASE']['database']);
            
            
        }

    }

    /*public function __destruct(){
        echo 'The class "' . __CLASS__ . '" was destroyed.<br>';
    }*/
}

