<?php

namespace App\Controllers;

class Home extends BaseController
{
    private function inicializarTotem()
    {
        if (!session()->has('totem_id')) {
            helper('cookie');
            $cookieTotem = get_cookie('totem_id');
            if ($cookieTotem) {
                session()->set('totem_id', $cookieTotem);
            } else {
                // Gera um ID único aleatório temporário (ex: Totem-A47D)
                $randomSuffix = strtoupper(substr(md5(uniqid(rand(), true)), 0, 4));
                $defaultTotem = 'Totem-' . $randomSuffix;
                session()->set('totem_id', $defaultTotem);
                set_cookie('totem_id', $defaultTotem, 31536000 * 5); // 5 anos
            }
        }
    }

    public function index(): string
    {
        $this->inicializarTotem();

        // Se a ordem não foi iniciada, exibe a página de boas-vindas
        if (!session('ordem_iniciada')) {
            $data = [
                'titulo'   => 'Bem-vindo | Cantina IFFar',
                'totem_id' => session('totem_id'),
                'carrinho' => [] // Necessário para o layout base
            ];
            return view('pedidos/welcome', $data);
        }

        $client = \Config\Services::curlrequest();
        
        // Recupera o token configurado no arquivo .env
        $token = env('API_TOKEN');
        $apiUrl = rtrim(env('API_BASE_URL'), '/');
        
        try {
            // Realiza a requisição GET para a API
            $response = $client->request('GET', $apiUrl . '/api/produtos', [
                'headers' => [
                    'apiKey' =>  $token,
                    'Accept'        => 'application/json',
                ]
            ]);
            
            $produtos = json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            $produtos = []; // Fallback em caso de erro na API
            log_message('error', 'Erro ao recuperar produtos da API: ' . $e->getMessage());
        }

        $data = [
            'produtos' => $produtos['produtos'] ?? [],
            'carrinho' => $produtos['pedidos_produtos'] ?? []
        ];
        
        // Armazena os dados atuais do carrinho na sessão
        session()->set('carrinho', $data['carrinho']);

        return view('pedidos/listagem', $data);
    }

    public function iniciarPedido()
    {
        $this->inicializarTotem();
        session()->set('ordem_iniciada', true);
        return redirect()->to('/pedidos');
    }

    public function configurarTotem()
    {
        $totemId = $this->request->getPost('totem_id');
        if (!empty($totemId)) {
            session()->set('totem_id', $totemId);
            helper('cookie');
            set_cookie('totem_id', $totemId, 31536000 * 5); // 5 anos
        }
        return redirect()->to('/pedidos');
    }
}
