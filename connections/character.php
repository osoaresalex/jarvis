<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
 if (isset($_GET['character-id'])) {
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

  $character_id = $_GET['character-id'];

  $ts = time();
  $public_key = 'd4a58cf8c0e5e8b52e96dd0b259ba123';
  $private_key = '9c325ba1b540e0dc45fbb98faf6934a8b170ef18';
  $hash = md5($ts . $private_key . $public_key);

  $query = array(
   'format' => 'comic',
   'formatType' => 'comic',
   'apikey' => $public_key,
   'ts' => $ts,
   'hash' => $hash,
  );

  curl_setopt($curl, CURLOPT_URL,
   "https://gateway.marvel.com:443/v1/public/characters/" . $character_id . "/comics" . "?" . http_build_query($query)
  );

  $result = json_decode(curl_exec($curl), true);

  curl_close($curl);

  echo json_encode($result);

 } else {
  echo "Identificação de personagem não definida";
 }
} else {
 echo "Erro: servidor errado.";
}