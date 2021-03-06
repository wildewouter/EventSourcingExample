<?php


namespace Aggregate;


use Buttercup\Protects\IdentifiesAggregate;
use Exception\IncorrectTypeException;

class AccountId implements IdentifiesAggregate
{
    /** @var string */
    private $accountId;

    private function __construct($id)
    {
        $this->accountId = $id;
    }

    /**
     * Creates an identifier object from a string representation
     * @param $string
     * @return IdentifiesAggregate
     * @throws IncorrectTypeException
     */
    public static function fromString($string)
    {
        if (! is_string($string)) {
            throw new IncorrectTypeException('Provided type should be string');
        }
        return new AccountId($string);
    }

    /**
     * Returns a string that can be parsed by fromString()
     * @return string
     */
    public function __toString()
    {
        return $this->accountId;
    }

    /**
     * Compares the object to another IdentifiesAggregate object. Returns true if both have the same type and value.
     * @param $other
     * @return boolean
     */
    public function equals(IdentifiesAggregate $other)
    {
        return $other->__toString() === $this->__toString();
    }
}