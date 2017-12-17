<?php
/**
 * Created by PhpStorm.
 * User: Sébastien CHOMY
 * Date: 03/12/2017
 * Time: 23:10
 */
namespace Blogpost\Presentation\Controller;

use Lib\Controller\Controller;

/**
 * Class ContactUs
 * @package Blogpost\Presentation\Controller
 *
 */
class ContactUs extends Controller
{

    public function contactUsAction () {

        echo $this->render('blogpost:app:contactUs.html.twig', array());
    }
}