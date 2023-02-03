<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController
{
    #[Route('/edit/{id}')]
    public function action(string $id): Response
    {
        return $this->render(
            'edit.html.twig',
            [
                'id' => $id
            ]
        );
    }
}