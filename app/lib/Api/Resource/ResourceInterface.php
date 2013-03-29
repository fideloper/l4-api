<?php namespace Api\Resource;

interface ResourceInterface {

	public function getEtag($regen=false);

    public function setResourceName($name);

    public function getResourceName();

}