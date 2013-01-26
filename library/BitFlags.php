<?php 

class VBitFlags
{
	private  $allFlags = 0x0000000;

	function __construct($ini_flags=0x0000000)
	{
		$this->allFlags = $ini_flags;
	}
	
	/**
	 * function - checks if bit $flag set in $value
	 * returns new value of $all_flag
	 */
	public function isFlagSet($val, $flag)
	{
		return (($val & $flag) === $flag);
	}

	/**
	 * function - sets bit $flag to $all_flags.
	 * returns new value of $all_flags
	 */
	public function setFlag($flag, $all_flags)
	{
		return	$all_flags |= $flag;
	}

	/**
	 * function - removes bit $flag from $all_flags.
	 * returns new value of $all_flags
	 */
	public function removeFlag($flag, $all_flags)
	{
		return	$all_flags &= ~$flag;
	}

	/**
	 * function - removes all bits from class property $this->allFlags.
	 * returns new value of $this->allFlags
	 */
	public function removeAllFlags()
	{
		return	$this->allFlags &= ~($this->allFlags);
	}

	/**
	 * function - removes given bit $flag from class property $this->allFlags.
	 * 
	 */
	function removeFlagFromAllFlags($flag)
	{
		$this->allFlags = $this->removeFlag($flag, $this->allFlags);
	}

	/**
	 * function - sets bit $flag to class property $this->allFlags.
	 * 
	 */
	function setFlagToAllFlags($flag)
	{
		$this->allFlags = $this->setFlag($flag, $this->allFlags);
	}

	/**
	 * function - checks if bit $flag is set in class property $this->allFlags.
	 * returns true ( the bit is set ), false ( the bit is not set )
	 */
	public function  isFlagSetInAllFlags($flag)
	{
		return $this->isFlagSet( $this->allFlags, $flag) ;
	}

}


?>