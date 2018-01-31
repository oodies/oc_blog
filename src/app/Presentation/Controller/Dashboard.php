<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2018/01
 */

namespace App\Presentation\Controller;

use Lib\Controller\Controller;

/**
 * Class Dashboard
 *
 * @package App\Presentation\Controller
 */
class Dashboard extends Controller
{

    /**
     * Dashboard homepage
     */
    public function indexAction()
    {
        echo $this->render('app:dashboard:index.html.twig', []);
    }
}
