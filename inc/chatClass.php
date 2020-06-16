<?php

class chatClass {

  public static $InputPattern = 'AaBbCc1234', $OutputPattern = "cCAaBb2143";

  public static function getRestChatLines($id) {
    $arr = [];
    $jsonData = '{"results":[';
    $db_connection = new mysqli(mysqlServer, mysqlUser, mysqlPass, mysqlDB);
    $db_connection->query("SET NAMES 'UTF8'");
    $statement = $db_connection->prepare("SELECT id, usrname, color, chattext, chattime 
        FROM chat WHERE id > ? and chattime >= DATE_SUB(NOW(), INTERVAL 1 HOUR)");

    $statement->bind_param('i', $id);
    $statement->execute();
    $statement->bind_result($id, $usrname, $color, $chattext, $chattime);
    $line = new stdClass;
    while ($statement->fetch()) {
      $line->id = $id;
      $line->usrname = $usrname;
      $line->color = $color;
      $line->chattext = self::rla1Decode(self::patternBased($chattext, self::$OutputPattern, self::$InputPattern));
      $line->chattime = date('H:i:s', strtotime($chattime));
      $arr[] = json_encode($line);
    }
    $statement->close();
    $db_connection->close();
    $jsonData .= implode(",", $arr);
    $jsonData .= ']}';
    return $jsonData;
  }

  public static function rla1Decode(string $input): string {
    if ($input === '') {
      return '';
    }

    $n = $decoded = '';
    $i = 0;
    while (TRUE) {
      $char = $input[$i++] ?? NULL;
      if (ctype_digit($char)) {
        $n .= $char;
      }
      elseif ($char !== NULL) {
        $decoded .= str_repeat($char, $n !== '' ? (int) $n : 1);
        $n = '';
      }
      else {
        break;
      }
    }

    return $decoded;
  }

  public static function patternBased($SourceString, $list1, $list2) {
    for ($element = 0; $element < strlen($SourceString); $element++) {
      for ($index = 0; $index < strlen($list1); $index++) {
        if ($SourceString[$element] == $list1[$index]) {
          $SourceString[$element] = $list2[$index];
          break;
        }
      }
    }
    return ($SourceString);
  }

  public static function setChatLines($chattext, $usrname, $color) {
    $db_connection = new mysqli(mysqlServer, mysqlUser, mysqlPass, mysqlDB);
    $db_connection->query("SET NAMES 'UTF8'");
    $statement = $db_connection->prepare("INSERT INTO chat( usrname, color, chattext) VALUES(?, ?, ?)");
    $chattext = self::rla1Encode($chattext);
    $chattext = self::patternBased($chattext, self::$InputPattern, self::$OutputPattern);
    $statement->bind_param('sss', $usrname, $color, $chattext);
    $statement->execute();
    $statement->close();
    $db_connection->close();
  }

  public static function rla1Encode(string $input): string {
    if ($input === '') {
      return '';
    }

    $c = NULL;
    $f = 0;
    $rle = '';
    $i = 0;
    while (TRUE) {
      $char = $input[$i++] ?? NULL;
      if ($c === $char) {
        continue;
      }
      if ($c !== NULL) {
        $r = $i - $f; // Repeats...
        $rle .= ($r > 1 ? $r : '') . $c;
        if ($char === NULL) {
          break;
        }
      }
      $c = $char;
      $f = $i; // First occurence.
    }

    return $rle;
  }


}
