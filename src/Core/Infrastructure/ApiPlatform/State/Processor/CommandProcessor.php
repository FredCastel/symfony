<?php

declare(strict_types=1);

namespace Core\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\State\ProcessorInterface;
use Core\Application\Command\CommandException;
use Core\Application\Command\CommandRequest;
use Core\Application\Command\CommandResponse;
use Core\Application\Command\CommandUsedEntityException;
use Core\Application\Command\CommandValidatorException;
use Core\Application\Command\CommandVoterException;
use Core\Domain\Aggregate\AggregateValidationException;
use Core\Domain\ValueObject\ValueObjectException;
use Core\Infrastructure\ApiPlatform\Exception\ApiCommandValidatorException;
use Core\Infrastructure\ApiPlatform\Exception\ApiCommandVoterException;
use Core\Infrastructure\ApiPlatform\Exception\ApplicationException;
use Core\Service\Bus\Command\CommandBus;
use Core\Service\IdGenerator;

abstract class CommandProcessor implements ProcessorInterface
{

    public function __construct(
        protected CommandBus $commandBus,
        protected IdGenerator $idGen,
    ) {
    }

    /**
     * Summary of usedCommandRequests
     * @return CommandRequest[]
     */
    public abstract static function usedCommandRequests(): iterable;

    protected function dispatch(CommandRequest $command): CommandResponse
    {
        try {
            return $this->commandBus->dispatch($command);
        } catch (CommandVoterException $e) {
            throw new ApiCommandVoterException(notificationException: $e);
        } catch (CommandValidatorException $e) {
            throw new ApiCommandValidatorException(notificationException: $e);
        } catch (ValueObjectException $e) {
            throw new ApplicationException(message: $e->getMessage(), code: $e->getCode(), previous: $e);
        } catch (AggregateValidationException $e) {
            throw new ApplicationException(message: $e->getMessage(), code: $e->getCode(), previous: $e);
        } catch (CommandUsedEntityException $e) {
            throw new ApplicationException(message: $e->getMessage(), code: $e->getCode(), previous: $e);
        } catch (CommandException $e) {
            throw new ApplicationException(message: $e->getMessage(), code: $e->getCode(), previous: $e);
        } catch (\Throwable $th) {
            //TODO remode this, it is for test
            dd($th);
        }
    }

}