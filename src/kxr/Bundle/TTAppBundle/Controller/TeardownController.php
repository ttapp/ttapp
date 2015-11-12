<?php

namespace kxr\Bundle\TTAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Aws\Ec2\Ec2Client;
use Aws\Ec2\Exception\Ec2Exception;


class TeardownController extends Controller
{
    public function indexAction()
    {
	// This endpoint will send stop signal to all ec2 instances

	$Ec2Client = new Ec2Client ([
		'version' => 'latest',
		'region' => 'us-east-1'
	]);
	// Find the instance ids
	$reservations = $Ec2Client->DescribeInstances()['Reservations'];
 
        if (!$reservations) 
                return new Response( 'Sorry didnt find any instance by tag Type: "Autoscale"' );
	else
		$inst_list = [];
		foreach ( $reservations as $reservation)
			foreach ( $reservation['Instances'] as $instance )
				array_push( $inst_list, $instance['InstanceId']);
	try {
		$term_resp = $Ec2Client->terminateInstances(array(
			'DryRun' => true,
			'InstanceIds' => $inst_list,
			'Force' => true ) );
	}
	catch (Ec2Exception $e) {
		return new Response( "<pre>".print_r($e->getMessage(), true).</pre> );
	}
	return new Response( 'Terminating the following instances:'.
				'<pre>'.
				print_r($inst_list, true).
				'</pre>'.
				'Got the following respose:'.
				'<pre>'.
				print_r($term_resp, true).
				'</pre>'.
				'<hr />'
			);
    }
}
