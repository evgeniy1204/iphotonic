<?php

namespace App\Service\Email;

interface EmailInterface
{
	public function getSubject(): string;
	public function getText(): string;
}