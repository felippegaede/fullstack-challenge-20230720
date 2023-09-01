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
     * @return array Um array contendo os planos filtrados.
     */
    public function get(): array
    {
        return $this->plan->filterPlans();
    }
}