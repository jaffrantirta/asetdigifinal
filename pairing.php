<?php
// $pairing = file_get_contents('http://localhost/assetdigifinal2/bonus/pairing');
// echo $pairing;

$url = 'http://localhost/assetdigifinal2/bonus/pairing';
 
$curl = curl_init();
 
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);
 
$data = curl_exec($curl);
 
curl_close($curl);

// $today = date('d');

// // Create connection
// // $conn = new mysqli('kuypenida.com', 'kuyc8958_assetdigi', 'jaffran@2020', 'kuyc8958_assetdigi');
// $conn = new mysqli('localhost', 'root', '', 'kuyc8958_assetdigital_dev');
// // Check connection
// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }

// $turnover = $conn->query("select * from turnovers where is_active = false");
// $percentage = $conn->query("select * from settings where key = 'turnover_percentage'");

// if($turnover->num_rows > 0){
//     // $p = $percentage -> fetch_assoc();
//     echo json_encode(mysqli_fetch_array($turnover, MYSQLI_ASSOC));
//     // foreach($turnover->fetch_assoc() as $data){
//     //     $left = $data->left_belance;
//     //     $right = $data->right_belance;
//     //     if($left >= $right){
//     //         $smaller = $right;
//     //     }else{
//     //         $smaller = $left;
//     //     }
//     //     $bonus = $smaller / 100 * $p;
//     //     $x = $conn->query("select * from total_bonuses where owner_id = $data->owner");
//     //     if($x->num_rows > 0){
//     //         $x2 = $x -> fetch_assoc();
//     //         $balance = $x[0]->balance + $bonus;
//     //         $id_inout = 'BI'.time().'-'.$data->owner;
//     //         $mysqli -> autocommit(FALSE);
//     //         $mysqli -> query("UPDATE total_bonuses SET balance = '$balance' WHERE id = ".$x2['id']);
//     //         $mysqli -> query("INSERT INTO inout_bonuses (id_inout,type,balance,note,total_bonus_id) VALUES ('$id_inout',1,'$bonus', 'pairing bonus', '".$x2['id']."')");
//     //         $mysqli -> query("UPDATE turnovers SET is_active = true WHERE id = $data->id");
//     //         if (!$mysqli -> commit()) {
//     //           echo "Commit transaction failed";
//     //           exit();
//     //         }
//     //         $mysqli -> rollback();
//     //     }else{
//     //         $x2 = $x -> fetch_assoc();
//     //         $balance = $bonus;
//     //         $id_inout = 'BI'.time().'-'.$data->owner;
//     //         $mysqli -> autocommit(FALSE);
//     //         $mysqli -> query("INSERT INTO total_bonuses (owner_id,balance) VALUES ('$data->owner','$balance')");
//     //         $mysqli -> query("INSERT INTO inout_bonuses (id_inout,type,balance,note,total_bonus_id) VALUES ('$id_inout',1,'$bonus', 'pairing bonus', '".$conn->insert_id."')");
//     //         $mysqli -> query("UPDATE turnovers SET is_active = true WHERE id = $data->id");
//     //         if (!$mysqli -> commit()) {
//     //           echo "Commit transaction failed";
//     //           exit();
//     //         }
//     //         $mysqli -> rollback();
//     //     }
//     // }
// }else{
//     echo "not found";
// }
// $conn->close();


 ?>