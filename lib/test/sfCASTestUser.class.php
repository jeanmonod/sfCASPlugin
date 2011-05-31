<?php
/*
 * This file is part of the sfCASPlugin
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Specific class to use in functionnal testing, avoiding any call to phpCAS
 *
 * @package    sfCASPlugin
 * @author     D.Jeanmonod
 */
class sfCASTestUser extends sfCASUser {
  
  protected static $nextUsername = 'cas_test_user';
    
  /**
   * Allow to specify the next username that will be return by CAS at the next login tentative
   * @param string $name
   */
  public static function setUsernameForNextLogin($name) {
    self::$nextUsername = $name;
  }
  
  /**
   * @see sfCASUser::login
   */
  public function login(){
    $this->username = self::$nextUsername;
    $this->setAuthenticated(true);
  }

  /**
   * @see sfCASUser::logout
   */
  public function logout($onlyLocal = false){
    parent::logout(true);
  }
 
}