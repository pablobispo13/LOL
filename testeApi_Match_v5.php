<?php
include_once('api_key.php');
//Pegar usuario pelo nick
//https://reqbin.com/curl - nele coloca curl --insecure (link da api para montar o codigo curl php)
try {
    $puuid = urlencode($_POST['puuid']);
//SEMPRE ADICIONAR A VARIAVEL API_KEY DO ARQUIVO api_key.php
    $url = "https://americas.api.riotgames.com/lol/match/v5/matches/by-puuid/" .$puuid."/ids?start=0&count=1&". $api_key;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $busca_id_partida = curl_exec($curl);
    curl_close($curl);
    $busca_id_partida = json_decode($busca_id_partida, true);
//SEMPRE ADICIONAR A VARIAVEL API_KEY DO ARQUIVO api_key.php
    $url = "https://americas.api.riotgames.com/lol/match/v5/matches/" . $busca_id_partida[0] ."?". $api_key;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $dados_da_partida = curl_exec($curl);
    curl_close($curl);


    $dados_da_partida = json_decode($dados_da_partida, true);
    if (array_key_exists('status', $dados_da_partida)) {
            echo json_encode(['success' => 'F', 'mensagem' => 'Não foi encontrada nenhuma partida']);
    } else {
        echo json_encode(['success' => 'T', 'mensagem' => '', 'dados' => $dados_da_partida['metadata']['participants']]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => 'F', 'mensagem' => $e]);
}
?>
