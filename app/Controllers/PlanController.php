<?php

namespace App\Controllers;

use App\Models\Plan;


/**
 * Controlador para manipulação de planos.
 */
class PlanController
{
    /**
     * Instância da classe de modelo de Planos.
     *
     * @var Plan
     */
    private $plan;

    /**
     * Construtor do controlador.
     *
     * @param Plan $plan Uma instância do modelo de Planos.
     */
    public function __construct(Plan $plan)
    {
        $this->plan = $plan;
    }

    /**
     * Método para obter uma lista de planos filtrados.
     * 
     * @param array $sort Um array que define as chaves dinâmicas de ordenação e a direção (-1 para descendente, 1 para ascendente).
     * @return array Um array contendo os planos filtrados.
     */
    public function get(array $sort): array
    {
        return $this->plan->filterPlans($sort);
    }
}