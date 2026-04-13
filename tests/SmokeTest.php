<?php

declare(strict_types=1);

use Iriven\PhpFormGenerator\Application\FormFactory;
use Iriven\PhpFormGenerator\Domain\Constraint\Required;
use Iriven\PhpFormGenerator\Domain\Field\CountryType;
use Iriven\PhpFormGenerator\Domain\Field\EmailType;
use Iriven\PhpFormGenerator\Domain\Field\FileType;
use Iriven\PhpFormGenerator\Domain\Field\TextType;
use Iriven\PhpFormGenerator\Infrastructure\Http\ArrayRequest;
use Iriven\PhpFormGenerator\Presentation\Html\HtmlRenderer;

require_once __DIR__ . '/../vendor/autoload.php';

$form = (new FormFactory())->createBuilder('contact', [], ['csrf_protection' => false])
    ->addFieldset([
        'legend' => 'Identity',
        'description' => 'Main identity data',
    ])
    ->add('email', EmailType::class, ['constraints' => [new Required()]])
    ->add('country', CountryType::class)
    ->endFieldset()
    ->addFieldset([
        'legend' => 'Uploads',
    ])
    ->add('attachment', FileType::class, [])
    ->endFieldset()
    ->add('name', TextType::class)
    ->getForm();

$form->handleRequest(new ArrayRequest([
    'contact' => [
        'email' => 'john@example.com',
        'country' => 'FR',
        'name' => 'John',
    ],
]));

assert($form->isSubmitted() === true);
assert($form->isValid() === true);

$html = (new HtmlRenderer())->renderForm($form->createView());
assert(str_contains($html, '<fieldset'));
assert(str_contains($html, '<legend>Identity</legend>'));
assert(str_contains($html, '<legend>Uploads</legend>'));
assert(str_contains($html, 'name="contact[email]"'));
assert(str_contains($html, 'name="contact[name]"'));
