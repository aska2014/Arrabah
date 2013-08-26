<?php

interface AcceptableInterface {

	/**
	 * Accept current object.
	 *
	 * @return void
	 */
	public function accept();

	/**
	 * Unaccept current object.
	 *
	 * @return void
	 */
	public function unaccept();

	/**
	 * Throws an exception if not accepted
	 *
	 * @throws NotAcceptedException
	 * @return void
	 */
	public function failIfNotAccepted();

}