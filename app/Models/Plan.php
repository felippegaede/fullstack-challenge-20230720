<?php 
    namespace App\Models;

    use Exception;

    class Plan 
    {

        /**
         * Filtra e ordena a lista de planos de acordo com os critérios especificados.
         * 
         * @param array $sort Um array que define as chaves dinâmicas de ordenação e a direção (-1 para descendente, 1 para ascendente).
         * @return array Lista de planos filtrada e ordenada.
         */
        public function filterPlans(array $sort): array
        {
            // Inicia a filtragem padrão de acordo com os critérios do desafio
            if (!$sort) {
                $sort = [
                    'schedule.startDate' => -1,
                    'localidade.prioridade' => -1
                ];
            }

            try {
                list ($device, $plans) = $this->getPlansAndDevice();
            
                $plans = $this->removeInvalidPlans($plans); // Array de planos válidos.
                $plans = $this->orderPlans($plans, $sort);  // Array de planos válidos e ordenados.
                $plans = $this->removeDuplicatePlans($plans); // Array final filtrado.
    
                return ['device'=> $device, 'plans' => $plans];
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
                    isset($plan['name']) && strtotime($plan['schedule']['startDate']) < $now){
                    array_push($validPlans, $plan);
                }
            }
            return $validPlans ;
        }

        /**
         * Ordena os planos de acordo com os critérios definidos no array $sort.
         * 
         * @param array $plans Lista de planos a ser ordenada.
         * @param array $sort Um array que define as chaves dinâmicas de ordenação e a direção (-1 para descendente, 1 para ascendente).
         * @return array Lista de planos ordenada.
         */
        private function orderPlans(array $plans, array $sort): array
        {          
            // Usa a função usort para ordenar o array $plans com base nas chaves dinâmicas definidas em $sort
            usort($plans, function ($a, $b) use ($sort){
                foreach ($sort as $key => $value) {
                    $currentA = $a;
                    $currentB= $b;

                    // Divide a chave dinâmica em partes para acessar os valores desejados no array
                    $columns = explode('.', $key);

                    // Percorre as partes da chave dinâmica para acessar os valores correspondentes nos planos
                    foreach ($columns as $column) {
                        // Verifica se a coluna que se deseja ordenar existe, se não existir ignora.
                        if (!isset($currentA[$column]) || !isset($currentB[$column])) {
                            continue;
                        }
                        $currentA = $currentA[$column];
                        $currentB= $currentB[$column];
                    }

                    // Calcula o resultado da comparação com a direção de ordenação
                    $result = (-1 * $value) * ($currentB <=> $currentA);

                    // Se os valores são iguais, continua para a próxima chave de ordenação
                    if ($result === 0){
                        continue;
                    }

                    // Retorna o resultado da comparação para a ordenação
                    return $result;
                }
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