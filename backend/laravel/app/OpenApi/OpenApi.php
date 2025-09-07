<?php

namespace App\OpenApi;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Minha API",
 *     version="1.0.0",
 *     description="Documentação gerada com L5-Swagger"
 * )
 * @OA\Server(
 *     url="/",
 *     description="Servidor local (base da app)"
 * )
 */
class OpenApi {} // classe “marcador” só para carregar as anotações
