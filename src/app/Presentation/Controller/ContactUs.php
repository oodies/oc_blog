<?php
/**
 * Created by PhpStorm.
 * User: Sébastien CHOMY
 * Date: 03/12/2017
 * Time: 23:10
 */
namespace App\Presentation\Controller;

use Lib\Controller\Controller;

/**
 * Class ContactUs
 * @package App\Presentation\Controller
 *
 */
class ContactUs extends Controller
{

    public function contactUsAction () {

        echo $this->render('app:contactUS:contactUs.html.twig', array());
    }
}
