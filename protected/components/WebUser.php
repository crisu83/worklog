<?php

class WebUser extends CWebUser
{
	const ENTRY_STATUS_STOPPED = 0;
	const ENTRY_STATUS_RUNNING = 1;
	const ENTRY_STATUS_PAUSED = 2;
	
	public function setEntry($value)
	{
		$this->setState('entry', $value);
	}
	
	public function getEntry()
	{
		return $this->getState('entry');
	}
	
	public function setEntryStatus($value)
	{
		$this->setState('entryStatus', $value);
	}
	
	public function getEntryStatus()
	{
		return $this->getState('entryStatus');
	}
}
