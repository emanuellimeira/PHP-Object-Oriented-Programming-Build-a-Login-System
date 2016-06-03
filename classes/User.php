<?php

class User {

  private $_db,
          $_data,
          $_sessionName,
          $_cookieName,
          $_isLoggedIn;

  public function __construct($user = null)
  {
    $this->_db = DB::getInstance();
    $this->_sessionName = Config::get('session/session_name');
    $this->_cookieName = Config::get('remember/cookie_name');

    if (!$user) {
      if (Session::exists($this->_sessionName)) {
        $user = Session::get($this->_sessionName);
        if ($this->find($user)) {
          $this->_isLoggedIn = true;
        } else {
          // process logout
        }
      }
    } else {
      $this->find($user);
    }
  }

  public function update($fields = array(), $id = null)
  {
    if (!$id && $this->isLoggedIn()) {
      $id = $this->data()->id;
    }

    if (!$this->_db->update('users', $id, $fields)) {
      throw new Exception('There was a problem updating.');

    }
  }

  public function create($fields)
  {
    if(!$this->_db->insert('users', $fields)) {
      throw new Exception('There was a problem creating an account.');
    }
  }

  public function find($user = null)
  {
    if($user) {
      $field = (is_numeric($user)) ? 'id' : 'username';
      $data = $this->_db->get('users', array($field, '=', $user));
      if($data->count()) {
        $this->_data = $data->first();
        return true;
      }
    }
    return false;
  }

  public function login($username = null, $password = null, $remember = false)
  {

    if (!$username && !$password && !$this->exists()) {
      // log user in
      Session::put($this->_sessionName, $this->data()->id);
    } else {

      $user = $this->find($username);
      //print_r($this->_data);]

      if($user) {
        if($this->data()->password === Hash::make($password, $this->data()->salt)) {
          //echo "Ok!";
          Session::put($this->_sessionName, $this->data()->id);
          if ($remember) {
            $hash = Hash::unique();
            $hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));
            if (!$hashCheck->count()) {
              $this->_db->insert('users_session', array(
                'user_id' => $this->data()->id,
                'hash' => $hash
              ));
            } else {
              $hash = $hashCheck->first()->hash;
            }
            Cookie::put($this->_cookieName, $hash, Config::get('remember/cookir_expiry'));
          }
          return true;
        }
      }

    }

    return false;
  }

  public function hasPermission($key)
  {
    $group = $this->_db->get('groups', array('id', '=', $this->data()->group));
    // print_r($group->first());
    if ($group->count()) {
      $permissions = json_decode($group->first()->permissions, true);
      //print_r($permissions);
      if ($permissions[$key] == true) {
        return true;
      }
    }
    return false;
  }

  public function exists()
  {
    return (!empty($this->_data)) ? true : false;
  }

  public function logout()
  {
    $this->_db->delete('users_session', array('user_id', '=', $this->data()=>id));
    Session::delete($this->_sessionName);
    Cookie::delete($this->_cookieName);
  }

  public function data()
  {
    return $this->_data;
  }

  public function isLoggedIn()
  {
    return $this->_isLoggedIn;
  }

}
