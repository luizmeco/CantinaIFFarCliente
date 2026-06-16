<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
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
}
