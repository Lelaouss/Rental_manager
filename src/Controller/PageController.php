<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PageController extends AbstractController
{
	/**
	 * @return Response
	 */
    public function home(): Response
    {
        return $this->render('pages/homepage.html.twig');
    }
}
