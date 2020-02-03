<?php

use Alura\Cursos\Controller\{Exclusao, FormularioEdicao, FormularioInsercao, ListarCursos, Persistencia};

return [
    '/listar-cursos' => ListarCursos::class,
    '/novo-curso' => FormularioInsercao::class,
    '/salvar-curso' => Persistencia::class,
    '/excluir-curso' => Exclusao::class,
    '/alterar-curso' => FormularioEdicao::class
];