--TEST--
PDO SQLRELAY MySQL handling of \ char in prepared statements 
--SKIPIF--
<?php include "pdo_sqlrelay_mysql_skipif.inc"; ?>
--FILE--
<?php
include "PDOSqlrelayMysqlTestConfig.inc";
$dsn = PDOSqlrelayMysqlTestConfig::getPDOSqlrelayDSN();
$username = PDOSqlrelayMysqlTestConfig::getSqlrelayUser();
$passwd = PDOSqlrelayMysqlTestConfig::getSqlrelayPassword();
$options = array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
$db = new PDO($dsn, $username, $passwd, $options );

$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, TRUE);
$stmt = $db->prepare('SELECT UPPER(\'\0:D\0\'),?');
$stmt->execute(array(1));
var_dump($stmt->fetchAll(PDO::FETCH_NUM));

--EXPECT--
array(1) {
  [0]=>
  array(2) {
    [0]=>
    string(4) " :D "
    [1]=>
    string(1) "1"
  }
}
