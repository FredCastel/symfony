<?php
declare(strict_types=1);

namespace Core\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Doctrine\Orm\State\ItemProvider;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Core\Application\Command\CommandVoter;
use Core\Application\Command\CommandVoterException;
use Core\Infrastructure\ApiPlatform\Resource\AllowedResource;
use Core\Infrastructure\ApiPlatform\State\Processor\CommandProcessor;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

class AllowedItemOperationProvider implements ProviderInterface
{
    /**
     * List of command voters with key
     * @var CommandVoter[] 
     */
    protected $voters = [];

    /**
     * Summary of __construct
     * @param \ApiPlatform\State\ProviderInterface $itemProvider
     * @param CommandVoter[] $voters
     */
    public function __construct(
        #[Autowire(service: ItemProvider::class)]
        protected ProviderInterface $itemProvider,
        #[AutowireIterator('ddd.command_voter')]
        iterable $voters
    ) {
        //make a list of voters
        foreach ($voters as $voter) {
            $this->voters[$voter->listenTo()] = $voter;
        }
    }


    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        /**
         * @var \Core\Infrastructure\Doctrine\DoctrineEntity
         */
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);
        if (!$entity) {
            return null;
        }
        $id = $entity->getId()->__tostring();

        $allowed = new AllowedResource();

        //get all resource operation that used a command request
        //use command voter on each of them to check if we could use this operation
        $reflection = new \ReflectionClass(objectOrClass: $context['resource_class']);
        foreach ($reflection->getAttributes(ApiResource::class) as $attribute) {
            /**
             * @var ApiResource
             */
            $apiResource = $attribute->newInstance();

            foreach ($apiResource->getOperations() as $op) {
                /**
                 * @var Operation
                 */
                $operation = $op;

                //Item operation only
                $processor = $operation->getProcessor();
                if ($processor) {

                    if (!call_user_func(callback: "$processor::isStatic")) {//only item processor (operation on an entity)

                        if (in_array(needle: CommandProcessor::class, haystack: class_parents(object_or_class: $processor))) {

                            //for each usedCommand in operation
                            foreach (call_user_func(callback: "$processor::usedCommandRequests") as $commandRequest) {
                                $voted = true;
                                if (key_exists(key: $commandRequest, array: $this->voters)) {
                                    try {
                                        $this->voters[$commandRequest]->voteFromId($id);
                                    } catch (CommandVoterException $e) {
                                        //voter refused this command, skip it
                                        $voted = false;
                                    }
                                }
                                if ($voted) {
                                    //add this operation to the allowed list
                                    $allowed->commands[] = $operation->getName();
                                }
                            }
                        }
                    }
                }
            }
        }

        return $allowed;
    }
}