<?php


namespace Alura\Cursos\Controller;


use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Helper\FlashMessageTrait;
use Alura\Cursos\Infra\EntityManagerCreator;

class Persistencia implements InterfaceControladorRequisicao
{
    use FlashMessageTrait;

    private $entityManager;

    public function __construct()
    {
        $this->entityManager = (new EntityManagerCreator())->getEntityManager();
    }

    public function processaRequisicao(): void
    {
        $descricao = filter_input(
            INPUT_POST,
            'descricao',
            FILTER_SANITIZE_STRING
        );

        $curso = new Curso();
        $curso->setDescricao($_POST['descricao']);

        $id = filter_input(INPUT_GET,
            'id',
            FILTER_VALIDATE_INT
        );

        $tipo = 'success';
        if (!is_null($id) && $id) {
            $curso->setId($id);
            $this->entityManager->merge($curso);
            $this->defineMensagem($tipo, 'Curso atualizado com sucesso');

        } else {
            $this->entityManager->persist($curso);
            $this->defineMensagem($tipo, 'Curso inserido com sucesso');
        }

        $_SESSION['tipo_mensagem'] = 'success';

        $this->entityManager->flush();

        header("Location: /listar-cursos", true, 302);
    }
}