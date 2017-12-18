<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace App\Presentation\Controller;

use Lib\Controller\Controller;

/**
 * Class Homepage
 * @package App\Presentation\Controller
 */
class Homepage extends Controller
{
    /**
     *
     */
    public function homepageAction()
    {
        echo $this->render('app:homepage:homepage.html.twig', array());
    }
}