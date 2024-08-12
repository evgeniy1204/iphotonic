<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\EmailDto;
use App\Service\Email\EmailBuilder\ProductEmailBuilder;
use App\Service\Email\EmailRequest;
use App\Service\Email\EmailSender;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class MailerController extends AbstractController
{
	#[Route('/send-email', name: 'send_email', methods: [Request::METHOD_POST])]
	public function sendEmail(
		#[MapRequestPayload]
		EmailRequest $emailRequest,
		EmailSender $emailSender,
		ProductEmailBuilder $productEmailBuilder
	): Response {
		if (!$emailRequest->check && $emailRequest->product) {
			$emailSender->send($productEmailBuilder->buildEmail(
				$emailRequest->product,
				new EmailDto($emailRequest->product, $emailRequest->name, $emailRequest->email, $emailRequest->message)
			));
		}

		return new Response();
	}
}