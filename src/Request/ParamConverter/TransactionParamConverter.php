<?php

declare(strict_types=1);

namespace App\Request\ParamConverter;

use App\Builder\TransactionBuilderInterface;
use App\Repository\TransactionRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

readonly class TransactionParamConverter implements ParamConverterInterface
{
    public function __construct(
        private TransactionBuilderInterface $builder,
        private TransactionRepositoryInterface $repository,
    ){}

    public function apply(Request $request, ParamConverter $configuration)
    {
        if (
            $id = $request->attributes->get('id') ?? $request->toArray()['id'] ?? null
        ) {
            $transaction = $this->repository->findOne((string)$id);
        } else {
            $transaction = $this->builder->buildFromArray($request->toArray());
        }

        $request->attributes->set('transaction', $transaction);

        return true;
    }

    public function supports(ParamConverter $configuration)
    {
        // return false if configuration is not loaded
        if (null === $configuration->getClass()) {
            return false;
        }

        if ($configuration->getName() !== 'transaction') {
            return false;
        }

        return true;
    }
}