<?php
namespace CPSIT\Persons\Controller;

use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException;

/**
 * Class SignalTrait
 */
trait SignalTrait
{
    /**
     * @var Dispatcher
     */
    protected $signalSlotDispatcher;

    /**
     * Emits signals
     *
     * @param string $class Name of the signaling class
     * @param string $name Signal name
     * @param array $arguments Signal arguments
     * @codeCoverageIgnore
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
     */
    public function emitSignal(string $class, string $name, array &$arguments)
    {
        /**
         * Wrap arguments into array in order to allow changing the arguments
         * count. Dispatcher throws InvalidSlotReturnException if slotResult count
         * differs.
         */
        $slotResult = $this->signalSlotDispatcher->dispatch($class, $name, [$arguments]);
        $arguments = $slotResult[0]??[];
    }
}
