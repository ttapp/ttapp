<?php

namespace kxr\Bundle\TTAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class SetupController extends Controller
{
    public function indexAction(Request $request)
    {
        $webhook_post = $request->request->get('test');
	$fs = new Filesystem();
	$fs->dumpFile('/tmp/setup_postdata', var_dump($webhook_post) );
        return new Response( 'dadaadada' );

    }
}
