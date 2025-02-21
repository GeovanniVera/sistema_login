<?php

interface AuthInterface {
    public function login(string $email, string $password) : bool ;
    public function registrar(array $datos) : bool;
}