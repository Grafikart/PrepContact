<?php

namespace App\Serializer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ConstraintViolationListNormalizer implements NormalizerInterface
{

    public function supportsNormalization($data, $format = null): bool
    {
        return $format === 'jsonproblem' && $data instanceof ConstraintViolationListInterface;
    }

    /**
     * Constra
     * @param ConstraintViolationListInterface $object
     * @param string $format
     * @param array $context
     * @return array
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $errors = [];
        return [
            'errors' => $this->getMessagesAndViolations($object)
        ];
    }

    protected function getMessagesAndViolations(ConstraintViolationListInterface $constraintViolationList): array
    {
        $messages = [];

        foreach ($constraintViolationList as $violation) {
            $messages[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $messages;
    }
}
