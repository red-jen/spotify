<?php

class Admin extends User {
    public function __construct($id, $username, $email, $password) {
        parent::__construct($id, $username, $email, $password, 'admin');
    }
}
