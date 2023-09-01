<?php 
    namespace App\Models;

    use Exception;

    class Plan 
    {
        /**
         * Filtra e ordena a lista de planos de acordo com os critérios especificados.
         * 
         * @return array Lista de planos filtrada e ordenada.
         */
        public function filterPlans(): array
        {
            try {
                list ($device, $plans) = $this->getPlansAndDevice();
            
                $plans = $this->removeInvalidPlans($plans); // Array de planos válidos.
                $plans = $this->orderPlans($plans);  // Array de planos válidos e ordenados.
                $plans = $this->removeDuplicatePlans($plans); // Array final filtrado.
    
                return $plans;
            }catch(\Exception $e){
                return ['error' => $e->getMessage()];
            }
        }   
        
        /**
         * Lê o arquivo data.json e retorna o aparelho e a lista de planos.
         * 
         * @return array Array contendo o aparelho e a lista de planos.
         * @throws Exception Quando o arquivo data.json não é encontrado ou é inválido.
         */        
        private function getPlansAndDevice(): array
        {
            // Obtém o caminho para o arquivo data.json
            $jsonFilePath = dirname(dirname(__DIR__)) . '/data.json';

            // Verifica se o arquivo existe
            if (!file_exists($jsonFilePath )){
                throw new Exception('arquivo data.json não encontrado');
            }

            // Lê o conteúdo do arquivo data.json
            $json = file_get_contents($jsonFilePath);

            // Decodifica o JSON para um array associativo
            $data = json_decode($json, true);

            if (!$data || !isset($data['Aparelho']) || !isset($data['plans'])){
                throw new Exception('data.json inválido');
            }

            return [$data['Aparelho'], $data['plans']];
        }

        /**
         * Remove os planos inválidos que possuem startDate maior que a data atual ou que possuem algum problema na estrutura.
         * 
         * @param array $plans Lista de planos a ser filtrada.
         * @return array Lista de planos válidos.
         */
        private function removeInvalidPlans(array $plans): array
        {
            // Seta a data atual e converte em timestamp
            $now = strtotime(date("Y-m-d H:i:s"));

            $validPlans = [];

            foreach ($plans as $plan) {
                if (
                    isset($plan['schedule']['startDate']) && 
                    isset($plan['name']) && 
                    isset($plan['localidade']['prioridade']) && 
                    strtotime($plan['schedule']['startDate']) < $now
                ){
                    array_push($validPlans, $plan);
                }
            }
            return $validPlans ;
        }

        /**
         * Ordena os planos de acordo com a data de início e a prioridade da localidade.
         * 
         * @param array $plans Lista de planos a ser ordenada.
         * @return array Lista de planos ordenada.
         */
        private function orderPlans(array $plans): array
        {          
            usort($plans, function ($a, $b) {
                // retorna 1 quando $b for maior que $a, -1 quando $a for maior que $b e 0 quando $a e $b forem iguais
                $resultado = $b['schedule']['startDate'] <=> $a['schedule']['startDate'];

                // se a comparação anterior retornar 0 ($a igual a $b), faz uma nova comparação. Porém, desta vez pela localidade.
                return $resultado === 0 ? $b['localidade']['prioridade'] <=> $a['localidade']['prioridade'] : $resultado;
            });

            return $plans;
        }

        /**
         * Remove planos duplicados com base no nome, mantendo a preferência pela ordenação.
         * 
         * @param array $plans Lista de planos a ser filtrada.
         * @return array Lista de planos sem duplicatas.
         */
        private function removeDuplicatePlans(array $plans): array
        {
            $response = [];

            // Os planos já foram colocados na ordenação necessária na função orderPlans, então basta pegar o primeiro plano de cada nome 
            // para construir o array final com os planos filtrados.
            foreach ($plans as $plan) {
                if ( array_search($plan['name'], array_column($response, 'name') ) === false ){
                    array_push($response, $plan);
                }
            }
            
            return $response;
        }
    }