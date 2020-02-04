<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Usuario;
use Alura\Cursos\Helper\FlashMessageTrait;
use Alura\Cursos\Infra\EntityManagerCreator;
use Doctrine\Common\Persistence\ObjectRepository;

class RealizarLogin implements InterfaceControladorRequisicao
{
    use FlashMessageTrait;

    /**
     * @var ObjectRepository
     */
    private $repositorioDeUsuarios;

    public function __construct()
    {
        $entityManager = (new EntityManagerCreator())->getEntityManager();
        $this->repositorioDeUsuarios = $entityManager->getRepository(Usuario::class);
    }

    public function processaRequisicao(): void
    {
        $email = filter_input(
            INPUT_POST,
            'email',
            FILTER_VALIDATE_EMAIL
        );

        if ($email === false || is_null($email)) {
            $this->defineMensagem('danger', 'O email digitado é invalido');
            header('Location: /login');
            return;
        }

        $senha = filter_input(
            INPUT_POST,
            'senha',
            FILTER_SANITIZE_STRING
        );

        /** @var Usuario $usuario */
        $usuario = $this->repositorioDeUsuarios
            ->findOneBy(['email' => $email]);

        if (is_null($usuario) || !$usuario->senhaEstaCorreta($senha)) {
            $this->defineMensagem('danger', 'Email ou senha invalidos');
            header('Location: /login');
            return;
        }

        $_SESSION['logado'] = true;

        header('Location: /listar-cursos');
    }
}