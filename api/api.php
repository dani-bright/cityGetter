<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json");
require "../inc/init.inc.php";
require "../inc/methods.inc.php";

//at the beginning get all cities
$all = getAll($pdo);
  echo json_encode($all);
if (isset($_GET['req'])) {
  // INIT

  // PROCESS REQUEST
  switch ($_GET['search']) {
    default:
      echo json_encode([
        "status" => false,
        "message" => "Invalid Request"
      ]);
      break;

    case "get-all":
    $all = $users->getAll();
      echo json_encode([
        "status" => $all==false?false:true,
        "data" => $all
      ]);
      break;

    case "get-email":
    $usr = $users->getEmail($_POST['email']);
      echo json_encode([
        "status" => $all==false?false:true,
        "data" => $usr
      ]);
      break;

    case "get-id":
    $usr = $users->getID($_POST['id']);
      echo json_encode([
        "status" => $all==false?false:true,
        "data" => $usr
      ]);
      break;

    case "create":
      $pass = $users->create($_POST['name'], $_POST['email'], $_POST['password']);
      echo json_encode([
        "status" => $pass,
        "message" => $pass ? "User Created" : "Error creating user"
      ]);
      break;

    case "update":
      $pass = $users->update($_POST['name'], $_POST['email'], $_POST['password'], $_POST['id']);
      echo json_encode([
        "status" => $pass,
        "message" => $pass ? "User Updated" : "Error updating user"
      ]);
      break;

    case "delete":
      $pass = $users->delete($_POST['id']);
      echo json_encode([
        "status" => $pass,
        "message" => $pass ? "User Deleted" : "Error deleting user"
      ]);
      break;

    case "login":
      if (is_array($_SESSION['user'])) {
        die(json_encode([
              "status" => true,
              "message" => "Already signed in"
          ]));
      }
        $pass = $users->login($_POST['name'], $_POST['password']);
        if ($pass!==false) { $_SESSION['user'] = $pass; }
      echo json_encode([
          "status" => is_array($pass),
          "message" => is_array($pass) ? "OK" : "Error"
      ]);
      break;

    case "logoff":
      unset($_SESSION['user']);
      echo json_encode([
          "status" => true,
          "message" => "OK"
      ]);
      break;
  }
}
?>