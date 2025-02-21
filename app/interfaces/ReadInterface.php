<?php

interface ReadInterface{
    public function listar() : array;
    public function buscarPorId($id) : array;
}