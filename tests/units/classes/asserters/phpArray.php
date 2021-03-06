<?php

namespace mageekguy\atoum\tests\units\asserters;

use
	mageekguy\atoum,
	mageekguy\atoum\asserter,
	mageekguy\atoum\asserters
;

require_once __DIR__ . '/../../runner.php';

class phpArray extends atoum\test
{
	public function testClass()
	{
		$this->assert
			->testedClass->isSubclassOf('mageekguy\atoum\asserters\variable')
		;
	}

	public function test__construct()
	{
		$asserter = new asserters\phpArray($generator = new asserter\generator($this));

		$this->assert
			->object($asserter->getScore())->isIdenticalTo($this->getScore())
			->object($asserter->getLocale())->isIdenticalTo($this->getLocale())
			->object($asserter->getGenerator())->isIdenticalTo($generator)
			->variable($asserter->getValue())->isNull()
			->boolean($asserter->wasSet())->isFalse()
		;
	}

	public function testSetWith()
	{
		$asserter = new asserters\phpArray(new asserter\generator($test = new self($score = new atoum\score())));

		$this->assert
			->exception(function() use (& $line, $asserter, & $value) { $line = __LINE__; $asserter->setWith($value = uniqid()); })
				->isInstanceOf('mageekguy\atoum\asserter\exception')
				->hasMessage(sprintf($test->getLocale()->_('%s is not an array'), $asserter->getTypeOf($value)))
			->integer($score->getFailNumber())->isEqualTo(1)
			->array($score->getFailAssertions())->isEqualTo(array(
					array(
						'case' => null,
						'class' => __CLASS__,
						'method' => $test->getCurrentMethod(),
						'file' => __FILE__,
						'line' => $line,
						'asserter' => get_class($asserter) . '::setWith()',
						'fail' => sprintf($test->getLocale()->_('%s is not an array'), $asserter->getTypeOf($value))
					)
				)
			)
			->integer($score->getPassNumber())->isZero()
			->string($asserter->getValue())->isEqualTo($value)
		;

		$this->assert
			->object($asserter->setWith($value = array()))->isIdenticalTo($asserter); $line = __LINE__
		;

		$this->assert
			->integer($score->getFailNumber())->isEqualTo(1)
			->integer($score->getPassNumber())->isEqualTo(1)
			->array($asserter->getValue())->isEqualTo($value)
		;
	}

	public function testHasSize()
	{
		$asserter = new asserters\phpArray(new asserter\generator($test = new self($score = new atoum\score())));

		$this->assert
			->boolean($asserter->wasSet())->isFalse()
			->exception(function() use ($asserter) {
					$asserter->hasSize(rand(0, PHP_INT_MAX));
				}
			)
				->isInstanceOf('mageekguy\atoum\exceptions\logic')
				->hasMessage('Array is undefined')
		;

		$asserter->setWith(array());

		$score->reset();

		$this->assert
			->exception(function() use (& $line, $asserter, & $size) { $line = __LINE__; $asserter->hasSize($size = rand(1, PHP_INT_MAX)); })
				->isInstanceOf('mageekguy\atoum\asserter\exception')
				->hasMessage(sprintf($test->getLocale()->_('%s does not have size %d'), $asserter, $size))
			->integer($score->getPassNumber())->isEqualTo(0)
			->integer($score->getFailNumber())->isEqualTo(1)
			->array($score->getFailAssertions())->isEqualTo(array(
					array(
						'case' => null,
						'class' => __CLASS__,
						'method' => $test->getCurrentMethod(),
						'file' => __FILE__,
						'line' => $line,
						'asserter' => get_class($asserter) . '::hasSize()',
						'fail' => $failMessage = sprintf($test->getLocale()->_('%s does not have size %d'), $asserter, $size)
					)
				)
			)
		;

		$this->assert
			->object($asserter->hasSize(0))->isIdenticalTo($asserter)
			->integer($score->getPassNumber())->isEqualTo(1)
			->integer($score->getFailNumber())->isEqualTo(1)
		;
	}

	public function testIsEmpty()
	{
		$asserter = new asserters\phpArray(new asserter\generator($test = new self($score = new atoum\score())));

		$this->assert
			->boolean($asserter->wasSet())->isFalse()
			->exception(function() use ($asserter) {
					$asserter->isEmpty();
				}
			)
				->isInstanceOf('mageekguy\atoum\exceptions\logic')
				->hasMessage('Array is undefined')
		;

		$asserter->setWith(array(uniqid()));

		$score->reset();

		$this->assert
			->exception(function() use (& $line, $asserter) { $line = __LINE__; $asserter->isEmpty(); })
				->isInstanceOf('mageekguy\atoum\asserter\exception')
				->hasMessage(sprintf($test->getLocale()->_('%s is not empty'), $asserter))
			->integer($score->getPassNumber())->isEqualTo(0)
			->integer($score->getFailNumber())->isEqualTo(1)
			->array($score->getFailAssertions())->isEqualTo(array(
					array(
						'case' => null,
						'class' => __CLASS__,
						'method' => $test->getCurrentMethod(),
						'file' => __FILE__,
						'line' => $line,
						'asserter' => get_class($asserter) . '::isEmpty()',
						'fail' => $failMessage = sprintf($test->getLocale()->_('%s is not empty'), $asserter)
					)
				)
			)
		;

		$asserter->setWith(array());

		$score->reset();

		$this->assert
			->object($asserter->isEmpty())->isIdenticalTo($asserter)
			->integer($score->getPassNumber())->isEqualTo(1)
			->integer($score->getFailNumber())->isZero()
		;
	}

	public function testIsNotEmpty()
	{
		$asserter = new asserters\phpArray(new asserter\generator($test = new self($score = new atoum\score())));

		$this->assert
			->boolean($asserter->wasSet())->isFalse()
			->exception(function() use ($asserter) {
					$asserter->isNotEmpty();
				}
			)
				->isInstanceOf('mageekguy\atoum\exceptions\logic')
				->hasMessage('Array is undefined')
		;

		$asserter->setWith(array());

		$score->reset();

		$this->assert
			->exception(function() use (& $line, $asserter) { $line = __LINE__; $asserter->isNotEmpty(); })
				->isInstanceOf('mageekguy\atoum\asserter\exception')
				->hasMessage(sprintf($test->getLocale()->_('%s is empty'), $asserter))
			->integer($score->getPassNumber())->isEqualTo(0)
			->integer($score->getFailNumber())->isEqualTo(1)
			->array($score->getFailAssertions())->isEqualTo(array(
					array(
						'case' => null,
						'class' => __CLASS__,
						'method' => $test->getCurrentMethod(),
						'file' => __FILE__,
						'line' => $line,
						'asserter' => get_class($asserter) . '::isNotEmpty()',
						'fail' => $failMessage = sprintf($test->getLocale()->_('%s is empty'), $asserter)
					)
				)
			)
		;

		$asserter->setWith(array(uniqid()));

		$score->reset();

		$this->assert
			->object($asserter->isNotEmpty())->isIdenticalTo($asserter)
			->integer($score->getPassNumber())->isEqualTo(1)
			->integer($score->getFailNumber())->isZero()
		;
    }

	public function testContains()
	{
		$asserter = new asserters\phpArray(new asserter\generator($test = new self($score = new atoum\score())));

		$this->assert
			->boolean($asserter->wasSet())->isFalse()
			->exception(function() use ($asserter) {
					$asserter->contains(uniqid());
				}
			)
                ->isInstanceOf('mageekguy\atoum\exceptions\logic')
				->hasMessage('Array is undefined')
		;

		$asserter->setWith(array(uniqid(), uniqid(), $value = uniqid(), uniqid(), uniqid()));

		$score->reset();

		$this->assert
			->exception(function() use (& $line, $asserter, & $notInArray) { $line = __LINE__; $asserter->contains($notInArray = uniqid()); })
				->isInstanceOf('mageekguy\atoum\asserter\exception')
				->hasMessage(sprintf($test->getLocale()->_('%s does not contain %s'), $asserter, $asserter->getTypeOf($notInArray)))
			->integer($score->getPassNumber())->isEqualTo(0)
			->integer($score->getFailNumber())->isEqualTo(1)
			->array($score->getFailAssertions())->isEqualTo(array(
					array(
						'case' => null,
						'class' => __CLASS__,
						'method' => $test->getCurrentMethod(),
						'file' => __FILE__,
						'line' => $line,
						'asserter' => get_class($asserter) . '::contains()',
						'fail' => $failMessage = sprintf($test->getLocale()->_('%s does not contain %s'), $asserter, $asserter->getTypeOf($notInArray))
					)
				)
			)
		;

		$this->assert
			->object($asserter->contains($value))->isIdenticalTo($asserter)
			->integer($score->getPassNumber())->isEqualTo(1)
			->integer($score->getFailNumber())->isEqualTo(1)
		;

        $score->reset();
        $this->assert
                ->object($asserter->contains("$value"))->isIdenticalTo($asserter)
                ->integer($score->getPassNumber())->isEqualTo(1)
                ->integer($score->getFailNumber())->isZero()
        ;
	}

	public function testContainsValues()
	{
		$asserter = new asserters\phpArray(new asserter\generator($test = new self($score = new atoum\score())));

		$this->assert
			->boolean($asserter->wasSet())->isFalse()
			->exception(function() use ($asserter) {
					$asserter->contains(uniqid());
				}
			)
                ->isInstanceOf('mageekguy\atoum\exceptions\logic')
				->hasMessage('Array is undefined')
		;

        $asserter->setWith(array(1, 2, 3, 4, 5));

        $score->reset();

		$this->assert
			->exception(function() use (& $line, $asserter) { $line = __LINE__; $asserter->containsValues(array(6)); })
				->isInstanceOf('mageekguy\atoum\asserter\exception')
				->hasMessage(sprintf($test->getLocale()->_('%s does not contain values %s'), $asserter, $asserter->getTypeOf(array(6))))
			->integer($score->getPassNumber())->isEqualTo(0)
			->integer($score->getFailNumber())->isEqualTo(1)
			->array($score->getFailAssertions())->isEqualTo(array(
					array(
						'case' => null,
						'class' => __CLASS__,
						'method' => $test->getCurrentMethod(),
						'file' => __FILE__,
						'line' => $line,
						'asserter' => get_class($asserter) . '::containsValues()',
						'fail' => $failMessage = sprintf($test->getLocale()->_('%s does not contain values %s'), $asserter, $asserter->getTypeOf(array(6)))
					)
				)
			)
		;

        $score->reset();
        $this->assert
            ->exception(function() use (& $line, $asserter, & $notInArray) { $line = __LINE__; $asserter->containsValues(array("$notInArray")); })
                ->isInstanceOf('mageekguy\atoum\asserter\exception')
                ->hasMessage(sprintf($test->getLocale()->_('%s does not contain values %s'), $asserter, $asserter->getTypeOf(array("$notInArray"))))
            ->integer($score->getPassNumber())->isEqualTo(0)
            ->integer($score->getFailNumber())->isEqualTo(1)
            ->array($score->getFailAssertions())->isEqualTo(array(
                    array(
                        'case' => null,
                        'class' => __CLASS__,
                        'method' => $test->getCurrentMethod(),
                        'file' => __FILE__,
                        'line' => $line,
                        'asserter' => get_class($asserter) . '::containsValues()',
                        'fail' => $failMessage = sprintf($test->getLocale()->_('%s does not contain values %s'), $asserter, $asserter->getTypeOf(array("$notInArray")))
                    )
                )
            )
        ;

        $score->reset();
        $this->assert
            ->object($asserter->containsValues(array(1)))->isIdenticalTo($asserter)
            ->integer($score->getPassNumber())->isEqualTo(1)
            ->integer($score->getFailNumber())->isEqualTo(0)
        ;

        $score->reset();
        $this->assert
            ->object($asserter->containsValues(array(1, 2, 4)))->isIdenticalTo($asserter)
            ->integer($score->getPassNumber())->isEqualTo(1)
            ->integer($score->getFailNumber())->isEqualTo(0)
        ;

        $score->reset();
        $this->assert
            ->object($asserter->containsValues(array("1", 2, "4")))->isIdenticalTo($asserter)
            ->integer($score->getPassNumber())->isEqualTo(1)
            ->integer($score->getFailNumber())->isEqualTo(0)
        ;
	}

	public function testNotContainsValues()
	{
		$asserter = new asserters\phpArray(new asserter\generator($test = new self($score = new atoum\score())));

		$this->assert
			->boolean($asserter->wasSet())->isFalse()
			->exception(function() use ($asserter) {
					$asserter->contains(uniqid());
					}
					)
			->isInstanceOf('mageekguy\atoum\exceptions\logic')
			->hasMessage('Array is undefined')
			;

		$asserter->setWith(array(1, 2, 3, 4, 5));

		$score->reset();

		$this->assert
			->exception(function() use (& $line, $asserter) { $line = __LINE__; $asserter->notContainsValues(array(1, 6)); })
			->isInstanceOf('mageekguy\atoum\asserter\exception')
			->hasMessage(sprintf($test->getLocale()->_('%s should not contain values %s'), $asserter, $asserter->getTypeOf(array(1))))
			->integer($score->getPassNumber())->isEqualTo(0)
			->integer($score->getFailNumber())->isEqualTo(1)
			->array($score->getFailAssertions())->isEqualTo(array(
						array(
							'case' => null,
							'class' => __CLASS__,
							'method' => $test->getCurrentMethod(),
							'file' => __FILE__,
							'line' => $line,
							'asserter' => get_class($asserter) . '::notContainsValues()',
							'fail' => $failMessage = sprintf($test->getLocale()->_('%s should not contain values %s'), $asserter, $asserter->getTypeOf(array(1)))
							)
						)
					)
			;

		$score->reset();
		$this->assert
			->exception(function() use (& $line, $asserter) { $line = __LINE__; $asserter->notContainsValues(array("1", "6")); })
			->isInstanceOf('mageekguy\atoum\asserter\exception')
			->hasMessage(sprintf($test->getLocale()->_('%s should not contain values %s'), $asserter, $asserter->getTypeOf(array("1"))))
			->integer($score->getPassNumber())->isEqualTo(0)
			->integer($score->getFailNumber())->isEqualTo(1)
			->array($score->getFailAssertions())->isEqualTo(array(
						array(
							'case' => null,
							'class' => __CLASS__,
							'method' => $test->getCurrentMethod(),
							'file' => __FILE__,
							'line' => $line,
							'asserter' => get_class($asserter) . '::notContainsValues()',
							'fail' => $failMessage = sprintf($test->getLocale()->_('%s should not contain values %s'), $asserter, $asserter->getTypeOf(array("1")))
							)
						)
					)
			;

		$score->reset();
		$this->assert
			->object($asserter->containsValues(array(1)))->isIdenticalTo($asserter)
			->integer($score->getPassNumber())->isEqualTo(1)
			->integer($score->getFailNumber())->isEqualTo(0)
			;

		$score->reset();
		$this->assert
			->object($asserter->containsValues(array(1, 2, 4)))->isIdenticalTo($asserter)
			->integer($score->getPassNumber())->isEqualTo(1)
			->integer($score->getFailNumber())->isEqualTo(0)
			;

		$score->reset();
		$this->assert
			->object($asserter->containsValues(array("1", 2, "4")))->isIdenticalTo($asserter)
			->integer($score->getPassNumber())->isEqualTo(1)
			->integer($score->getFailNumber())->isEqualTo(0)
			;
	}

	public function testStrictlyContainsValues()
	{
		$asserter = new asserters\phpArray(new asserter\generator($test = new self($score = new atoum\score())));

		$this->assert
			->boolean($asserter->wasSet())->isFalse()
			->exception(function() use ($asserter) {
					$asserter->contains(uniqid());
				}
			)
                ->isInstanceOf('mageekguy\atoum\exceptions\logic')
				->hasMessage('Array is undefined')
		;

        $asserter->setWith(array(1, 2, 3, 4, 5));

        $score->reset();

		$this->assert
			->exception(function() use (& $line, $asserter, & $notInArray) { $line = __LINE__; $asserter->strictlyContainsValues(array(6)); })
				->isInstanceOf('mageekguy\atoum\asserter\exception')
				->hasMessage(sprintf($test->getLocale()->_('%s does not contain strictly values %s'), $asserter, $asserter->getTypeOf(array(6))))
			->integer($score->getPassNumber())->isEqualTo(0)
			->integer($score->getFailNumber())->isEqualTo(1)
			->array($score->getFailAssertions())->isEqualTo(array(
					array(
						'case' => null,
						'class' => __CLASS__,
						'method' => $test->getCurrentMethod(),
						'file' => __FILE__,
						'line' => $line,
						'asserter' => get_class($asserter) . '::strictlyContainsValues()',
						'fail' => $failMessage = sprintf($test->getLocale()->_('%s does not contain strictly values %s'), $asserter, $asserter->getTypeOf(array(6)))
					)
				)
			)
		;

        $score->reset();
        $this->assert
            ->exception(function() use (& $line, $asserter, & $notInArray) { $line = __LINE__; $asserter->strictlyContainsValues(array("6")); })
                ->isInstanceOf('mageekguy\atoum\asserter\exception')
                ->hasMessage(sprintf($test->getLocale()->_('%s does not contain strictly values %s'), $asserter, $asserter->getTypeOf(array("6"))))
            ->integer($score->getPassNumber())->isEqualTo(0)
            ->integer($score->getFailNumber())->isEqualTo(1)
            ->array($score->getFailAssertions())->isEqualTo(array(
                    array(
                        'case' => null,
                        'class' => __CLASS__,
                        'method' => $test->getCurrentMethod(),
                        'file' => __FILE__,
                        'line' => $line,
                        'asserter' => get_class($asserter) . '::strictlyContainsValues()',
                        'fail' => $failMessage = sprintf($test->getLocale()->_('%s does not contain strictly values %s'), $asserter, $asserter->getTypeOf(array("6")))
                    )
                )
            )
        ;

        $score->reset();
        $this->assert
            ->exception(function() use (& $line, $asserter, & $notInArray) { $line = __LINE__; $asserter->strictlyContainsValues(array("1")); })
                ->isInstanceOf('mageekguy\atoum\asserter\exception')
                ->hasMessage(sprintf($test->getLocale()->_('%s does not contain strictly values %s'), $asserter, $asserter->getTypeOf(array("1"))))
            ->integer($score->getPassNumber())->isEqualTo(0)
            ->integer($score->getFailNumber())->isEqualTo(1)
            ->array($score->getFailAssertions())->isEqualTo(array(
                    array(
                        'case' => null,
                        'class' => __CLASS__,
                        'method' => $test->getCurrentMethod(),
                        'file' => __FILE__,
                        'line' => $line,
                        'asserter' => get_class($asserter) . '::strictlyContainsValues()',
                        'fail' => $failMessage = sprintf($test->getLocale()->_('%s does not contain strictly values %s'), $asserter, $asserter->getTypeOf(array("1")))
                    )
                )
            )
        ;

        $score->reset();
        $this->assert
            ->object($asserter->strictlyContainsValues(array(1)))->isIdenticalTo($asserter)
            ->integer($score->getPassNumber())->isEqualTo(1)
            ->integer($score->getFailNumber())->isEqualTo(0)
        ;

        $score->reset();
        $this->assert
            ->object($asserter->strictlyContainsValues(array(1, 2, 4)))->isIdenticalTo($asserter)
            ->integer($score->getPassNumber())->isEqualTo(1)
            ->integer($score->getFailNumber())->isEqualTo(0)
        ;

        $score->reset();
        $this->assert
                ->exception(function() use (& $line, $asserter) { $line = __LINE__; $asserter->strictlyContainsValues(array("1", 2, "4")); })
                    ->isInstanceOf('mageekguy\atoum\asserter\exception')
                    ->hasMessage(sprintf($test->getLocale()->_('%s does not contain strictly values %s'), $asserter, $asserter->getTypeOf(array("1", "4"))))
                ->integer($score->getPassNumber())->isEqualTo(0)
                ->integer($score->getFailNumber())->isEqualTo(1)
                ->array($score->getFailAssertions())->isEqualTo(array(
                        array(
                            'case' => null,
                            'class' => __CLASS__,
                            'method' => $test->getCurrentMethod(),
                            'file' => __FILE__,
                            'line' => $line,
                            'asserter' => get_class($asserter) . '::strictlyContainsValues()',
                            'fail' => $failMessage = sprintf($test->getLocale()->_('%s does not contain strictly values %s'), $asserter, $asserter->getTypeOf(array("1", "4")))
                        )
                    )
                )
            ;
	}

	public function testStrictlyNotContainsValues()
	{
		$asserter = new asserters\phpArray(new asserter\generator($test = new self($score = new atoum\score())));

		$this->assert
			->boolean($asserter->wasSet())->isFalse()
			->exception(function() use ($asserter) {
					$asserter->contains(uniqid());
					}
					)
			->isInstanceOf('mageekguy\atoum\exceptions\logic')
			->hasMessage('Array is undefined')
			;

		$asserter->setWith(array(1, 2, 3, 4, 5));

		$score->reset();

		$this->assert
			->exception(function() use (& $line, $asserter) { $line = __LINE__; $asserter->strictlyNotContainsValues(array(1)); })
			->isInstanceOf('mageekguy\atoum\asserter\exception')
			->hasMessage(sprintf($test->getLocale()->_('%s should not contain strictly values %s'), $asserter, $asserter->getTypeOf(array(1))))
			->integer($score->getPassNumber())->isEqualTo(0)
			->integer($score->getFailNumber())->isEqualTo(1)
			->array($score->getFailAssertions())->isEqualTo(array(
						array(
							'case' => null,
							'class' => __CLASS__,
							'method' => $test->getCurrentMethod(),
							'file' => __FILE__,
							'line' => $line,
							'asserter' => get_class($asserter) . '::strictlyNotContainsValues()',
							'fail' => $failMessage = sprintf($test->getLocale()->_('%s should not contain strictly values %s'), $asserter, $asserter->getTypeOf(array(1)))
							)
						)
					)
			;

		$score->reset();
		$this->assert
			->exception(function() use (& $line, $asserter) { $line = __LINE__; $asserter->strictlyNotContainsValues(array(1, "2", 3)); })
			->isInstanceOf('mageekguy\atoum\asserter\exception')
			->hasMessage(sprintf($test->getLocale()->_('%s should not contain strictly values %s'), $asserter, $asserter->getTypeOf(array(1, 3))))
			->integer($score->getPassNumber())->isEqualTo(0)
			->integer($score->getFailNumber())->isEqualTo(1)
			->array($score->getFailAssertions())->isEqualTo(array(
						array(
							'case' => null,
							'class' => __CLASS__,
							'method' => $test->getCurrentMethod(),
							'file' => __FILE__,
							'line' => $line,
							'asserter' => get_class($asserter) . '::strictlyNotContainsValues()',
							'fail' => $failMessage = sprintf($test->getLocale()->_('%s should not contain strictly values %s'), $asserter, $asserter->getTypeOf(array(1, 3)))
							)
						)
					)
			;

		$score->reset();
		$this->assert
			->object($asserter->strictlyNotContainsValues(array("1")))->isIdenticalTo($asserter)
			->integer($score->getPassNumber())->isEqualTo(1)
			->integer($score->getFailNumber())->isEqualTo(0)
			;

		$score->reset();
		$this->assert
			->object($asserter->strictlyNotContainsValues(array(6, 7, "2", 8)))->isIdenticalTo($asserter)
			->integer($score->getPassNumber())->isEqualTo(1)
			->integer($score->getFailNumber())->isEqualTo(0)
			;
	}

	public function testStrictlyContains ()
	{
		$asserter = new asserters\phpArray(new asserter\generator($test = new self($score = new atoum\score())));

		$asserter->setWith(array(1));
		$score->reset();
		$this->assert
			->exception(function() use ($asserter) {$asserter->strictlyContains('1'); })
			->isInstanceOf('mageekguy\atoum\asserter\exception')
			->integer($score->getPassNumber())->isEqualTo(0)
			->integer($score->getFailNumber())->isEqualTo(1);

		$score->reset();
		$this->assert
			->object($asserter->strictlyContains(1))->isIdenticalTo($asserter)
			->integer($score->getPassNumber())->isEqualTo(1)
			->integer($score->getFailNumber())->isEqualTo(0);
	}

	public function testStrictlyNotContains ()
	{
		$asserter = new asserters\phpArray(new asserter\generator($test = new self($score = new atoum\score())));

		$asserter->setWith(array(1));

		$score->reset();
		$this->assert
			->exception(function() use ($asserter) {$asserter->strictlyNotContains(1); })
			->isInstanceOf('mageekguy\atoum\asserter\exception')
			->integer($score->getPassNumber())->isEqualTo(0)
			->integer($score->getFailNumber())->isEqualTo(1);

		$score->reset();
		$this->assert
			->object($asserter->strictlyNotContains('1'))->isIdenticalTo($asserter)
			->integer($score->getPassNumber())->isEqualTo(1)
			->integer($score->getFailNumber())->isEqualTo(0);
	}

	public function testNotContains()
	{
		$asserter = new asserters\phpArray(new asserter\generator($test = new self($score = new atoum\score())));

		$this->assert
			->boolean($asserter->wasSet())->isFalse()
			->exception(function() use ($asserter) {
					$asserter->notContains(uniqid());
				}
			)
				->isInstanceOf('mageekguy\atoum\exceptions\logic')
				->hasMessage('Array is undefined')
		;

		$asserter->setWith(array(uniqid(), uniqid(), $inArray = uniqid(), uniqid(), uniqid()));

		$score->reset();

		$this->assert
			->integer($score->getPassNumber())->isEqualTo(0)
			->integer($score->getFailNumber())->isEqualTo(0)
			->object($asserter->notContains(uniqid()))->isIdenticalTo($asserter)
			->integer($score->getPassNumber())->isEqualTo(1)
			->integer($score->getFailNumber())->isEqualTo(0)
			->exception(function() use (& $line, $asserter, $inArray) { $line = __LINE__; $asserter->notContains($inArray); })
				->isInstanceOf('mageekguy\atoum\asserter\exception')
				->hasMessage(sprintf($test->getLocale()->_('%s contains %s'), $asserter, $asserter->getTypeOf($inArray)))
			->integer($score->getPassNumber())->isEqualTo(1)
			->integer($score->getFailNumber())->isEqualTo(1)
			->array($score->getFailAssertions())->isEqualTo(array(
					array(
						'case' => null,
						'class' => __CLASS__,
						'method' => $test->getCurrentMethod(),
						'file' => __FILE__,
						'line' => $line,
						'asserter' => get_class($asserter) . '::notContains()',
						'fail' => $failMessage = sprintf($test->getLocale()->_('%s contains %s'), $asserter, $asserter->getTypeOf($inArray))
					)
				)
			)
		;

        $score->reset();
        $this->assert
                ->exception(function() use($asserter, $inArray){
                                $asserter->notContains("$inArray");
                            })
                ->integer($score->getPassNumber())->isEqualTo(0)
                ->integer($score->getFailNumber())->isEqualTo(1)
        ;
	}

	public function testHasKey ()
	{
		$asserter = new asserters\phpArray(new asserter\generator($test = new self($score = new atoum\score())));

		$this->assert
			->boolean($asserter->wasSet())->isFalse()
			->exception(function() use ($asserter) {
					$asserter->hasSize(rand(0, PHP_INT_MAX));
					}
					)
			->isInstanceOf('mageekguy\atoum\exceptions\logic')
			->hasMessage('Array is undefined')
			;

		$asserter->setWith(array());

		$score->reset();

		$this->assert
			->exception(function() use (& $line, $asserter, & $key) { $line = __LINE__; $asserter->hasKey($key = rand(1, PHP_INT_MAX)); })
			->isInstanceOf('mageekguy\atoum\asserter\exception')
			->hasMessage(sprintf($test->getLocale()->_('%s has no key %s'), $asserter, $asserter->getTypeOf($key)))
			->integer($score->getPassNumber())->isEqualTo(0)
			->integer($score->getFailNumber())->isEqualTo(1)
			->array($score->getFailAssertions())->isEqualTo(array(
						array(
							'case' => null,
							'class' => __CLASS__,
							'method' => $test->getCurrentMethod(),
							'file' => __FILE__,
							'line' => $line,
							'asserter' => get_class($asserter) . '::hasKey()',
							'fail' => $failMessage = sprintf($test->getLocale()->_('%s has no key %s'), $asserter, $asserter->getTypeOf($key))
							)
						)
					)
			;

		$asserter->setWith(array(uniqid(), uniqid(), uniqid(), uniqid(), uniqid()));

		$score->reset();

		$this->assert
			->object($asserter->hasKey(0))->isIdenticalTo($asserter)
			->integer($score->getPassNumber())->isEqualTo(1)
			->integer($score->getFailNumber())->isEqualTo(0)
			->object($asserter->hasKey(1))->isIdenticalTo($asserter)
			->integer($score->getPassNumber())->isEqualTo(2)
			->integer($score->getFailNumber())->isEqualTo(0)
			->object($asserter->hasKey(2))->isIdenticalTo($asserter)
			->integer($score->getPassNumber())->isEqualTo(3)
			->integer($score->getFailNumber())->isEqualTo(0)
			->object($asserter->hasKey(3))->isIdenticalTo($asserter)
			->integer($score->getPassNumber())->isEqualTo(4)
			->integer($score->getFailNumber())->isEqualTo(0)
			->object($asserter->hasKey(4))->isIdenticalTo($asserter)
			->integer($score->getPassNumber())->isEqualTo(5)
			->integer($score->getFailNumber())->isEqualTo(0)
			->exception(function() use (& $line, $asserter) { $line = __LINE__; $asserter->hasKey(5); })
			->isInstanceOf('mageekguy\atoum\asserter\exception')
			->hasMessage(sprintf($test->getLocale()->_('%s has no key %s'), $asserter, $asserter->getTypeOf(5)))
			->integer($score->getPassNumber())->isEqualTo(5)
			->integer($score->getFailNumber())->isEqualTo(1)
			->array($score->getFailAssertions())->isEqualTo(array(
						array(
							'case' => null,
							'class' => __CLASS__,
							'method' => $test->getCurrentMethod(),
							'file' => __FILE__,
							'line' => $line,
							'asserter' => get_class($asserter) . '::hasKey()',
							'fail' => $failMessage = sprintf($test->getLocale()->_('%s has no key %s'), $asserter, $asserter->getTypeOf(5))
							)
						)
					)
			;
	}

	public function testNotHasKey ()
	{
		$asserter = new asserters\phpArray(new asserter\generator($test = new self($score = new atoum\score())));

		$this->assert
			->boolean($asserter->wasSet())->isFalse()
			->exception(function() use ($asserter) {
					$asserter->hasSize(rand(0, PHP_INT_MAX));
					}
					)
			->isInstanceOf('mageekguy\atoum\exceptions\logic')
			->hasMessage('Array is undefined')
			;

		$asserter->setWith(array());

		$score->reset();
		$this->assert
			->object($asserter->notHasKey(1))
			->isIdenticalTo($asserter)
			->integer($score->getPassNumber())->isEqualTo(1)
			->integer($score->getFailNumber())->isEqualTo(0);

		$asserter->setWith(array(uniqid(), uniqid(), uniqid(), uniqid(), uniqid()));

		$score->reset();
		$this->assert
			->exception(function() use (& $line, $asserter) { $line = __LINE__; $asserter->notHasKey(0); })
			->isInstanceOf('mageekguy\atoum\asserter\exception')
			->hasMessage(sprintf($test->getLocale()->_('%s has a key %s'), $asserter, $asserter->getTypeOf(0)))
			->integer($score->getPassNumber())->isEqualTo(0)
			->integer($score->getFailNumber())->isEqualTo(1)
			->array($score->getFailAssertions())->isEqualTo(array(
						array(
							'case' => null,
							'class' => __CLASS__,
							'method' => $test->getCurrentMethod(),
							'file' => __FILE__,
							'line' => $line,
							'asserter' => get_class($asserter) . '::notHasKey()',
							'fail' => $failMessage = sprintf($test->getLocale()->_('%s has a key %s'), $asserter, $asserter->getTypeOf(0))
							)
						)
					)
			->object($asserter->notHasKey(5))
			->isIdenticalTo($asserter)
			->integer($score->getPassNumber())->isEqualTo(1)
			->integer($score->getFailNumber())->isEqualTo(1);
		;
	}

	public function testNotHasKeys ()
	{
		$asserter = new asserters\phpArray(new asserter\generator($test = new self($score = new atoum\score())));

		$this->assert
			->boolean($asserter->wasSet())->isFalse()
			->exception(function() use ($asserter) {
					$asserter->hasSize(rand(0, PHP_INT_MAX));
					}
					)
			->isInstanceOf('mageekguy\atoum\exceptions\logic')
			->hasMessage('Array is undefined')
			;

		$asserter->setWith(array());

		$score->reset();
		$this->assert
			->object($asserter->notHasKeys(array(1)))
			->isIdenticalTo($asserter)
			->integer($score->getPassNumber())->isEqualTo(1)
			->integer($score->getFailNumber())->isEqualTo(0);

		$score->reset();
		$this->assert
			->object($asserter->notHasKeys(array(0, 1)))
			->isIdenticalTo($asserter)
			->integer($score->getPassNumber())->isEqualTo(1)
			->integer($score->getFailNumber())->isEqualTo(0);

		$asserter->setWith(array(uniqid(), uniqid(), uniqid(), uniqid(), uniqid()));

		$score->reset();
		$this->assert
			->exception(function() use (& $line, $asserter) { $line = __LINE__; $asserter->notHasKeys(array(0, "premier", 2)); })
			->isInstanceOf('mageekguy\atoum\asserter\exception')
			->hasMessage(sprintf($test->getLocale()->_('%s should not have keys %s'), $asserter, $asserter->getTypeOf(array(0, 2))))
			->integer($score->getPassNumber())->isEqualTo(0)
			->integer($score->getFailNumber())->isEqualTo(1)
			->array($score->getFailAssertions())->isEqualTo(array(
						array(
							'case' => null,
							'class' => __CLASS__,
							'method' => $test->getCurrentMethod(),
							'file' => __FILE__,
							'line' => $line,
							'asserter' => get_class($asserter) . '::notHasKeys()',
							'fail' => $failMessage = sprintf($test->getLocale()->_('%s should not have keys %s'), $asserter, $asserter->getTypeOf(array(0, 2)))
							)
						)
					)
			->object($asserter->notHasKeys(array(5, "6")))
			->isIdenticalTo($asserter)
			->integer($score->getPassNumber())->isEqualTo(1)
			->integer($score->getFailNumber())->isEqualTo(1);
		;
	}

	public function testHasKeys ()
	{
		$asserter = new asserters\phpArray(new asserter\generator($test = new self($score = new atoum\score())));

		$this->assert
			->boolean($asserter->wasSet())->isFalse()
			->exception(function() use ($asserter) {
					$asserter->hasSize(rand(0, PHP_INT_MAX));
					}
					)
			->isInstanceOf('mageekguy\atoum\exceptions\logic')
			->hasMessage('Array is undefined')
			;

		$asserter->setWith(array());

		$score->reset();
		$this->assert
			->exception(function() use (& $line, $asserter) { $line = __LINE__; $asserter->hasKeys(array(0)); })
			->isInstanceOf('mageekguy\atoum\asserter\exception')
			->hasMessage(sprintf($test->getLocale()->_('%s should have keys %s'), $asserter, $asserter->getTypeOf(array(0))))
			->integer($score->getPassNumber())->isEqualTo(0)
			->integer($score->getFailNumber())->isEqualTo(1)
			->array($score->getFailAssertions())->isEqualTo(array(
						array(
							'case' => null,
							'class' => __CLASS__,
							'method' => $test->getCurrentMethod(),
							'file' => __FILE__,
							'line' => $line,
							'asserter' => get_class($asserter) . '::hasKeys()',
							'fail' => $failMessage = sprintf($test->getLocale()->_('%s should have keys %s'), $asserter, $asserter->getTypeOf(array(2)))
							)
						)
					);

		$asserter->setWith(array(uniqid(), uniqid(), uniqid(), uniqid(), uniqid()));

		$score->reset();
		$this->assert
			->exception(function() use (& $line, $asserter) { $line = __LINE__; $asserter->hasKeys(array(0, "first", 2, "second")); })
			->isInstanceOf('mageekguy\atoum\asserter\exception')
			->hasMessage(sprintf($test->getLocale()->_('%s should have keys %s'), $asserter, $asserter->getTypeOf(array("first", "second"))))
			->integer($score->getPassNumber())->isEqualTo(0)
			->integer($score->getFailNumber())->isEqualTo(1)
			->array($score->getFailAssertions())->isEqualTo(array(
						array(
							'case' => null,
							'class' => __CLASS__,
							'method' => $test->getCurrentMethod(),
							'file' => __FILE__,
							'line' => $line,
							'asserter' => get_class($asserter) . '::hasKeys()',
							'fail' => $failMessage = sprintf($test->getLocale()->_('%s should have keys %s'), $asserter, $asserter->getTypeOf(array("first", "second")))
							)
						)
					)
			->object($asserter->hasKeys(array(0, 2, 4)))
			->isIdenticalTo($asserter)
			->integer($score->getPassNumber())->isEqualTo(1)
			->integer($score->getFailNumber())->isEqualTo(1);
		;
	}
}

?>
