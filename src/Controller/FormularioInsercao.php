<?php

namespace Alura\Cursos\Controller;

class FormularioInsercao implements InterfaceControladorRequisicao
{

    public function processaRequisicao(): void
    {
        $titulo = 'Novo curso';
        require __DIR__ . '/../../view/cursos/formulario.php';
    }
}