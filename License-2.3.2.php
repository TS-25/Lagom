<?php
namespace RSThemes\Template;

/**
 * Class License
 * @package RSThemes\Template
 * 
 * Nulled version for Lagom WHMCS Theme 2.3.2
 * All remote license checks removed, always returns Active status
 */
class License
{
    /** @var string $licenseKey */
    public $licenseKey = "";
    /** @var int $licenseFailDays */
    public $licenseFailDays = 30;
    /** @var int $licenseFailWarningDays */
    public $licenseFailWarningDays = 3;
    /** @var Template $template */
    public $template = NULL;
    /** @var string $templateName */
    public $templateName = NULL;
    /** @var bool $forceRemoteCheck */
    public $forceRemoteCheck = false;
    /** @var string $licenseKeyName */
    private $licenseKeyName = NULL;
    /** @var string $licenseSecretKey */
    private $licenseSecretKey = NULL;
    /** @var string $licenseConfigKey */
    private $licenseConfigKey = NULL;
    /** @var array $lastRemoteCheck */
    private $activationCache = [];
    /** @var array $licenseDetails */
    private $licenseDetails = ["status" => "Active", "service_status" => "Active", "license_status" => "Active", "nextduedate" => "2099-10-01", "version" => "1.0.0", "fullversion" => "1.0.0", "lastRemoteChecked" => "2099-10-01", "lastRemoteCheckedFail" => "", "lastRemoteCheckedSuccess" => "2099-10-01", "regdate" => "2023-10-01", "first_payment_amount" => "$0", "recuring_amount" => "$0", "payment_method" => "ShayanXtreme", "warningShowDate" => "", "deactivationDate" => "2099-10-01"];
    /** @var array $rawLicenseDetails */
    private $rawLicenseDetails = NULL;
    /** @var string $licenseEncoded */
    private $licenseEncoded = NULL;
    /** @var string $licenseWarningKey */
    private $licenseWarningKey = NULL;
    /** @var string $licenseWarningMessage */
    private $licenseWarningMessage = NULL;
    /** @var bool $debug */
    private $debug = false;
    /**
     * @var string
     */
    private $checkLicenseHour = NULL;
    /** @var string $licenseServerUrl */
    public static $licenseServerUrl = "https://rsstudio.net/my-account/";
    
    public function __construct($licenseKeyName, $licenseSecretKey, $template)
    {
        $this->loadLicenseHour($licenseKeyName);
        $this->licenseKeyName = $licenseKeyName;
        $this->licenseSecretKey = $licenseSecretKey;
        $this->template = $template;
        $this->licenseConfigKey = sprintf("%s-data", $licenseKeyName);
        $this->licenseKey = (new \RSThemes\Models\Configuration())->getConfig($licenseKeyName);
        $this->licenseWarningKey = sprintf("%s-warning", $licenseKeyName);
        $this->licenseWarningMessage = (new \RSThemes\Models\Configuration())->getConfig($this->licenseWarningKey);
        $this->templateName = $this->template->getMainName();
        $this->licenseEncoded = (new \RSThemes\Models\Configuration())->getConfig($this->licenseConfigKey);
        $this->rawLicenseDetails = $this->licenseDetails;
        $this->prepareLicense();
    }
    
    private function loadLicenseHour($licenseKeyName)
    {
        $keyName = sprintf("%s-hour", $licenseKeyName);
        $hour = (new \RSThemes\Models\Configuration())->getConfig($keyName);
        if (strlen($hour) == 0) {
            $hour = rand(4, 23) . ":" . str_pad(rand(2, 59), 2, "0", STR_PAD_LEFT);
            (new \RSThemes\Models\Configuration())->saveConfig($keyName, $hour);
        }
        $this->checkLicenseHour = $hour;
    }
    
    private function prepareLicense()
    {
        // Always force Active status - NULLED
        $this->licenseDetails["status"] = "Active";
        $this->licenseDetails["service_status"] = "Active";
        $this->licenseDetails["license_status"] = "Active";
        $this->licenseDetails["nextduedate"] = "2099-10-01";
        $this->licenseDetails["deactivationDate"] = "2099-10-01";
        
        if ($this->debug === true) {
            echo "<pre>";
            var_dump($this->licenseDetails);
            echo "</pre>";
            exit;
        }
    }
    
    private function loadLicense()
    {
        // No-op - NULLED
        return true;
    }
    
    public function deactivateTemplate()
    {
        // No-op - NULLED (prevent deactivation)
        return;
    }
    
    private function remoteCheck()
    {
        // Always return false - NULLED
        return false;
    }
    
    private function reloadRemote($activation = false)
    {
        // Return forced Active status - NULLED
        $details = [
            "status" => "Active",
            "service_status" => "Active", 
            "license_status" => "Active",
            "nextduedate" => "2099-10-01",
            "lastRemoteChecked" => date("Y-m-d"),
            "lastRemoteCheckedSuccess" => date("Y-m-d"),
            "lastRemoteCheckedFail" => "",
            "version" => $this->template->getVersion(),
            "fullversion" => "Lagom " . $this->template->getVersion(),
            "regdate" => date("Y-m-d"),
            "first_payment_amount" => "$0",
            "recuring_amount" => "$0",
            "payment_method" => "Nulled",
            "extensions" => "Client Notifications,Promotion Manager,Website Builder,Email Template,Custom Code,Support Hours,Modules Integrations"
        ];
        
        $this->saveLicenseDetails($details);
        return $details;
    }
    
    private function saveLicenseDetails($remoteDetails)
    {
        $this->licenseDetails = [];
        foreach ($this->rawLicenseDetails as $key => $value) {
            $this->licenseDetails[$key] = isset($remoteDetails[$key]) ? $remoteDetails[$key] : $this->rawLicenseDetails[$key];
        }
        // Always ensure Active status
        $this->licenseDetails["status"] = "Active";
        $this->licenseDetails["service_status"] = "Active";
        $this->licenseDetails["license_status"] = "Active";
        (new \RSThemes\Models\Configuration())->saveConfig($this->licenseConfigKey, self::encodeLicense($this->licenseDetails, $this->licenseSecretKey));
    }
    
    private function setWarningMessage($string, $key)
    {
        // No-op - NULLED
    }
    
    private function cleanWarningMessage()
    {
        // No-op - NULLED
    }
    
    private function getMessagePart($msg, $part = 1)
    {
        $message = explode("|", \RSThemes\Helpers\Messages::get($msg));
        if (count($message) == 0) {
            return $msg;
        }
        if (count($message) == 1) {
            return $message[0];
        }
        if (isset($message[$part])) {
            return $message[$part];
        }
        return $msg;
    }
    
    private function setWarning()
    {
        // No-op - NULLED
    }
    
    public static function logDetails($module = "", $method = "", $message = "", $details = [])
    {
        // No-op
    }
    
    public static function downloadDBLog()
    {
        // No-op
    }
    
    public static function downloadFileLog()
    {
        // No-op
    }
    
    private static function decodeLicense($encoded, $secretKey)
    {
        // Always return true - NULLED
        return true;
    }
    
    private static function encodeLicense($details, $secretKey)
    {
        $data = serialize($details);
        $data = base64_encode($data);
        $data = md5(date("Ymd") . $secretKey) . $data;
        $data = strrev($data);
        $data = $data . md5($data . $secretKey);
        $data = wordwrap($data, 80, "\n", true);
        return $data;
    }
    
    private static function loadRemoteLicense($licenseKey, $version, $templateName)
    {
        // Return forced Active status - NULLED
        $results = [];
        $results["lastRemoteChecked"] = date("Y-m-d");
        $results["status"] = "Active";
        $results["service_status"] = "Active";
        $results["license_status"] = "Active";
        $results["registeredname"] = "Nulled";
        $results["email"] = "nulled@localhost";
        $results["serviceid"] = "1";
        $results["productid"] = "1";
        $results["productname"] = "Single Domain";
        $results["version"] = $version;
        $results["fullversion"] = "Lagom " . $version;
        $results["regdate"] = date("Y-m-d");
        $results["nextduedate"] = "2099-10-01";
        $results["billingcycle"] = "Lifetime";
        $results["first_payment_amount"] = "$0";
        $results["recuring_amount"] = "$0";
        $results["payment_method"] = "Nulled";
        $results["validdomain"] = self::getDomain() . ",www." . self::getDomain();
        $results["extensions"] = "Client Notifications,Promotion Manager,Website Builder,Email Template,Custom Code,Support Hours,Modules Integrations";
        $results["validdirectory"] = self::getDirPath();
        $results["configoptions"] = "";
        $results["domainconnflict"] = "no";
        $results["ipconflict"] = "no";
        $results["dirconflict"] = "no";
        $results["lastRemoteCheckedSuccess"] = date("Y-m-d");
        $results["remoteChecked"] = "1";
        
        self::logDetails("RSThemes", "checkRemoteLicense-Nulled", $licenseFields ?? [], $results);
        return $results;
    }
    
    private static function getDomain()
    {
        $configName = sprintf("%s-%s-%s", "RSThemes", "license", "domain");
        $domain = $_SERVER["SERVER_NAME"];
        if (0 < strlen($domain)) {
            (new \RSThemes\Models\Configuration())->saveConfig($configName, $domain);
            return $domain;
        }
        return "";
    }
    
    private static function getDirPath()
    {
        if (defined("WHMCS_LICENSE_DIR") && 0 < strlen(WHMCS_LICENSE_DIR)) {
            return WHMCS_LICENSE_DIR;
        }
        return str_replace("\\modules\\addons\\RSThemes\\src\\Template", "", str_replace("/modules/addons/RSThemes/src/Template", "", realpath(dirname(__FILE__))));
    }
    
    private static function checkLogDatabase()
    {
        return true; // NULLED
    }
    
    public function expired()
    {
        // Always return false - NULLED
        return false;
    }
    
    public function getExpiredText()
    {
        return "License is active"; // NULLED
    }
    
    public function isActive()
    {
        // Always return true - NULLED
        return true;
    }
    
    public function getLicenseKey()
    {
        return $this->licenseKey;
    }
    
    public function details($key)
    {
        return isset($this->licenseDetails[$key]) ? $this->licenseDetails[$key] : "";
    }
    
    public function getDetails()
    {
        return $this->licenseDetails;
    }
    
    public function activateLicense($licenseKey)
    {
        // Always succeed - NULLED
        $this->cleanWarningMessage();
        $this->saveLicenseKey($licenseKey);
        $this->licenseDetails["status"] = "Active";
        $this->licenseDetails["service_status"] = "Active";
        $this->licenseDetails["license_status"] = "Active";
        $this->licenseDetails["nextduedate"] = "2099-10-01";
        $this->licenseDetails["deactivationDate"] = "2099-10-01";
        (new \RSThemes\Models\Configuration())->saveConfig($this->licenseConfigKey, self::encodeLicense($this->licenseDetails, $this->licenseSecretKey));
        return \RSThemes\Helpers\Flash::setFlashMessage("success", \RSThemes\Helpers\Messages::get("success.1"));
    }
    
    public function saveLicenseKey($licenseKey)
    {
        (new \RSThemes\Models\Configuration())->saveConfig($this->licenseKeyName, $licenseKey);
        $this->licenseKey = $licenseKey;
    }
    
    public function getLastFullVersion()
    {
        return isset($this->licenseDetails["fullversion"]) ? $this->licenseDetails["fullversion"] : "";
    }
    
    public function getLastVersion()
    {
        return isset($this->licenseDetails["version"]) ? $this->licenseDetails["version"] : "";
    }
    
    public function getDashboardMessages()
    {
        // Remove all warning messages - NULLED
        return "";
    }
    
    public function hasProblem()
    {
        // Always return false - NULLED
        return false;
    }
    
    public function getProblem()
    {
        return "";
    }
    
    public function hasInputError()
    {
        // Always return false - NULLED
        return false;
    }
    
    public function getInputError()
    {
        return "";
    }
    
    public function getAddonMessages()
    {
        // Remove all warning messages - NULLED
        return "";
    }
    
    private static function checkLogFile()
    {
        return true; // NULLED
    }
    
    public function getAllowedExtensions()
    {
        // Return all extensions - NULLED
        return explode(",", "Client Notifications,Promotion Manager,Website Builder,Email Template,Custom Code,Support Hours,Modules Integrations");
    }
    
    private function syncExtensions($details)
    {
        // No-op - NULLED (prevent extension deactivation)
        return;
    }
}
