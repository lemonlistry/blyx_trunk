<?php

class WebUser extends CWebUser {

    private $_user;

    public function getUid() {
        $user = $this->loadUser();
        return $user->id;
    }

    protected function loadUser() {
        if ($this->_user === null) {
            $this->_user = Account::user($this->id);
        }
        return $this->_user;
    }

    

}