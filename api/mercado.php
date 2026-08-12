<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

echo json_encode([
    'status' => 'pendente',
    'mensagem' => 'A integracao com dados de mercado sera implementada na Fase 2.',
], JSON_UNESCAPED_UNICODE);
