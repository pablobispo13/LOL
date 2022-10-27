<!DOCTYPE html>
<html lang="pt-BR">
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

<body onload="carregaConteiner();buscarDadosPartida();">

<div class="container animated bounceInDown" id="container">
    <div class="content">
        <div id="api">
            <br> <br> <br>
            <h5>Dados da ultima partida</h5>
            <div id="dados_buscapt">
            </div>
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
            $("#container").css('min-height', '80%');
            $("#container").css('min-width', '80%');

        }
        function buscarDadosPartida() {
                event.preventDefault();
                jQuery.ajax({
                    type: 'post',
                    url: 'testeApi_Match_v5.php',
                    dataType: 'json',
                    data:{'puuid':'<?=$_GET['puuid']?>'},
                    success: function (response) {
                        if (response.success == 'T') {
                            for (let dados in response.dados) {
                                jQuery.ajax({
                                    type: 'post',
                                    url: 'testeApi_Summoner_v4.php',
                                    dataType: 'json',
                                    data: {'nick_lol':response.dados[dados]},
                                    success: function (response) {
                                        if (response.success == 'T') {
                                            var info_invocadores = {
                                                nick: '',
                                                icone:'',
                                                nivel:''

                                            };
                                            for (let dados in response.dados) {
                                                if (dados == "profileIconId") {
                                                    info_invocadores["icone"]= response.dados[dados];
                                                } else if (dados == "name" ) {
                                                    info_invocadores["nick"]= response.dados[dados];
                                                }else if(dados == "summonerLevel"){
                                                    info_invocadores["nivel"]= response.dados[dados];
                                                }
                                            }
                                            adicionar_invocador(info_invocadores)
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
        function adicionar_invocador(dado){
            usu_dados =  document.getElementById('dados_buscapt');
            usu_dados.innerHTML +="<div class='invocadores'>" +
                "<h5>" + dado['nick'] + "</h5>" +
                "<img class='logo' id='pesquisapt_imagem' src='http://ddragon.leagueoflegends.com/cdn/12.19.1/img/profileicon/" +
                dado['icone']+ ".png'>"+
                "<h5>" + dado['nivel'] + "</h5>" +
                "</div>"
        }
    </script>

</body>
</html>