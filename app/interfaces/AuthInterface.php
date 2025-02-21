<?php

interface AuthInterface {
    public function login(string $email, string $password) : array ;
    public function registrar(array $datos) : bool;
}