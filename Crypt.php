<?php
require_once('class.php');
class Crypt{ 
private $iv = "*********0*********0*********032"; //32 size of rijndael and cbc
private $key = "***IAMGOODGUYBUTILOVEBADGIRLS***"; //don't exceed above 32 for rijndael
private $algorithmForencrypt = "";

    public function encryptOneWay($plaintext){
        //32 size
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $key = mcrypt_get_key_size('rijndael-256', 'cbc');
        $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $plaintext, MCRYPT_MODE_CBC, $iv);
        return $ciphertext; 
    }//end of method
    
    public function encrypt($plaintext){               
        $cipher = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->key, $plaintext, MCRYPT_MODE_CBC, $this->iv);
        return $cipher;
    }//end of method
    
    
    //do not copy and paste the encrypted code for decryption, assign it using internally (by method or object)
    //use file_get_contents() and file_put_contents() for encryption and decryption only for this two methods
    public function decrypt($cipher){
        $plaintext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->key, $cipher, MCRYPT_MODE_CBC, $this->iv);
        return $plaintext;
    }//end of method
    
    public function encryptWithCrypt($string){
        $encrypt = crypt($string, '$2y$07$usesomesillystringforsalt$'); // current length is 60
        return $encrypt;
        //use this because it is good even if you compare with s2k
        //php.net/manual/en/function.crypt.php
        //crypt also uses some strings of salt in password which is legal
        //Blowfish: use $2x$ $2y$ supports =<5.3.7, $2a$ = 60length blowfish
        //it is not dynamic we have to use dynamic salt
    }//end of method
    
    public function encryptWithMhash($text, $hmac){
        $cipher = mhash(MHASH_TIGER160, $text, $hmac);
        return $cipher; // not strong if you use here bin2hex()
        //returning cipher in this format may give error(not 100% sure) if charset is different 
    }//end of method
    
    public function encryptWithS2K($password, $key, $length) {
        $s2k = mhash_keygen_s2k(MHASH_TIGER160, $password, $key, $length); //gives strong and random salt, -8bit is necessary
        return bin2hex($s2k); // not strong if you use this bin2hex()  
    }//end of method
       
    public function getMcryptInfo(){
        $algorithms = mcrypt_list_algorithms("/usr/local/lib/libmcrypt");
        echo "¡ algorithms ›<br>";
        foreach ($algorithms as $cipher) {
            echo $cipher."<br />\n";
        }
        $modes = mcrypt_list_modes();
        echo "¡ modes ›<br>";
        foreach ($modes as $mode) {
            echo "$mode <br />\n";
        }
    }//end of method
}//end of class
?>
<?php
//$connect = new Crypt();
//$connect->getMcryptInfo();
//$connect->encryptWithCrypt("hello");
//$connect->encrypt("it encrypts");
//$connect->decrypt("it decrypts");//echo $connect->encryptOneWay("獂");
//$protect->encryptWithMhash("password");
//$protect->encryptWithS2K("password", "key", "4"); //encrypts in fixed size with binhex()
?>
