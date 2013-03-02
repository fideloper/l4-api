<?php namespace Api\Resource;

interface ResourceInterface {

	public function getEtag();

    public function setResourceName($name);

    public function getResourceName();

}