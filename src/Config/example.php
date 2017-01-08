<?php

  include 'Main.php';

  /*##############################
   *# Create Config without file #
   *############################## 
   */
   $cfg     = new Config('config.txt', false);
   $cfg->set('message', 'Hello, world!');
   $cfg->save(); //saves current config to file
   $message = $cfg->get('message');
   echo $message;

  /*###########################
   *# Create Config with file #
   *###########################
   */
   $cfg     = new Config('config.txt', true);
   $message = $cfg->get('message');
   echo $message;

  /*############################
   *# Using arrays with Config #
   *############################
   */
   $cfg     = new Config('config.txt', false);
   $cfg->set('array', ['message' => 'Hello, world!']);
   $message = $cfg->getNested('array', 'message'); //get key 'message' from array 'array'
   echo $message;
   $cfg->setNested('array', 'message', 'Hello, Mars!'); //set key 'message' to 'Hello, Mars!' in array 'array'
   echo $cfg->getNested('array', 'message'); //value of key 'message' has been changed
