<?php

interface OwnedByUserInterface {

	/**
	 * Get user for this object.
	 *
	 * @return MemberInterface
	 */
	public function getUser();

}