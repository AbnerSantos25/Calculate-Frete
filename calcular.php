<?php
function calcularFrete($peso, $largura, $altura, $comprimento, $valor) {
    $token = "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNzlkMjM1NWMwMWQxMGQ4NWZkZjgzYzMzYjJlOWRlMTViMzFhOWI3YmFhYzg1ODUzMmI4NGQ3ZjM3MjdhNmQwZTliNjg0Y2U1OTYxZmQ4ZWUiLCJpYXQiOjE3MjU5MDM5MDQuOTIyNDI1LCJuYmYiOjE3MjU5MDM5MDQuOTIyNDI3LCJleHAiOjE3NTc0Mzk5MDQuOTA4ODk2LCJzdWIiOiIyZTE5ZWY1Yy1iYTMwLTQ4NTEtYmQ2My01NWNhMzVjMDhmMzAiLCJzY29wZXMiOlsic2hpcHBpbmctY2FsY3VsYXRlIl19.Li3dIVZudbuahV8oyHmsrgPZ4d_EUsgcY7_0AhzRlycKCphVL15_bvc6k-sOef20uFUhXkGQHCMCckwcEM9VRXehS0htQqF0PaYLIIgq64nODs7f-upegGVHJNO1-xEnxQwFae7MqtbNfSGMTv09ejnw2BR4_hJwkbCjuhP7UfSJx2yV0mIZYlqoGrmrqU7GzdlmUdV1rqH-PC9AHCvUy_VICpd1eGylioo1KOofXP24yTMuZf8QYOUDFA_DUCWDrmJxfyOULe39JmSyuyi53G8fwqyVMBznS5X15pQL7WIFadl789XCbCeZnt7kaiz9Thy1YQY6lalae7bwCASmHmqb2uLCA_crn-VttLemlDSO1CuuBcM89x5lNHSQunxJxq34Xj4eWtZoI3sYb5xuAEJfrt6BIUlBizbb1Q6wwNQN0abGy8df8yHFMcqIkte7eCxvq5l9c0C-i6hHuglEBUYn6k9JTUeptei4s6ddelwpIat-Pat5glaQF4HP7iXrXjUrO_m3YCw3l-_FkdGhJ1wBzuCTEuRbqOw-DxCyJY-bbkpIeHGrBfjpQ0ZfUGT2F8ogmPlP7m8rReq07Pb34HGqNuzozvoE9PHAfSlrmuZd4wpxK54R17Yvekh69iOnHKpH9GxxH9l9YOEIIm0hfa8P6df87yTHy9ahQJZzmC4";
   

    $url = 'https://www.melhorenvio.com.br/api/v2/me/shipment/calculate';

    // Dados do pedido
    $data = [
        'from' => ['postal_code' => '14780001'], // Substitua pelo CEP de origem da sua loja
        'to' => ['postal_code' => '88058971'],
        'products' => [
            [
                'id' => 'x',
                'width' => $largura, // Largura em centímetros
                'height' => $altura, // Altura em centímetros
                'length' => $comprimento, // Comprimento em centímetros
                'weight' => $peso, // Peso em quilogramas
                'insurance_value' => $valor // Valor do produto
            ]
        ],
        'services' => '1,2', // IDs dos serviços que você deseja usar (Correios, Jadlog, etc.)
    ];

    // Configuração do cabeçalho
    $options = [
        'http' => [
            'header' => [
                "Accept: application/json",
                "Authorization:$token",
                "Content-Type: application/json",
                "User-Agent: Apresentação abysantos2509@gmail.com"
            ],
            'method' => 'POST',
            'content' => json_encode($data)
        ]
    ];

    // Cria o contexto da requisição
    $context = stream_context_create($options);

    // Faz a requisição
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        return ['error' => 'Erro ao calcular frete'];
    }

    // Converte a resposta para um array
    return json_decode($result, true);
}

// Exemplo de uso da função 
$peso = 1;               // Peso em kg
$largura = 11;             // Largura em cm
$altura = 17;               // Altura em cm
$comprimento = 11;         // Comprimento em cm
$valor = 10.1; 

// Executar o cálculo
$resultadoFrete = calcularFrete($peso, $largura, $altura, $comprimento, $valor);

// Enviar a resposta de volta para o Shopify
header('Content-Type: application/json');
echo json_encode($resultadoFrete);
?>
