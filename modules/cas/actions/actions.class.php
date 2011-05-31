<?php

/**
 * CAS actions
 * @author     D.Jeanmonod
 */
class casActions extends sfActions {
  
 /**
  * Forward the login action to the CAS server
  * When the user get log on the CAS, then he get's forwarded back to the 
  *  last module action
  *  
  * @param sfRequest $request A request object
  */
  public function executeLogin(sfWebRequest $request) {
    $this->getUser()->login();
    $this->forward($request->getParameter('module'), $request->getParameter('action'));
  }
 
 /**
  * Logout the user from the current app and then forward to CAS for a 
  *  global logout
  *  
  * @param sfRequest $request A request object
  */
  public function executeLogout(sfWebRequest $request) {
    $this->getUser()->signOut();
    // This exception should been never reach as the signOut must trigger a redirect
    throw new Exception("CAS Logout fail, there is a bug in the sfCASPlugin");
  }
  
}