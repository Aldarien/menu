<?php
foreach ($cfg->get('databases') as $database) {
  $dsn = ['mysql:host=' . $database->host];
  if (isset($database->port)) {
    $dsn []= 'port=' . $database->port;
  }
  $dsn []= 'dbname=' . $database->name;
  $dsn = implode(';', $dsn);
  ORM::configure($dsn);
  ORM::configure('username', $database->user->name);
  ORM::configure('password', $database->user->password);
  ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
}
Model::$short_table_names = true;