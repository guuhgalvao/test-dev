<?php
    require_once 'Carro.class.php';

    switch ($method) {
        case 'GET':
            $id = filter_var($id, FILTER_DEFAULT, FILTER_VALIDATE_INT);

            $car = new Carro();

            if (!empty($id)) {
                $response = $car->get($id);
                
                if ($response === 'nao_encontrado') {
                    http_response_code(404);
                    die('Registro nao encontrado');
                }
            } else {
                $response = $car->getAll();
            }

            if ($response) {
                http_response_code(200);
                header('Content-Type: application/json');
                die($response);
            } else {
                http_response_code(400);
                die('Erro ao processar requisicao');
            }
            break;

        case 'POST':
            $marca = filter_input(INPUT_POST, 'marca', FILTER_DEFAULT);
            $modelo = filter_input(INPUT_POST, 'modelo', FILTER_DEFAULT);
            $ano = filter_input(INPUT_POST, 'ano', FILTER_DEFAULT, FILTER_VALIDATE_INT);

            $car = new Carro();
            // $car->id = 1;
            $car->marca = $marca;
            $car->modelo = $modelo;
            $car->ano = $ano;
            
            if ($car->save()) {
                http_response_code(201);
                die('Registro adicionado');
            } else {
                http_response_code(400);
                die('Erro ao processar requisicao');
            }

            break;

        case 'PUT':
            try {
                $id = filter_var($id, FILTER_DEFAULT, FILTER_VALIDATE_INT);
                $marca = filter_input(INPUT_POST, 'marca', FILTER_DEFAULT);
                $modelo = filter_input(INPUT_POST, 'modelo', FILTER_DEFAULT);
                $ano = filter_input(INPUT_POST, 'ano', FILTER_DEFAULT, FILTER_VALIDATE_INT);
    
                $car = new Carro();
    
                if ($car->find($id)) {
                    $params = json_decode(file_get_contents("php://input"));

                    $car->marca = $params->marca;
                    $car->modelo = $params->modelo;
                    $car->ano = $params->ano;
                    
                    if ($car->update()) {
                        http_response_code(200);
                        die('Informacoes atualizadas');
                    } else {
                        http_response_code(400);
                        die('Erro ao processar requisicao');
                    }
                } else {
                    http_response_code(404);
                    die('Informacao nao encontrada');
                }
            } catch (Exception $e) {
                http_response_code(400);
                die("Exception: " . $e->getMessage());
            } catch (Error $e) {
                http_response_code(400);
                die("Error: " . $e->getMessage());
            }
            break;

        case 'DELETE':
            try {
                $id = filter_var($id, FILTER_DEFAULT, FILTER_VALIDATE_INT);
                $marca = filter_input(INPUT_POST, 'marca', FILTER_DEFAULT);
                $modelo = filter_input(INPUT_POST, 'modelo', FILTER_DEFAULT);
                $ano = filter_input(INPUT_POST, 'ano', FILTER_DEFAULT, FILTER_VALIDATE_INT);
    
                $car = new Carro();
    
                if ($car->find($id)) {                    
                    if ($car->delete()) {
                        http_response_code(200);
                        die('Registro removido');
                    } else {
                        http_response_code(400);
                        die('Erro ao processar requisicao');
                    }
                } else {
                    http_response_code(404);
                    die('Informacao nao encontrada');
                }
            } catch (Exception $e) {
                http_response_code(400);
                die("Exception: " . $e->getMessage());
            } catch (Error $e) {
                http_response_code(400);
                die("Error: " . $e->getMessage());
            }
            break;
    }