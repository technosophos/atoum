<?php

namespace mageekguy\atoum\report\fields\runner;

use
	mageekguy\atoum,
	mageekguy\atoum\runner,
	mageekguy\atoum\report
;

abstract class coverage extends report\field
{
	protected $coverage = null;

	public function __construct(atoum\locale $locale = null)
	{
		parent::__construct(array(runner::runStop), $locale);
	}

	public function getCoverage()
	{
		return $this->coverage;
	}

	public function handleEvent($event, atoum\observable $observable)
	{
		if (parent::handleEvent($event, $observable) === false)
		{
			return false;
		}
		else
		{
			$this->coverage = $observable->getScore()->getCoverage();

			return true;
		}
	}
}

?>
