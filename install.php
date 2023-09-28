<?php

include "application/vendor/autoload.php";

//error_reporting(0);

define('BASEPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);

class Install
{
    private $db_host;
    private $db_user;
    private $db_pass;
    private $db_name;
    private $purchase_code;
    private $admin_email;
    private $admin_pass;
    private $php_min_version = '7.0.0';
    private $images_folder = BASEPATH . '/images';
    private $config_file = BASEPATH . '/config.php';

    public function __construct()
    {
        if (!$this->_is_installation()) {
            exit('No direct script access allowed');
        }
    }


    public function index()
    {
        $requirements_error = $this->_server_requirements();

        include_once BASEPATH . '/application/views/install/install.php';
    }


    public function install()
    {
        try {
            $this->_init_install_data();
            $this->_validate_install_data();
            $this->_check_db_connect();
            $this->_validate_purchase_code();
            $this->_create_tables();
            $this->_create_config();
            $this->_send_register_mail();
        } catch (\Exception $e) {
            exit(json_encode(['error' => 1, 'message' => $e->getMessage()]));
        }

        exit(json_encode(['error' => 0, 'message' => 'success']));
    }


    private function _init_install_data()
    {
        $this->db_host       = $this->_postdata('db_host');
        $this->db_user       = $this->_postdata('db_user');
        $this->db_pass       = $this->_postdata('db_pass');
        $this->db_name       = $this->_postdata('db_name');
        $this->admin_email   = $this->_postdata('admin_email');
        $this->admin_pass    = $this->_postdata('admin_pass');
        $this->purchase_code = $this->_postdata('purchase_code');
    }


    private function _validate_install_data()
    {
        $error_msg = "";

        if (!$this->db_user) {
            $error_msg .= "MySQL user - can not be empty!\n";
        }

        if (!$this->db_name) {
            $error_msg .= "MySQL database - can not be empty!\n";
        }

        if (!$this->db_host) {
            $error_msg .= "MySQL host - can not be empty!\n";
        }

        if (!filter_var($this->admin_email, FILTER_VALIDATE_EMAIL)) {
            $error_msg .= "Invalid Admin email\n";
        }

        if (strlen($this->admin_pass) < 8) {
            $error_msg .= "Admin password must be at least 8 characters in length!\n";
        }

        if ($error_msg) {
            throw new Exception($error_msg);
        }

        return true;
    }


    private function _check_db_connect()
    {
        $mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);

        if ($mysqli->connect_errno) {

            if ($mysqli->connect_errno == 2002) {
                throw new Exception('"MySQL host" error!');
            }

            if ($mysqli->connect_errno == 1045) {
                throw new Exception('"MySQL user / MySQL password" error!');
            }

            if ($mysqli->connect_errno == 1049) {
                throw new Exception('"MySQL database" error!');
            }

            throw new Exception('MySQL error: ' . $mysqli->connect_errno);
        }

        return true;
    }


    private function _create_tables()
    {
        $installer = new \Install\Install($this->db_host, $this->db_name, $this->db_user, $this->db_pass);

        $installer->run([
            "email"              => $this->admin_email,
            "username"           => "Admin",
            "password"           => $this->_superhash($this->admin_pass),
            "role"               => "administrator",
            "subrole"            => "administrator",
            "status"             => "1",
            "status_message"     => "",
            "webmaster_balance"  => 0,
            "advertiser_balance" => 0,
            "reset_pass_token"   => ""
        ]);

        return true;
    }


    private function _is_installation()
    {
        if (!file_exists($this->config_file)) {
            return true;
        }

        $dbconf = include_once $this->config_file;

        if (empty($dbconf['db_host']) || empty($dbconf['db_user']) || empty($dbconf['db_name'])) {
            return true;
        }

        return false;
    }


    private function _get_fileperms($filename)
    {
        clearstatcache();

        if (!file_exists($filename)) {
            return null;
        }

        return substr(sprintf('%o', fileperms($filename)), -4);
    }


    private function _server_requirements()
    {
        $error_message = "";

        if (!version_compare(PHP_VERSION, $this->php_min_version, '>=')) {
            $error_message .= "PHP version is lower than required! Installed - <b>" . PHP_VERSION . "</b>. "
                . "The PHP version must be at least <b>{$this->php_min_version}</b>\n\n";
        }

        if ($this->_get_fileperms($this->images_folder) != '0777') {
            $error_message .= "The directory <b>" . basename($this->images_folder) . "</b> must be writable. <b>(CHMOD 0777)</b>\n\n";
        }

        if (!in_array($this->_get_fileperms($this->config_file), array('0666', '0777'))) {
            $error_message .= "The file <b>" . basename($this->config_file) . "</b> must be writable <b>(CHMOD 0777 or 0666)</b>\n\n";
        }

        if ($this->_is_subfolder()) {
            $error_message .= "You cannot install a script in a subfolder (this is a limitation of the codeigniter framework). Use a subdomain instead of a subfolder.<br><br>"
                . "Wrong: <strong>site.com/subfolder/</strong><br>"
                . "Right: <strong>subdomain.site.com</strong>\n\n"
                . "Do not use the combination of the letters <strong>\"ad\", \"ads\", \"advert\"</strong> in the name of the domain or subdomain, so as not to fall under AdBlock filters";
        }

        return $error_message;
    }


    private function _postdata($key)
    {
        return isset($_POST[$key]) ? trim((string) $_POST[$key]) : "";
    }


    private function _create_config()
    {
        $install_date = time();
        $appkey       = sha1(md5(uniqid("_", true) . microtime()));

        $config = "<?php defined('BASEPATH') OR exit('No direct script access allowed');
       
        return array(
            'db_host'      => '{$this->db_host}',
            'db_user'      => '{$this->db_user}',
            'db_pass'      => '{$this->db_pass}',
            'db_name'      => '{$this->db_name}',
            'install_date' => '{$install_date}',
            'appkey'       => '{$appkey}',
            'purchase_code' => '{$this->purchase_code}',
        );";

        if (file_put_contents($this->config_file, $config) === false) {
            throw new Exception('Error creating the configuration file!');
        }

        return true;
    }


    private function _superhash($str)
    {
        $pefix_salt  = sha1(md5($str));
        $suffix_salt = md5(sha1($str));

        return sha1($pefix_salt . $str . $suffix_salt);
    }


    private function _send_register_mail()
    {
        if (function_exists('mail')) {

            $subject = "AdFlex - installation completed successfully!";

            $message = "AdFlex has been successfully installed!\n\n";
            $message .= "Admin data:\n";
            $message .= "URL: http://{$_SERVER['HTTP_HOST']}\n";
            $message .= "Email: " . $this->admin_email . "\n";
            $message .= "Password: " . $this->admin_pass . "\n";

            $headers = "From: mailer@{$_SERVER['HTTP_HOST']}" . "\r\n";

            mail($this->admin_email, $subject, $message, $headers);
        }
    }


    private function httpGet($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);

        $output = curl_exec($ch);

        curl_close($ch);
        return $output;
    }


    private function _validate_purchase_code()
    {
        $urls = [
            "http://verify-purchase.blbsk.com/adflex_verify.php"
        ];

        $ret = $this->httpGet($urls[0] . "?code=" . urlencode($this->purchase_code));

        if (!$ret) {
            throw new Exception('Check the purchase code failed. Try the installation again later.');
        }

        $ret = json_decode($ret);

        if ($ret->error == 1) {
            throw new Exception('Invalid purchase code!');
        }

        return true;
    }


    private function _is_subfolder()
    {
        return $_SERVER['SCRIPT_NAME'] != "/install.php";
    }

}

if (isset($_POST['install'])) {
    (new Install)->install();
} else {
    (new Install)->index();
}


