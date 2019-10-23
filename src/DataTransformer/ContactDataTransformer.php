<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Data\ContactData;
use App\Entity\Contact;

class ContactDataTransformer implements DataTransformerInterface
{

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Transforms the given object to something else, usually another object.
     * This must return the original object if no transformation has been done.
     *
     * @param ContactData $object
     *
     * @return Contact
     */
    public function transform($object, string $to, array $context = [])
    {
        $this->validator->validate($object);
        return Contact::fromForm($object);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return $to === Contact::class && $context['input']['class'] === ContactData::class;
    }
}
