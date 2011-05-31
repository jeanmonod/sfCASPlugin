<?php

/*
 * This file is part of the sfCASPlugin
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfCASUser, Symfony security user that use CAS for login logout
 * @package    sfCASPlugin
 * @author     D.Jeanmonod
 */
class sfCASUser extends sfBasicSecurityUser {
  
  const USERNAME_NAMESPACE = 'symfony/user/sfUser/username';

  protected $username;
  
  
  /**
   * Override the initalize() to read the username from session
   * @see sfBasicSecurityUser::initialize()
   */
  public function initialize(sfEventDispatcher $dispatcher, sfStorage $storage, $options = array()) {
    parent::initialize($dispatcher, $storage, $options);
    $this->username = $storage->read(self::USERNAME_NAMESPACE);
  }
  
  
  /**
   * Try to login with the CAS server
   */
  public function login(){
    sfCAS::initPhpCAS();
    phpCAS::forceAuthentication();
    $this->username = phpCAS::getUser();
    $this->setAuthenticated(true);
  }
  
  
  /**
   * Logout the user form the current symfony application and from the 
   *  CAS server
   * @param  boolean $onlyLocal   Set it to true, to logout from the application, but stay login in the CAS
   */
  public function logout($onlyLocal = false){
    $this->setAuthenticated(false);
    $this->username = null;
    if ( ! $onlyLocal ) {
      sfCAS::initPhpCAS();
      phpCAS::logout();
    }
  }
  
  
  /**
   * Return the current user username
   * @return string
   */
  public function getUsername(){
    if (!$this->isAuthenticated()){
      throw new Exception("No username avaliable, the user is not logged'in");
    }
    return $this->username;
  }
  
    
  /**
   * Override the parent shutdown to save the username in the session
   */
  public function shutdown() {
    $this->storage->write(self::USERNAME_NAMESPACE,   $this->username);
    parent::shutdown();
  }
  
      
}