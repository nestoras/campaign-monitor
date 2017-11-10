<?php

namespace AppBundle\Subscriber;


interface MailerSubscriber 
{
    function __construct(string $apiKey, string $listId);

    public function subscribe(string $email, string $name): array;

    public function unsubscribe(string $email): array;
    
    public function isSubscribed(string $email): bool;
}