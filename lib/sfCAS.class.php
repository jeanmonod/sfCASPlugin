<?php

/*
 * This file is part of the sfCASPlugin
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfCAS, utility method to access the phpCAS lib
 * @package    sfCASPlugin
 * @author     D.Jeanmonod
 * @maintainer H.Lepesant Thu, 08 Dec 2011 09:39:37 +0100
 */
class sfCAS {
    
  protected static $phpCASIsLoaded = false;
  
  
  /**
   * Initialize the phpCAS librairies
   */
  public static function initPhpCAS(){
    
    // Retun if already loaded
    if (self::$phpCASIsLoaded)
      return;
                    
    // Init CAS using the config from app.yml
    require_once(dirname(__FILE__).'/vendor/phpCAS/CAS.php');
    phpCAS::client(
      CAS_VERSION_2_0, 
      sfConfig::get('app_cas_server_name'), 
      sfConfig::get('app_cas_server_port'), 
      sfConfig::get('app_cas_server_path'),
      false // Don't automatically start the session as it will be handle by the symfony session
    );
    
    // Disable SSL certificat validation in dev mode
    if ( sfConfig::get('sf_environment') == 'dev'){
      phpCAS::setNoCasServerValidation();
    }
    
    // Log cas activity to the standard log directory in debug mode
    if ( sfConfig::get('sf_debug', false) == true){
      phpCAS::setDebug(sfConfig::get('sf_log_dir').'/phpCAS_'.sfConfig::get('sf_environment').'.log');
    }
    
    self::$phpCASIsLoaded = true;
     
  }
  
  
  /**
   * Return the login page url
   * @return string
   */
  public static function getLoginUrl(){
    self::initPhpCAS();
    return phpCAS::getServerLoginURL();
  }
  
        

}
