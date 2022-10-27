<!DOCTYPE html>
<html lang="pt-BR">
<?php session_start();?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/animate.min.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/api_lol.css"/>
    <link rel="icon" type="image/png" href="https://pngimg.com/uploads/pacman/pacman_PNG87.png"/>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/sweetalert.js"></script>
    <script src="assets/js/forcasenha.js"></script>
    <title>Consumindo API LOL</title>
</head>

<body onload="carregaConteiner();">

<div class="container animated bounceInDown" id="container">
    <div class="content">
        <div id="api">
            <img class="logo" src="assets/images/logo.png">
            <br> <br> <br>
            <h5>Pegar dados da conta LoL</h5>
            <form method="post" id="form-api" class="form">
                <h5>Nickname</h5>
                <input type="text" required="required" name="nick_lol" placeholder="Dianä agiota">
                <input type="submit" onclick="apiLoL()" value="Buscar dados" class="btn-action"><br><br><br>
            </form>
            <br> <br> <br>
            <div id="dados"></div>
        </div>
    </div>
    <script>
        //Verifica se o usuario voltou uma pagina.
        window.addEventListener('popstate', function () {
            carregaConteiner();
        });
var puiid ='';
        // Função que carrega o tamanho inicial do container com base na url que o usuario se encontra
        function carregaConteiner() {
            $("#container").css('min-height', '380px');
        }

        function apiLoL() {
            var nick = $("#nick_lol").val();
            if (nick == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Preencha os campos para logar no site!',

                });
            } else {
                event.preventDefault();
                jQuery.ajax({
                    type: 'post',
                    url: 'testeApi_Summoner_v4.php',
                    dataType: 'json',
                    data: $('#form-api').serialize(),
                    success: function (response) {
                        if (response.success == 'T') {

                            usu_dados =  document.getElementById('dados');
                            $('#dados').empty();
                            for (let dados in response.dados) {
                                if (dados == "profileIconId") {
                                    usu_dados.innerHTML +=
                                        "<img class='logo' src='http://ddragon.leagueoflegends.com/cdn/12.19.1/img/profileicon/" +
                                        response.dados[dados] + ".png'>";
                                } else if (dados == "name" || dados == "summonerLevel") {
                                    usu_dados.innerHTML += '<h5>' +
                                        response.dados[dados] + '</h5>';
                                }
                                else if (dados == "puuid") {
                                    puuid = response.dados[dados];
                                }
                            }
                            usu_dados.innerHTML += "<button id='buscarPartida_bt' onclick='redirect(puuid);' class='btn-action'>Buscar ultima partida</button>"

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: response.mensagem,
                                showConfirmButton: false,
                                timer: 2500
                            })
                        }
                    }
                });
            }
        }
        function redirect(puuid){
            location.href='buscarUltimaPartida.php?puuid='+puuid;
        }
    </script>

</body>
</html>