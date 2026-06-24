<?php

namespace App\Controllers;
use App\Controllers\BaseController;

class Pedidos extends BaseController
{

    private $token;
    private $client;
    private $apiUrl;

    public function __construct()
    {
        $this->token = env('API_TOKEN');
        $this->client = \Config\Services::curlrequest();
        $this->apiUrl = rtrim(env('API_BASE_URL'), '/');
    }


    public function carrinho()
    {
        $carrinho = session('carrinho') ?? [];
        
        $total = 0;
        foreach ($carrinho as $item) {
            $preco = $item['preco'] ?? $item['preco_unitario'] ?? 0;
            $total += $preco * $item['quantidade'];
        }

        $data = [
            'titulo' => 'Seu Carrinho',
            'carrinho' => $carrinho,
            'total' => $total,
        ];

        return view('pedidos/carrinho', $data);
    }

    public function adicionarCarrinho($produtoId)
    {
        $client = $this->client;
        $idPedido = session('id_pedido');
        
        $dados = [
            'id_produto' => $produtoId
        ];
        
        if ($idPedido) {
            $dados['id_pedido'] = $idPedido;
        }

        try {
            // Realiza a requisição POST para a API com os dados em JSON
            $response = $client->request('POST', $this->apiUrl . '/api/adicionarAoCarrinho', [
                'headers' => [
                    'apiKey' =>  $this->token,
                    'Accept' => 'application/json',
                ],
                'json' => $dados
            ]);
            
            $resultado = json_decode($response->getBody(), true);
            
            // Salva o id_pedido retornado na sessão para próximos itens
            if (isset($resultado['id_pedido'])) {
                session()->set('id_pedido', $resultado['id_pedido']);
            }
            
            log_message('info', 'Produto adicionado na API com sucesso: ' . print_r($resultado, true));
        } catch (\Exception $e) {
            log_message('error', 'Erro ao adicionar produto na API: ' . $e->getMessage());
        }

        // Atualiza o carrinho na sessão local para a interface
        $carrinho = session('carrinho') ?? [];
        $encontrado = false;

        foreach ($carrinho as &$item) {
            $idItem = $item['id_produto'] ?? $item['id'];
            if ($idItem == $produtoId) {
                $item['quantidade']++;
                $encontrado = true;
                break;
            }
        }

        session()->set('carrinho', $carrinho);

        return redirect()->to('/pedidos');
    }

    public function removerCarrinho($produtoId)
    {
        $idPedido = session('id_pedido');

        // Se existe um pedido na API, notifica a remoção
        if ($idPedido) {
            try {
                // Assumindo um endpoint 'removerItemPedido' na sua API
                $this->client->request('POST', $this->apiUrl . '/api/removerItemPedido', [
                    'headers' => [
                        'apiKey' => $this->token,
                        'Accept' => 'application/json',
                    ],
                    'json' => [
                        'id_pedido'  => $idPedido,
                        'id_produto' => $produtoId,
                    ],
                ]);
            } catch (\Exception $e) {
                log_message('error', "Erro ao remover produto {$produtoId} do pedido {$idPedido} via API: " . $e->getMessage());
            }
        }

        $carrinho = session('carrinho') ?? [];
        
        $novoCarrinho = [];
        foreach ($carrinho as $item) {
            $idItem = $item['id_produto'] ?? $item['id'];
            if ($idItem != $produtoId) {
                $novoCarrinho[] = $item;
            }
        }

        session()->set('carrinho', $novoCarrinho);
        return redirect()->to('/pedidos/carrinho');
    }

    public function atualizarQuantidade($produtoId, $quantidade)
    {
        if ((int)$quantidade <= 0) {
            return $this->removerCarrinho($produtoId);
        }

        $idPedido = session('id_pedido');

        // Se existe um pedido na API, notifica a alteração de quantidade
        if ($idPedido) {
            try {
                // Assumindo um endpoint 'atualizarItemPedido' na sua API
                $this->client->request('POST', $this->apiUrl . '/api/atualizarItemPedido', [
                    'headers' => [
                        'apiKey' => $this->token,
                        'Accept' => 'application/json',
                    ],
                    'json' => [
                        'id_pedido'  => $idPedido,
                        'id_produto' => $produtoId,
                        'quantidade' => (int) $quantidade,
                    ],
                ]);
                log_message('info', "Quantidade do produto {$produtoId} no pedido {$idPedido} atualizada para {$quantidade} via API.");
            } catch (\Exception $e) {
                log_message('error', 'Erro ao atualizar quantidade do item via API: ' . $e->getMessage());
            }
        }
        $carrinho = session('carrinho') ?? [];

        foreach ($carrinho as &$item) {
            $idItem = $item['id_produto'] ?? $item['id'];
            if ($idItem == $produtoId) {
                $item['quantidade'] = (int)$quantidade;
                break;
            }
        }

        session()->set('carrinho', $carrinho);
        return redirect()->to('/pedidos/carrinho');
    }

    public function confirmarPedido()
    {
        $carrinho = session('carrinho') ?? [];
        $idPedido = session('id_pedido');

        if (empty($carrinho)) {
            return redirect()->to('/pedidos');
        }
        
        // Se existir um pedido aberto, notifica a API para finalizá-lo
        if ($idPedido) {
            try {
                $this->client->request('POST', $this->apiUrl . '/api/concluirPedido', [
                    'headers' => [
                        'apiKey' => $this->token,
                        'Accept' => 'application/json',
                    ],
                    'json' => [
                        'id_pedido' => $idPedido,
                    ],
                ]);
                log_message('info', "Pedido {$idPedido} finalizado com sucesso na API.");
            } catch (\Exception $e) {
                log_message('error', "Erro ao finalizar pedido {$idPedido} via API: " . $e->getMessage());
            }
        }

        $total = 0;
        foreach ($carrinho as $item) {
            $preco = $item['preco'] ?? $item['preco_unitario'] ?? 0;
            $total += $preco * $item['quantidade'];
        }

        // Usar número do pedido da API se existir
        $numeroPedido = $idPedido ? str_pad($idPedido, 3, '0', STR_PAD_LEFT) : str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);

        $data = [
            'titulo' => 'Pedido Confirmado',
            'pedido' => [
                'numero' => $numeroPedido,
                'itens' => $carrinho,
                'total' => $total,
                'data' => date('d/m/Y H:i')
            ]
        ];

        // Limpar carrinho
        session()->remove('carrinho');
        session()->remove('id_pedido');

        return view('pedidos/ticket', $data);
    }

    public function novopedido()
    {
        session()->remove('carrinho');
        session()->remove('id_pedido');
        return redirect()->to('/pedidos');
    }
}
