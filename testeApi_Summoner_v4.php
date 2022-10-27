<?php
include_once('api_key.php');
//Pegar usuario pelo nick
//https://reqbin.com/curl - nele coloca curl --insecure (link da api para montar o codigo curl php)
try {
    $nick = urlencode($_POST['nick_lol']);
    if(strlen($nick)>20){
    //SEMPRE ADICIONAR A VARIAVEL API_KEY DO ARQUIVO api_key.php
    $url = "https://br1.api.riotgames.com/lol/summoner/v4/summoners/by-puuid/" . $nick . "?".$api_key;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $dados_pelo_nick = curl_exec($curl);
    curl_close($curl);
    $dados_pelo_nick = json_decode($dados_pelo_nick, true);
    if (array_key_exists('status', $dados_pelo_nick)) {
        if ($dados_pelo_nick['status']['message'] == 'Data not found - summoner not found') {
            echo json_encode(['success' => 'F', 'mensagem' => 'Não foi encontrado nenhum invocador com esse nick']);
        }
    } else {
        echo json_encode(['success' => 'T', 'mensagem' => '', 'dados' => $dados_pelo_nick]);
    }
    }
    else {
        //SEMPRE ADICIONAR A VARIAVEL API_KEY DO ARQUIVO api_key.php
        $url = "https://br1.api.riotgames.com/lol/summoner/v4/summoners/by-name/" . $nick . "?" . $api_key;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $dados_pelo_nick = curl_exec($curl);
        curl_close($curl);
        $dados_pelo_nick = json_decode($dados_pelo_nick, true);
        if (array_key_exists('status', $dados_pelo_nick)) {
            if ($dados_pelo_nick['status']['message'] == 'Data not found - summoner not found') {
                echo json_encode(['success' => 'F', 'mensagem' => 'Não foi encontrado nenhum invocador com esse nick']);
            }
        } else {
            echo json_encode(['success' => 'T', 'mensagem' => '', 'dados' => $dados_pelo_nick]);

        }
    }
} catch (Exception $e) {
    echo json_encode(['success' => 'F', 'mensagem' => $e]);
}
?>
